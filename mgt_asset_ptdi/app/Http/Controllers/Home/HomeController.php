<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Asset;
use App\Models\Organisasi;
use App\Models\Device;
use App\Models\HistoryPengajuan;
use App\Models\Employee;
use App\Models\Actor;
use App\Models\DistributionDetail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function karyawan(Request $request)
     {
         $actor = auth()->user();
     
         $device = DistributionDetail::where('nik', $actor->nik)
                     ->where('nomor_asset', null)
                     ->count();
     
         $asset = DistributionDetail::where('nik', $actor->nik)
                     ->where('nomor_it', null)
                     ->count();
     
         $search = $request->input('search', '');
         $type = $request->input('type', ''); 
     
         if ($request->ajax() && $type === 'asset') {
             $assets = DistributionDetail::where('nik', $actor->nik)
                 ->whereNull('nomor_it')
                 ->where(function($query) use ($search) {
                     $query->where('nomor_penyerahan', 'like', "%$search%")
                            ->orWhere('nomor_asset', 'like', "%$search%")      
                            ->orWhereHas('asset', function($query) use ($search) {
                               $query->join('kategori', 'kategori.id', '=', 'asset.id_kategori')
                                     ->join('sub_kategori', 'sub_kategori.id', '=', 'asset.id_tipe')
                                     ->where('kategori.nama', 'like', "%$search%")
                                     ->orWhere('sub_kategori.nama', 'like', "%$search%")
                                     ->orWhereRaw("IF(asset.kondisi = 1, 'Baik', 'Rusak') LIKE ?", ["%$search%"]);
                           });
                 })
                 ->where('status_penerimaan', '1')
                 ->paginate(5);
     
             return view('karyawan.partial-table-asset', compact('assets'))->render();
         }
     
         if ($request->ajax() && $type === 'device') {
             $devices = DistributionDetail::where('nik', $actor->nik)
                 ->where('nomor_asset', null)
                 ->where(function($query) use ($search) {
                     $query->where('nomor_penyerahan', 'like', "%$search%")
                            ->orWhere('nomor_it', 'like', "%$search%")      
                            ->orWhereHas('device', function($query) use ($search) {
                               $query->join('kategori', 'kategori.id', '=', 'device.id_kategori')
                                     ->join('sub_kategori', 'sub_kategori.id', '=', 'device.id_tipe')
                                     ->where('kategori.nama', 'like', "%$search%")
                                     ->orWhere('sub_kategori.nama', 'like', "%$search%")
                                     ->orWhereRaw("IF(device.kondisi = 1, 'Baik', 'Rusak') LIKE ?", ["%$search%"]);
                           });
                 })
                 ->where('status_penerimaan', '1')
                 ->paginate(5);
     
             return view('karyawan.partial-table-device', compact('devices'))->render();
         }

         if ($request->ajax() && $type === 'all_assets') { 
            $AllAssets = DistributionDetail::where('nik', $actor->nik)
                ->whereNull('nomor_it')
                ->where(function($query) use ($search) {
                    $query->where('nomor_penyerahan', 'like', "%$search%")
                          ->orWhere('nomor_asset', 'like', "%$search%")
                          ->orWhereRaw("IF(status_penerimaan = 1, 'Belum Diterima', 'Sudah Diterima') LIKE ?", ["%$search%"])
                          ->orWhereHas('asset', function($query) use ($search) {
                              $query->join('kategori', 'kategori.id', '=', 'asset.id_kategori')
                                    ->join('sub_kategori', 'sub_kategori.id', '=', 'asset.id_tipe')
                                    ->where('kategori.nama', 'like', "%$search%")
                                    ->orWhere('sub_kategori.nama', 'like', "%$search%")
                                    ->orWhereRaw("IF(asset.kondisi = 1, 'Baik', 'Rusak') LIKE ?", ["%$search%"]);
                          });
                })
                ->paginate(5);
        
            return view('karyawan.partial-table-semua-asset', compact('AllAssets'))->render();
        }

             
        if ($request->ajax() && $type === 'all_devices') {
            $AllDevices = DistributionDetail::where('nik', $actor->nik)
                ->where('nomor_asset', null)
                ->where(function($query) use ($search) {
                    $query->where('nomor_penyerahan', 'like', "%$search%")
                           ->orWhere('nomor_it', 'like', "%$search%")     
                           ->orWhereRaw("IF(status_penerimaan = 1, 'Belum Diterima', 'Sudah Diterima') LIKE ?", ["%$search%"])
                           ->orWhereHas('device', function($query) use ($search) {
                              $query->join('kategori', 'kategori.id', '=', 'device.id_kategori')
                                    ->join('sub_kategori', 'sub_kategori.id', '=', 'device.id_tipe')
                                    ->where('kategori.nama', 'like', "%$search%")
                                    ->orWhere('sub_kategori.nama', 'like', "%$search%")
                                    ->orWhereRaw("IF(device.kondisi = 1, 'Baik', 'Rusak') LIKE ?", ["%$search%"]);
                          });
                })
                ->paginate(5);
    
            return view('karyawan.partial-table-semua-device', compact('AllDevices'))->render();
        }
        
     
        $devices = DistributionDetail::where('nik', $actor->nik)
            ->where('nomor_asset', null)
            ->where('status_penerimaan', '1')
            ->paginate(5);

        $AllDevices = DistributionDetail::where('nik', $actor->nik)
            ->whereNull('nomor_asset')
            ->paginate(5);
    
        $assets = DistributionDetail::where('nik', $actor->nik)
            ->whereNull('nomor_it')
            ->where('status_penerimaan', '1')
            ->paginate(5);

        $AllAssets = DistributionDetail::where('nik', $actor->nik)
            ->whereNull('nomor_it')
            ->paginate(5);
     
         return view('karyawan.dashboard-karyawan', compact('actor', 'device', 'asset', 'devices', 'assets', 'AllAssets', 'AllDevices'));
     }
    
    public function admin()
    {

        $actor = auth()->user();
        if (session('selected_role') !== 'admin') {
            return redirect('/karyawan/dashboard'); 
        }
        

        $empTot = Employee::count();
        $orgTot = Organisasi::count();
        $catTot = Kategori::count();
        $subTot = SubKategori::count();
        $devTot = Device::count();
        $assTot = Asset::count();

        $distribution = DistributionDetail::where('status_pengajuan', '1')->get();
        $distributionCount = DistributionDetail::where('status_pengajuan', '1')->count();

        // dd($distribution);
        return view('home', compact(['empTot', 'orgTot', 'catTot', 'subTot', 'devTot', 'assTot', 'actor', 'distribution', 'distributionCount']));
    }


    public function superAdmin()
    {
        // Ambil data aktor selain super_user
        $actors = Actor::with('employee')->where('super_user', null)->get();
    
        $actorGrouped = $actors->groupBy('nik')->map(function ($items) {
            return [
                'nik' => $items->first()->nik,
                'roles' => $items->pluck('role')->unique()->join(' & '),
                'nama' => $items->first()->employee->nama ?? 'Tidak ada nama'
            ];
        });
    
        $admin = Actor::where('role', 'admin')->count();
    
        return view('super-admin.super-admin-dashboard', [
            'actor' => $actorGrouped,
            'admin' => $admin
        ]);
    }
    
    public function detailNotifikasi(){
        $distribution = DistributionDetail::where('status_pengajuan', '1')
        ->orderBy('updated_at', 'desc')->get();

        // $setuju = DistributionDetail::where('status_pengajuan', '2');
        return view('detail-notifikasi', compact('distribution'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_penerimaan' => 'required|in:0,1', 
        ]);
    
        try {
            $distribution = DistributionDetail::findOrFail($id);
            $distribution->status_penerimaan = $request->status_penerimaan;
            $distribution->save();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
