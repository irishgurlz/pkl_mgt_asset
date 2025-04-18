<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\Distribution;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\History;
use App\Models\HistoryPengajuan;
use App\Models\DistributionDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Validation\Rule;




class DistributionController extends Controller
{

    public function index(Request $request)
    {
        session()->forget('nomor_penyerahan');
        session()->forget('table');
        // session()->flush();

        $search = $request->input('search');

        $distribution = Distribution::when($search, function($query) use ($search) {
            return $query->where('nomor_penyerahan', 'like', '%'.$search.'%');
        })
        ->paginate(5);
        
        if ($request->ajax()) {
            return view('distribusi.table-distribusi', compact('distribution'));
        }
        
        $distribution = Distribution::paginate(5);
        // $asset = Asset::where('')
        $asset = Device::where('nomor_it', $request->nomor_it)->first();
        return view('distribusi.daftar_distribusi', compact('asset', 'distribution'));
    }
    

    public function create(Request $request)
    {
        $device = Device::all();
        $table = session('table');

        
        return view('distribusi.create', compact(
            ['device','table']));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nomor_penyerahan' => 'required|unique:distribution,nomor_penyerahan',
        ]);
    
        $distribution = Distribution::create([
            'nomor_penyerahan' => $request->nomor_penyerahan,
        ]);
        $nomorPenyerahan = $request->input('nomor_penyerahan');
        session(['nomor_penyerahan' => $nomorPenyerahan]);

        $table = DistributionDetail::where('nomor_penyerahan', $nomorPenyerahan)->paginate(5);
        session(['table' => $table]);
        
       return redirect('/distribusi/create')
       ->with('success', 'Nomor Penyerahan berhasil ditambahkan.')
       ->with('table', $table);
    }

    public function tambahAsset($id){
        $dist = Distribution::where('id', $id)->first();

        $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)->paginate(5);
        return view('distribusi.tambah-asset', compact('distribution','dist'));
    }

    public function tambahDistribusiAsset(Request $request, $id){
        $request->validate([
            'nomor_penyerahan' => 'required|exists:distribution,nomor_penyerahan',
            'nomor_asset' => 'array',
            'nomor_asset.*' => ['nullable', 'exists:asset,nomor_asset', Rule::unique('distribution_detail', 'nomor_asset'), Rule::exists('asset', 'nomor_asset')->where(fn ($query) => $query->where('kondisi', '!=', '0'))],
            'nomor_it' => 'array',
            'nomor_it.*' => ['nullable', 'exists:device,nomor_it', Rule::unique('distribution_detail', 'nomor_it')],
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            'deskripsi' => 'required|array',
            'deskripsi.*' => 'required|string',
            'file.*' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nik' => 'required|array',
            'nik.*' => 'required|exists:employee,nik',
            'lokasi' => 'required|array',
            'lokasi.*' => 'required|string',
        ]);

        $nomorITs = $request->input('nomor_it', []);

        $duplicates = array_diff_assoc($nomorITs, array_unique($nomorITs));
        
        if (!empty($duplicates)) {
            $errors = [];
            foreach ($duplicates as $index => $value) {
                $errors["nomor_it.$index"] = "Nomor Asset $value sudah didistribusi.";
            }
        
            return back()->withErrors($errors)->withInput();
        }


        
        $nomorasset = $request->input('nomor_asset', []);

        $duplicatesAs = array_diff_assoc($nomorasset, array_unique($nomorasset));
        
        if (!empty($duplicatesAs)) {
            $errors = [];
            foreach ($duplicatesAs as $index => $value) {
                $errors["nomor_asset.$index"] = "Nomor asset $value sudah didistribusi.";
            }
        
            return back()->withErrors($errors)->withInput();
        }
        
    
        try {
            $distributions = [];
            $histories = [];
            $nomor_asset = $request->nomor_asset;
            $nomor_it = $request->nomor_it;
    
            foreach (($nomor_asset ?? $nomor_it) as $key => $value) {
                $file = $request->file('file')[$key];
                $fileName = time() . '_' . $file->getClientOriginalName();  
                $file->move(public_path('dokumen'), $fileName);
    
                $distributions[] = [
                    'nomor_penyerahan' => $request->nomor_penyerahan,
                    'tanggal' => $request->tanggal[$key],
                    'deskripsi' => $request->deskripsi[$key],
                    'file' => 'dokumen/' . $fileName,
                    'nomor_it' => $request->nomor_it[$key] ?? null,
                    'nomor_asset' => $request->nomor_asset[$key] ?? null,
                    'nik' => $request->nik[$key],
                    'lokasi' => $request->lokasi[$key],
                    'status_pengalihan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
    
                $histories[] = [
                    'nomor_penyerahan' => $request->nomor_penyerahan,
                    'nomor_it' => $request->nomor_it[$key] ?? null,
                    'nomor_asset' => $request->nomor_asset[$key] ?? null,
                    'nik' => $request->nik[$key],
                    'status_pengalihan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
    
            DistributionDetail::insert($distributions);
            History::insert($histories);
    
            session(['nomor_penyerahan' => $request->nomor_penyerahan]);
            
    
            $table = DistributionDetail::with(['employee', 'asset.kategori', 'device.kategori'])->where('nomor_penyerahan', $request->nomor_penyerahan)->get();
            session(['table' => $table]);

            return redirect('/distribution-asset/create/'. $id)
            ->with('success', 'Perangkat berhasil ditambahkan.')
            ->with('table', $table);
            
        } catch (\Exception $e) {
            return redirect('/distribusi/create')
            ->with('false', 'Perangkat gagal ditambahkan.');
        }
    }

    public function distAssetStore(Request $request)
    {
        $request->validate([
            'nomor_penyerahan' => 'required|exists:distribution,nomor_penyerahan',
            'nomor_asset' => 'array',
            'nomor_asset.*' => ['nullable', 'exists:asset,nomor_asset', Rule::unique('distribution_detail', 'nomor_asset'), Rule::exists('asset', 'nomor_asset')->where(fn ($query) => $query->where('kondisi', '!=', '0'))],
            'nomor_it' => 'array',
            'nomor_it.*' => ['nullable', 'exists:device,nomor_it', Rule::unique('distribution_detail', 'nomor_it')],
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            'deskripsi' => 'required|array',
            'deskripsi.*' => 'required|string',
            'file.*' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nik' => 'required|array',
            'nik.*' => 'required|exists:employee,nik',
            'lokasi' => 'required|array',
            'lokasi.*' => 'required|string',
        ]);

        $nomorITs = $request->input('nomor_it', []);

        $duplicates = array_diff_assoc($nomorITs, array_unique($nomorITs));
        
        if (!empty($duplicates)) {
            $errors = [];
            foreach ($duplicates as $index => $value) {
                $errors["nomor_it.$index"] = "Nomor Asset $value sudah didistribusi.";
            }
        
            return back()->withErrors($errors)->withInput();
        }


        
        $nomorasset = $request->input('nomor_asset', []);

        $duplicatesAs = array_diff_assoc($nomorasset, array_unique($nomorasset));
        
        if (!empty($duplicatesAs)) {
            $errors = [];
            foreach ($duplicatesAs as $index => $value) {
                $errors["nomor_asset.$index"] = "Nomor asset $value sudah didistribusi.";
            }
        
            return back()->withErrors($errors)->withInput();
        }
        
    
        try {
            $distributions = [];
            $histories = [];
            $nomor_asset = $request->nomor_asset;
            $nomor_it = $request->nomor_it;
    
            foreach (($nomor_asset ?? $nomor_it) as $key => $value) {
                $file = $request->file('file')[$key];
                $fileName = time() . '_' . $file->getClientOriginalName();  
                $file->move(public_path('dokumen'), $fileName);
    
                $distributions[] = [
                    'nomor_penyerahan' => $request->nomor_penyerahan,
                    'tanggal' => $request->tanggal[$key],
                    'deskripsi' => $request->deskripsi[$key],
                    'file' => 'dokumen/' . $fileName,
                    'nomor_it' => $request->nomor_it[$key] ?? null,
                    'nomor_asset' => $request->nomor_asset[$key] ?? null,
                    'nik' => $request->nik[$key],
                    'lokasi' => $request->lokasi[$key],
                    'status_pengalihan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
    
                $histories[] = [
                    'nomor_penyerahan' => $request->nomor_penyerahan,
                    'nomor_it' => $request->nomor_it[$key] ?? null,
                    'nomor_asset' => $request->nomor_asset[$key] ?? null,
                    'nik' => $request->nik[$key],
                    'status_pengalihan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
    
            DistributionDetail::insert($distributions);
            History::insert($histories);
    
            session(['nomor_penyerahan' => $request->nomor_penyerahan]);
            
    
            $table = DistributionDetail::with(['employee', 'asset.kategori', 'device.kategori'])->where('nomor_penyerahan', $request->nomor_penyerahan)->get();
            session(['table' => $table]);

            return redirect('/distribusi/create')
            ->with('success', 'Perangkat berhasil ditambahkan.')
            ->with('table', $table);
            
        } catch (\Exception $e) {
            return redirect('/distribusi/create')
            ->with('false', 'Perangkat gagal ditambahkan.');
        }
    }
    

    public function show(string $id)
    {
        
    }



    public function destroy($id, $assetId)
    {
        $asset = DistributionDetail::whereHas('asset', function ($query) use ($assetId) {
            $query->where('id', $assetId); 
        })->where('id', $id)->first();


        $history = History::where('nomor_asset', $asset->nomor_asset)->get();
        foreach ($history as $item) {
            $item->delete();
        }
        $asset->delete();
        
        return redirect('/distribusi')->with('error', 'An error occurred while deleting the asset and device.');
    }

    public function destroyDevice($id, $deviceId)
    {
        $asset = DistributionDetail::whereHas('device', function ($query) use ($deviceId) {
                $query->where('id', $deviceId); 
                })->where('id', $id)->first();
        // dd($asset);
        $history = History::where('nomor_it', $asset->nomor_it)->get();
        foreach ($history as $item) {
            $item->delete();
        }
        
        $asset->delete();
        
        return redirect('/distribusi')->with('error', 'An error occurred while deleting the asset and device.');
    }

    public function destroyDistribution($id)
    {
        $asset = Distribution::where('id', $id)->first();
    
        $asset->listDistribusi()->delete();
        $asset->history()->delete();
        $asset->delete();
        
        return redirect('/distribusi')->with('success', 'Asset berhasil dihapus.');
    }
    
    
   public function fetchUserData(Request $request)
{
    $nik = $request->nik;

    if (!$nik) {
        return response()->json([
            'success' => false,
            'message' => 'NIK tidak ditemukan.',
        ]);
    }

    $user = Employee::where('nik', $nik)->first();

    if ($user) {
        return response()->json([
            'success' => true,
            'nama' => $user->nama,
            'kode_org' => $user->kode_org,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Data pengguna tidak ditemukan.',
        ]);
    }
}

    

    public function fetchDeviceData(Request $request)
    {
        $nomor_it = $request->nomor_it;
        $asset = Device::where('nomor_it', $nomor_it)->first();

        if ($asset) {
            return response()->json([
                'success' => true,
                'id_kategori' => $asset->kategori->nama,
                'id_tipe' => $asset->subKategori->nama,
                'umur' => $asset->umur, 
                'no_pmn' => $asset->no_pmn,
                'processor' => $asset->processorType->nama,
                'storage_type' => $asset->storageType->nama,
                'memory_type' => $asset->memoryType->nama,
                'vga_type' => $asset->vgaType->nama,
                'vga_capacity' => $asset->vga_capacity,
                'serial_number' => $asset->serial_number,
                'storage_capacity' => $asset->storage_capacity,
                'memory_capacity' => $asset->memory_capacity,
                'keterangan_tambahan' => $asset->keterangan_tambahan,
                'operation_system' => $asset->operationSystem->nama,
                'office' => $asset->officeType->nama,
                'os_license' => $asset->osLicense->nama,
                'office_license' => $asset->officeLicense->nama,
                'aplikasi_lainnya' => $asset->aplikasi_lainnya,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Device tidak ditemukan.',
            ]);
        }
    }

    public function fetchAssetData(Request $request)
    {
        $nomor_asset = $request->nomor_asset;
        $asset = Asset::where('nomor_asset', $nomor_asset)->first();

        if ($asset) {
            return response()->json([
                'success' => true,
                'id_kategori' => $asset->kategori->nama,
                'id_tipe' => $asset->subKategori->nama,
                'umur' => $asset->umur, 
                'no_pmn' => $asset->no_pmn, 
                'foto' => $asset->foto
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Asset tidak ditemukan.',
            ]);
        }
    }

    public function getTipeByKategori($idKategori)
    {
        $tipe = TypeKategori::where('id_kategori', $idKategori)->get();
        return response()->json($tipe);
    }

    public function viewTambahAsset(){
        $device = Device::all();
        $kategori = Kategori::whereIn('id', [1, 3, 4])->get();;
        $tipe = TypeKategori::all();

        $processor = TypeKategori::where('id_kategori', 2)->get();
        $storageType = TypeKategori::where('id_kategori', 5)->get();
        $memoryType = TypeKategori::where('id_kategori', 6)->get();
        $VGAType = TypeKategori::where('id_kategori', 7)->get();
        $osType = TypeKategori::where('id_kategori', 8)->get();
        $officeType = TypeKategori::where('id_kategori', 9)->get();
        $lisence = TypeKategori::where('id_kategori', 10)->get();
        return view('asset.create', compact(
            ['device', 'kategori',  'tipe', 'processor', 'storageType', 'memoryType', 'VGAType', 'osType', 'officeType', 'lisence',]));
    }

    public function pilihPengalihan(Request $request, $id)
    {
        $dist = Distribution::where('id', $id)->first();
    
        $search = $request->input('search');
    
        if ($search) {
            $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)
                ->where(function ($query) use ($search) {
                    $query->where('nomor_penyerahan', 'LIKE', "%{$search}%")
                          ->orWhereHas('employee', function($query) use ($search) {
                              $query->where('nama', 'LIKE', "%{$search}%");
                          })
                          ->orWhereHas('device', function($query) use ($search) {
                              $query->where('nomor_it', 'LIKE', "%{$search}%");
                          })
                          ->orWhereHas('asset', function($query) use ($search) {
                              $query->where('nomor_asset', 'LIKE', "%{$search}%");
                          })
                          ->orWhereRaw("CASE 
                                WHEN nomor_it IS NULL THEN 'Perlengkapan Kantor'
                                ELSE 'Perangkat Komputer' 
                            END LIKE ?", ['%' . $search . '%']);
                })
                ->paginate(10);
        } else {
            $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)
                ->paginate(10);
        }

        if ($request->ajax()) {
            return view('distribusi.pengalihan.table-pilih', compact('distribution'));
        }
    
        return view('distribusi.pengalihan.pilih', compact('distribution', 'dist'));
    }
    

    public function detailAsset(Request $request, $id)
    {
        $dist = Distribution::where('id', $id)->first();
        $search = $request->input('search');

        $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_penyerahan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_asset', 'like', '%' . $search . '%')
                    ->orWhere('nomor_it', 'like', '%' . $search . '%')
                    ->orWhereHas('employee', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('asset', function ($q) use ($search) {
                        $q->where('no_pmn', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('device', function ($q) use ($search) {
                        $q->where('no_pmn', 'like', '%' . $search . '%');
                    })
                    ->orWhereRaw("CASE 
                                        WHEN nomor_it IS NULL THEN 'Perlengkapan Kantor'
                                        ELSE 'Perangkat Komputer' 
                                    END LIKE ?", ['%' . $search . '%']);
                });
            })
            ->paginate(5);

        if ($request->ajax()) {
            return view('distribusi.table-detail-distribusi', compact('distribution'));
        }
        $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)->paginate(5);
        // dd($distribution);   
        return view('distribusi.detail-distribusi', compact('distribution'));
    }

    public function pengalihanAsset(Request $request, $id, $nomor)
    {
        $distribution = DistributionDetail::whereHas('asset', function ($query) use ($nomor) {
            $query->where('id', $nomor); 
        })->where('id', $id)->first();
        // dd($nomor);

        $assetId = $distribution->asset->id;
        // dd($assetId);

        return view('distribusi.pengalihan.pengalihan', compact('distribution'));
    }


    public function updatePengalihanAsset(Request $request, $id, $nomor)
    {
        $distribution = DistributionDetail::whereHas('asset', function ($query) use ($nomor) {
            $query->where('id', $nomor); 
        })->where('id', $id)->first();
        // dd($distribution);

        $request->validate([
            'nomor_penyerahan' => 'required|exists:distribution_detail,nomor_penyerahan',
            'nomor_asset' => 'nullable|exists:asset,nomor_asset',
            'tanggal_pengalihan' => 'required|date',
            'dokumen_pengalihan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nik' => 'required|exists:employee,nik',
        ]);
        
        $file = $request->file('dokumen_pengalihan');
        $fileName = $file->getClientOriginalName();  
        $path = $file->move(public_path('dokumen'), $fileName); 


        $history_status = History::whereHas('asset', function ($query) use ($nomor, $id) {
            $query->where('id', $nomor)
                ->whereHas('distribution_detail', function ($query) use ($id) {
                    $query->where('id', $id);
                });
        })
        ->orderBy('status_pengalihan', 'desc') 
        ->first();
        // dd($history_status);

        $distribution->update([
            'nik' => $request->nik,
            'status_pengalihan' => $history_status->status_pengalihan + 1,
        ]);


        $history = History::create([
            'nomor_penyerahan' => $request->nomor_penyerahan,
            'nomor_it' =>  $request->nomor_it ?? null,
            'nomor_asset' =>  $request->nomor_asset ?? null,
            'tanggal_pengalihan' =>  $request->tanggal_pengalihan,
            'dokumen_pengalihan' => 'dokumen/' . $fileName,
            'nik' =>  $request->nik,
            'status_pengalihan' => $history_status->status_pengalihan + 1,
        ]);

        $dist = DistributionDetail::where('id', $id)->first();
        $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)->paginate(10);
        return view('distribusi.pengalihan.pilih', compact('distribution', 'dist'));
    }

//================================================================================================================================

    public function pengalihanDevice(Request $request, $id, $nomor)
    {
        $distribution = DistributionDetail::whereHas('device', function ($query) use ($nomor) {
            $query->where('id', $nomor); 
        })->where('id', $id)->first();

        
        $deviceId = $distribution->device->id;
        // dd($deviceId);

        return view('distribusi.pengalihan.pengalihan-device', compact('distribution'));
    }


    public function updatePengalihanDevice(Request $request, $id, $nomor)
    {
        $distribution = DistributionDetail::whereHas('device', function ($query) use ($nomor) {
            $query->where('id', $nomor); 
        })->where('id', $id)->first();
        
        $request->validate([
            'nomor_penyerahan' => 'required|exists:distribution_detail,nomor_penyerahan',
            'nomor_it' => 'nullable|exists:device,nomor_it',
            'tanggal_pengalihan' => 'required|date',
            'dokumen_pengalihan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nik' => 'required|exists:employee,nik',
        ]);
        
        $file = $request->file('dokumen_pengalihan');
        $fileName = $file->getClientOriginalName();  
        $path = $file->move(public_path('dokumen'), $fileName); 
    

        $history_status = History::whereHas('device', function ($query) use ($nomor, $id) {
            $query->where('id', $nomor)
                ->whereHas('distribution_detail', function ($query) use ($id) {
                    $query->where('id', $id);
                });
        })
        ->orderBy('status_pengalihan', 'desc') 
        ->first(); 
                        
        $distribution->update([
            'nik' => $request->nik,
            'status_pengalihan' => $history_status->status_pengalihan + 1,
        ]);


        $history = History::create([
            'nomor_penyerahan' => $request->nomor_penyerahan,
            'nomor_it' =>  $request->nomor_it ?? null,
            'nomor_asset' =>  $request->nomor_asset ?? null,
            'tanggal_pengalihan' =>  $request->tanggal_pengalihan,
            'dokumen_pengalihan' => 'dokumen/' . $fileName,
            'nik' =>  $request->nik,
            'status_pengalihan' => $history_status->status_pengalihan + 1,
        ]);
        $dist = DistributionDetail::where('id', $id)->first();
        $distribution = DistributionDetail::where('nomor_penyerahan', $dist->nomor_penyerahan)->paginate(10);
        return view('distribusi.pengalihan.pilih', compact('distribution', 'dist'));
    }

    public function updatePengalihan(Request $request, $nomorAsset, $deviceId) {
        $distribution = Distribution::where('nomor_penyerahan', $nomorAsset)->first();
    
        $request->validate([
            'nomor_penyerahan' => 'required|unique:distribution,nomor_penyerahan,' . $distribution->id,
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'file_pengalihan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nik' => 'required|exists:employee,nik',
            'nomor_it' => 'required|exists:assets,nomor_it',
            'status_pengalihan' => 'required|integer',
            'lokasi' => 'required|string',
        ]);
        
        $file = $request->file('file_pengalihan');
        $fileName = $file->getClientOriginalName();  
        $path = $file->move(public_path('dokumen'), $fileName); 
        
        $distribution->update([
            'nomor_penyerahan' => $request->nomor_penyerahan,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'nik' => $request->nik,
            'nomor_it' => $request->nomor_it,
            'lokasi' => $request->lokasi,
            'status_pengalihan' => $request->status_pengalihan,
        ]);
        
        History::create([
            'nomor_penyerahan' => $request->nomor_penyerahan,
            'status_pengalihan' => $request->status_pengalihan,
            'nik' => $request->nik,
            'file' => 'dokumen/' . $fileName,  
        ]);
        
        return redirect('/distribusi')->with('success', 'Distribusi asset berhasil dialihkan.');

    }
    

    public function history(Request $request)
    {
        $search = $request->input('search'); 
    
        $history = History::where('status_pengalihan', 1)  // Filter status pengalihan harus tetap ada
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_penyerahan', 'like', '%' . $search . '%')
                  ->orWhere('nomor_asset', 'like', '%' . $search . '%')
                  ->orWhere('nomor_it', 'like', '%' . $search . '%')
                  ->orWhereHas('distribution_detail', function ($q) use ($search) {
                      $q->whereHas('employee', function ($q) use ($search) {
                          $q->where('nama', 'like', '%' . $search . '%');
                      })
                      ->orWhere('lokasi', 'like', '%' . $search . '%');
                  });
            });
        })
        ->paginate(5);
    

        if ($request->ajax()) {
            return view('distribusi.table-history', compact('history'));
        }
        return view('distribusi.history', compact('history'));
    }
    
    
    

    public function detailHistoryAsset(Request $request, $historyId, $assetId){
        
        $dist = DistributionDetail::where('id', $historyId)->first();
        $asset = Asset::where('id', $assetId)->first();

        $history = History::where('nomor_penyerahan' , $dist->nomor_penyerahan)
                            ->where('nomor_asset' , $asset->nomor_asset)->get();

        $maxStatus = History::where('nomor_asset', $asset->nomor_asset)
                            ->where('nomor_penyerahan', $dist->nomor_penyerahan)
                            ->max('status_pengalihan');

        $history_status = History::where('nomor_asset', $asset->nomor_asset)
            ->where('nomor_penyerahan', $dist->nomor_penyerahan)
            ->where('status_pengalihan', $maxStatus)
            ->first();

        return view('distribusi.detail-history', compact('history', 'history_status'));
    }

    public function detailHistoryDevice(Request $request, $historyId, $assetId){
                
        $dist = DistributionDetail::where('id', $historyId)->first();
        $asset = Device::where('id', $assetId)->first();

        $history = History::where('nomor_penyerahan' , $dist->nomor_penyerahan)
                            ->where('nomor_it' , $asset->nomor_it)->get();


        $maxStatus = History::where('nomor_it', $asset->nomor_it)
                    ->where('nomor_penyerahan', $dist->nomor_penyerahan)
                    ->max('status_pengalihan');

        $history_status = History::where('nomor_it', $asset->nomor_it)
            ->where('nomor_penyerahan', $dist->nomor_penyerahan)
            ->where('status_pengalihan', $maxStatus)
            ->first();

        return view('distribusi.detail-history-device', compact('history', 'history_status'));
    }


    public function export()
    {
        $assets = DistributionDetail::with('asset', 'employee', 'device.kategori', 'device.processorType', 'device.subKategori', 'device.storageType', 'device.memoryType', 'device.vgaType', 'device.operationSystem', 'device.osLicense', 'device.officeType', 'device.officeLicense')->get();
    
        $headers = [
            "Nomor Penyerahan",
            "Nomor Pendanaan",
            "Employee Name",
            "Lokasi",
            "Nomor Asset",
            "Kategori",
            "Sub Kategori",
            "Processor Type",
            "Umur",
            "Storage Type",
            "Storage Capacity",
            "Memory Type",
            "Memory Capacity",
            "VGA Type",
            "VGA Capacity",
            "Serial Number",
            "Kondisi",
            "OS",
            "OS License",
            "Office Type",
            "Office License",
            "Aplikasi Lainnya",
            "Keterangan Tambahan"
        ];
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->fromArray($headers, NULL, 'A1');

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']]
        ];
    
        $sheet->getStyle('A1:W1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getStyle('A1:W1')->getAlignment()->setWrapText(true);
    
        $rowNum = 2;
    
        foreach ($assets as $asset) {
            $row = [
                $asset->nomor_penyerahan,
                $asset->device ? $asset->device->no_pmn : $asset->asset->no_pmn,
                $asset->employee->nama ?? '-',
                $asset->lokasi ?? '-',
                // $asset->nomor_it ?? '-',
                $asset->nomor_asset ?? $asset->nomor_it ?? '-',
                $asset->device ? $asset->device->kategori->nama : $asset->asset->kategori->nama,
                $asset->device ? $asset->device->subKategori->nama : $asset->asset->subKategori->nama,
                $asset->device ? $asset->device->processorType->nama : '-',
                $asset->device ? Carbon::parse($asset->device->umur)->age . " Tahun" : ($asset->asset ? Carbon::parse($asset->asset->umur)->age . " Tahun" : '-'),
                $asset->device ? $asset->device->storageType->nama : '-',
                $asset->device ? $asset->device->storage_capacity : '-',
                $asset->device ? $asset->device->memoryType->nama : '-',
                $asset->device ? $asset->device->memory_capacity : '-',
                $asset->device ? $asset->device->vgaType->nama : '-',
                $asset->device ? $asset->device->vga_capacity : '-',
                $asset->device ? $asset->device->serial_number : '-',
                $asset->device ? ($asset->device->kondisi == 0 ? 'Rusak' : 'Baik') : ($asset->asset->kondisi == 0 ? 'Rusak' : 'Baik'),
                $asset->device ? $asset->device->operationSystem->nama : '-',
                $asset->device ? $asset->device->osLicense->nama : '-',
                $asset->device ? $asset->device->officeType->nama : '-',
                $asset->device ? $asset->device->officeLicense->nama : '-',
                $asset->device ? $asset->device->aplikasi_lainnya : '-',
                $asset->device ? $asset->device->keterangan_tambahan : '-',
            ];
    
            $sheet->fromArray($row, NULL, 'A' . $rowNum);
    
            $sheet->getStyle("A$rowNum:W$rowNum")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
            ]);
    
            $rowNum++;
        }
    
        foreach (range('A', 'W') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        $fileName = 'assets_export_' . date('Y-m-d') . '.xlsx';
    
        $writer = new Xlsx($spreadsheet);
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        $writer->save('php://output');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_pengajuan' => 'required|in:1,2,3', 
        ]);

        try {
            $distribution = DistributionDetail::findOrFail($id);
            $distribution->status_pengajuan = $request->status_pengajuan;
            $distribution->save(); 

            $history = HistoryPengajuan::where('id_distribution_detail', $distribution->id)->orderBy('created_at', 'desc')->first();

            $history->status_pengajuan = $request->status_pengajuan;
            $history->save();

            if ($distribution->status_pengajuan == 2) {
                if ($distribution->nomor_asset != null) {
                    $asset = Asset::where('nomor_asset', $distribution->nomor_asset)->first();
                    if ($asset) {
                        $asset->kondisi = '0';
                        $asset->save(); 
                    }
                }
                else if ($distribution->nomor_it != null) {
                    $device = Device::where('nomor_it', $distribution->nomor_it)->first();
                    if ($device) {
                        $device->kondisi = '0'; 
                        $device->save(); 
                    }
                }
            }

            else if ($distribution->status_pengajuan == 3) {
                if ($distribution->nomor_asset != null) {
                    $asset = Asset::where('nomor_asset', $distribution->nomor_asset)->first();
                    if ($asset) {
                        $asset->kondisi = '1';
                        $asset->save(); 
                    }
                }
                else if ($distribution->nomor_it != null) {
                    $device = Device::where('nomor_it', $distribution->nomor_it)->first();
                    if ($device) {
                        $device->kondisi = '1'; 
                        $device->save(); 
                    }
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function updateRusak(Request $request, $id)
    {
        try {
            $request->validate([
                'deskripsi_pengajuan' => 'required|string',  
            ]);

            $disDetail = DistributionDetail::findOrFail($id);
            if ($disDetail->status_pengajuan == 1) {
                return redirect()->route('karyawan.dashboard')->with('error', 'Kerusakan telah diajukan, harap tunggu diverifikasi!');
            }

            $disDetail->update([
                'deskripsi_pengajuan' => $request->deskripsi_pengajuan, 
                'status_pengajuan' => '1',  
            ]);

            $historyStatus = HistoryPengajuan::where('id_distribution_detail', $id)->orderBy('created_at', 'desc')->first();
            if ($historyStatus) {
                $history = HistoryPengajuan::create([
                    'id_distribution_detail' => $id,
                    'status' => $historyStatus->status + 1,
                ]);
            } else {
                $history = HistoryPengajuan::create([
                    'id_distribution_detail' => $id,
                    'status' => 0,
                ]);
            }
            

            return redirect()->route('karyawan.dashboard')->with('success', 'Kerusakan berhasil diajukan.');
        } catch (\Exception $e) {            
            return redirect()->route('karyawan.dashboard')->with('error', 'Terjadi kesalahan, coba lagi.');
        }
    }

    public function historyPengajuan(Request $request) {
        $search = $request->input('search'); 
    
        // Modify the query to filter based on the search input
        $history = HistoryPengajuan::when($search, function ($query, $search) {
            return $query->whereHas('distributionDetail', function ($query) use ($search) {
                $query->where('nik', 'like', "%$search%")
                      ->orWhereHas('employee', function ($query) use ($search) {
                          $query->where('nama', 'like', "%$search%");
                      })
                      ->orWhereHas('asset', function ($query) use ($search) {
                        $query->where('nomor_asset', 'like', "%$search%");
                    })
                      ->orWhere('nomor_penyerahan', 'like', "%$search%");
            });
        })->paginate(10);

        if ($request->ajax()) {
            return view('distribusi.table-history-pengajuan', compact('history'));
        }
    
        return view('distribusi.history-pengajuan', compact('history'));
    }
    


    public function historyDeviceRusak(Request $request){
        $actor = auth()->user();
        $distribution = DistributionDetail::whereNull('nomor_asset')
                        ->where('nik', $actor->nik)
                        ->get();

        $search = $request->get('search');
        $history = HistoryPengajuan::select('history_pengajuan.*', 'distribution_detail.nomor_penyerahan')
        ->join('distribution_detail', 'history_pengajuan.id_distribution_detail', '=', 'distribution_detail.id')
        ->orderBy('history_pengajuan.created_at', 'asc')
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('distribution_detail.nomor_penyerahan', 'like', '%' . $search . '%')
                    ->orWhere('distribution_detail.nomor_it', 'like', '%' . $search . '%');
            });
        })
        ->whereIn('id_distribution_detail', $distribution->pluck('id'))
        ->paginate(5);
    
    
        if ($request->ajax()) {
            return view('karyawan.table-history-device-rusak', compact('history'));
        }

        return view('karyawan.history-device-rusak', compact('history'));

    }

    public function historyAssetRusak( Request $request){
        $actor = auth()->user();
        $distribution = DistributionDetail::whereNull('nomor_it')
                        ->where('nik', $actor->nik)
                        ->get();


        $search = $request->get('search');
        $history = HistoryPengajuan::select('history_pengajuan.*', 'distribution_detail.nomor_penyerahan')
        ->join('distribution_detail', 'history_pengajuan.id_distribution_detail', '=', 'distribution_detail.id')
        ->orderBy('history_pengajuan.created_at', 'asc')
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('distribution_detail.nomor_penyerahan', 'like', '%' . $search . '%')
                    ->orWhere('distribution_detail.nomor_asset', 'like', '%' . $search . '%');
            });
        })
        ->whereIn('id_distribution_detail', $distribution->pluck('id'))
        ->paginate(5);


            
        if ($request->ajax()) {
            return view('karyawan.table-history-asset-rusak', compact('history'));
        }

        return view('karyawan.history-asset-rusak', compact('history'));

    }

    public function fetchNoPenyerahan(Request $request)
    {
        $nomor_penyerahan = $request->nomor_penyerahan;
        if (!$nomor_penyerahan) {
            return response()->json([
                'success' => false,
                'message' => 'No Penyerahan harus diisi.',
            ]);
        }
        $distribusi = Distribution::whereRaw('BINARY `nomor_penyerahan` = ?', [$nomor_penyerahan])->first();
        if ($distribusi) {
            return response()->json([
                'success' => true,
                'nomor_penyerahan' => $distribusi->nomor_penyerahan,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Penyerahan tidak ditemukan.',
            ]);
        }
    }

}
