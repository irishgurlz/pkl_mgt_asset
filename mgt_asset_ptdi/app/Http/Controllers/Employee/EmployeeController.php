<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Employee;
use App\Models\Actor;
use App\Models\Organisasi;
use App\Models\Jabatan;
use App\Models\Test;
use App\Models\Admin;
use App\Imports\EmployeeImport;
// use Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Models\Distribution;
use App\Models\DistributionDetail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $actors = Actor::with('employee')
            // ->whereNull('super_user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nik', 'like', "%$search%")
                        ->orWhereHas('employee', function ($q) use ($search) {
                            $q->where('nama', 'like', "%$search%")
                                ->orWhereHas('org', function ($q) use ($search) {
                                    $q->where('nama', 'like', "%$search%");
                                })
                                ->orWhereHas('jabatan', function ($q) use ($search) {
                                    $q->where('nama', 'like', "%$search%");
                                });
                        });
                })
                ->orWhere(function($q) use ($search) { 
                    if (strpos($search, ' & ') !== false) {
                        $q->where('role', 'like', "%$search%");
                    } else {
                        $roles = explode(' & ', $search);
                        foreach ($roles as $role) {
                            $q->orWhere('role', 'like', "%$role%");
                        }
                    }
                });
            })->paginate(20);
    
        $actor = $actors->map(function ($item) {
            return [
                'nik' => $item->nik,
                'roles' => explode(',', $item->role),
                'nama' => optional($item->employee)->nama ?? 'Tidak ada nama',
                'org' => optional($item->employee->org)->nama ?? '-',
                'jabatan' => optional($item->employee->jabatan)->nama ?? '-',
            ];
        })->groupBy('nik')->map(function ($items) {
            $firstItem = $items->first();
            return [
                'nik' => $firstItem['nik'],
                'roles' => implode(' & ', array_unique($items->pluck('roles')->flatten()->toArray())),
                'nama' => $firstItem['nama'],
                'org' => $firstItem['org'],
                'jabatan' => $firstItem['jabatan'],
            ];
        });  
    
        $admin = Actor::where('role', 'like', '%admin%')->count();
        if ($request->ajax()) {
            return view('employee.component.table-employee', compact('actor', 'actors', 'admin'));
        }

        $admin = Actor::where('role', 'like', '%admin%')->count();
    
        return view('employee.employee.daftar_employee', compact('actor', 'admin', 'actors'));
    }
    
    public function create()
    {

        $org = Organisasi::all();
        $jabatan = Jabatan::all();
        return view ('employee.employee.create', compact('org', 'jabatan'));
    }

    
     public function store(Request $request)
     {
        $request->validate([
            'nik' => 'required|string|max:255|unique:employee,nik',
            'nama' => 'required|string|max:255',
            'kode_org' => 'required|exists:organisasi,kode_org',
            'kode_jabatan' => 'required|exists:jabatan,id',
            'password' => 'required|min:3'
         ]);

         $org = Organisasi::where('kode_org', $request->kode_org)->first();
         $jabatan = Jabatan::where('id', $request->kode_jabatan)->first();

        $employee = Employee::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'kode_org' => $org->kode_org,
            'kode_jabatan' => $jabatan->id,
        ]);

        $employee->actors()->create([
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        return redirect('/employee')->with('success', 'Employee berhasil ditambahkan.');


    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // $actor
        $org = Organisasi::all(); 
        $jabatan = Jabatan::all();
        $employee = Employee::where('nik', $id)->first();
        return view('employee.employee.edit', compact('org', 'jabatan', 'employee'));
    }


    public function update(Request $request, string $id)
    {
        $employee = Employee::where('nik', $id)->first();
        $request->validate([
            'nik' => 'required|string|max:255|unique:employee,nik,' . $employee->id,
            'nama' => 'required|string|max:255',
            'kode_org' => 'required|exists:organisasi,kode_org',
            'kode_jabatan' => 'required|exists:jabatan,id',
            'password' => 'required|min:3'
        ]);
        
        $oldNik = $employee->kode_;
        $newNik = $request->nik;
        

        
        $admin = Admin::where('nama', $employee->nama)->first();
        if ($admin) {
            $admin->update([
                'nama' => $request->nama,
            ]);
        }

        $employee->update([
            'nik' => $newNik,
            'nama' => $request->nama,
            'kode_org' => $request->kode_org,
            'kode_jabatan' => $request->kode_jabatan,
        ]);

        $employee->actors()->update([
            'nik' => $newNik,
            'password' => Hash::make($request->password),
        ]);

    
        return redirect('/employee')->with('success', 'Data berhasil diperbarui!');
    }
    

    public function destroy(string $id)
    {

        $user = auth()->user()->nik;
        // dd($id, $user);
        // $authenticate = Actor::where($id, $user)->first();
        if ($id == $user) {
            return redirect('/employee')->with('error', 'Employee tidak bisa dihapus karena NIK sedang Anda gunakan.');
        }
        $actor = Actor::where('nik', $id)->first();
        $actor->delete();
        
        $employee = Employee::where('nik', $id)->first();
        $employee->delete();
        
        $admin = Admin::where('nama', $employee->nama)->first();
        if ($admin) {
            $admin->delete();
        }
        return redirect('/employee')->with('success', 'Employee berhasil dihapus.');
    }

    public function detailAsset(Request $request, string $id){
        $employee = Employee::where('nik', $id)->first();
        $distribution = DistributionDetail::query();

        $search = $request->input('search');
    
        if ($search) {
            $distribution->where(function ($query) use ($search) {
                $query->where('nomor_penyerahan', 'LIKE', "%{$search}%")
                      ->orWhereHas('employee', function($query) use ($search) {
                          $query->where('nama', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('device', function($query) use ($search) {
                          $query->where('nomor_it', 'LIKE', "%{$search}%")
                                ->orWhereHas('kategori', function($query) use ($search) {
                                    $query->where('nama', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('subKategori', function($query) use ($search) {
                                    $query->where('nama', 'LIKE', "%{$search}%");
                                });
                      })
                      ->orWhereHas('asset', function($query) use ($search) {
                          $query->where('nomor_asset', 'LIKE', "%{$search}%")
                                ->orWhereHas('kategori', function($query) use ($search) {
                                    $query->where('nama', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('subKategori', function($query) use ($search) {
                                    $query->where('nama', 'LIKE', "%{$search}%");
                                });
                      })
                      ->orWhereRaw("CASE 
                            WHEN nomor_it IS NULL THEN 'Perlengkapan Kantor'
                            ELSE 'Perangkat Komputer' 
                        END LIKE ?", ['%' . $search . '%']);

                      
            });
        }
    
        $distribution = $distribution->with(['employee', 'device', 'asset', 'asset.kategori', 'asset.subKategori', 'device.kategori', 'device.subKategori', 'device.processorType', 'device.storageType', 'device.memoryType', 'device.vgaType', 'device.operationSystem', 'device.osLicense', 'device.officeType', 'device.officeLicense'])
            ->paginate(10);

        if ($request->ajax()) {
            return view('employee.employee.table-detail-asset', compact('distribution'));
        }
        return view('employee.employee.detail-asset', compact('distribution', 'employee'));
    }

    public function searchOrg(Request $request)
    {
        $search = $request->query('search');

        $orgs = Organisasi::where('nama', 'like', "%{$search}%")
            ->orWhere('kode_org', 'like', "%{$search}%")
            ->limit(10) // Batasi jumlah hasil untuk efisiensi
            ->get();

        return response()->json($orgs);
    }

    public function import_excel(){
        return view('employee.employee.import_excel');
    } 

    public function import_excel_post(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);
    
        if ($request->hasFile('excel_file')) {
            $import = new EmployeeImport();
            $import->import($request->file('excel_file'));
    
            return redirect('/employee')->with('success', 'Excel file has been imported successfully!');
        }
    
        return redirect('/employee')->with('error', 'No file selected.');
    }



}
