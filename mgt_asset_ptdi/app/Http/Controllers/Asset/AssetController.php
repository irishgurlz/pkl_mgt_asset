<?php

namespace App\Http\Controllers\Asset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Kategori;
use App\Models\Pendanaan;
use App\Models\SubKategori;
use App\Models\Device;
use App\Models\DistributionDetail;
use Carbon\Carbon;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = Kategori::where('jenis_kategori', '2')->get();

        $assRelations = ['kategori', 'subKategori'];

        $asset = Asset::with($assRelations)
            ->where('kondisi', '1') 
            ->when($search, function ($query, $search) use ($assRelations) {
                $query->where(function ($query) use ($search, $assRelations) {
                    $query->where('no_pmn', 'like', "%{$search}%")
                        ->orWhere('nomor_asset', 'like', "%{$search}%")
                        ->orWhereRaw("(CASE 
                            WHEN kondisi = 1 THEN 'Baik' 
                            WHEN kondisi = 0 THEN 'Rusak' 
                            END) LIKE ?", ["%$search%"]);


        
                    foreach ($assRelations as $relation) {
                        $query->orWhereHas($relation, function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                    }
                });
            })
            ->orderBy('nomor_asset', 'asc')
            ->paginate(10);

        $asset->each(function ($item) {
            if ($item->umur) {
                $parsedDate = Carbon::parse($item->umur);
                $currentDate = Carbon::now();

                $yearsDifference = $currentDate->year - $parsedDate->year;

                if (
                    $currentDate->month < $parsedDate->month || 
                    ($currentDate->month == $parsedDate->month && $currentDate->day < $parsedDate->day)
                ) {
                    $yearsDifference--;
                }

                $item->calculated_age = $yearsDifference;
            } else {
                $item->calculated_age = null;
            }
        });

        if ($request->ajax()) {
            return view('asset.component.search_table_asset', ['asset' => $asset]);
        }

        return view('asset.asset', compact('asset', 'kategori'));
    }

    public function viewBarangRusak(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type'); // Dapatkan tipe pencarian (device atau asset)
        $kategori = Kategori::where('jenis_kategori', '1')->get();
    
        // Fungsi Perhitungan Umur
        $calculateAge = function ($item) {
            if ($item->umur) {
                $parsedDate = Carbon::parse($item->umur);
                $currentDate = Carbon::now();
    
                $yearsDifference = $currentDate->year - $parsedDate->year;
    
                if (
                    $currentDate->month < $parsedDate->month ||
                    ($currentDate->month == $parsedDate->month && $currentDate->day < $parsedDate->day)
                ) {
                    $yearsDifference--;
                }
    
                return $yearsDifference;
            }
            return null;
        };
    
        $filterDeviceQuery = function ($query, $search, $relations) {
            return $query->where(function ($query) use ($search, $relations) {
                $query->where('nomor_it', 'like', "%{$search}%") 
                      ->orWhere('no_pmn', 'like', "%{$search}%");
                foreach ($relations as $relation) {
                    $query->orWhereHas($relation, function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
                }
            });
        };
    
        $filterAssetQuery = function ($query, $search, $relations) {
            return $query->where(function ($query) use ($search, $relations) {
                $query->where('nomor_asset', 'like', "%{$search}%") 
                      ->orWhere('no_pmn', 'like', "%{$search}%");
                foreach ($relations as $relation) {
                    $query->orWhereHas($relation, function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
                }
            });
        };
    
        // Query untuk Asset
        $assRelations = ['kategori', 'subKategori'];
        $asset = Asset::with($assRelations)
            ->when($search, fn($query) => $filterAssetQuery($query, $search, $assRelations))
            ->where('kondisi', '0')
            ->orderBy('no_pmn', 'asc')
            ->paginate(10);
    
        foreach ($asset as $item) {
            $item->calculated_age = $calculateAge($item);
        }
    
        // Query untuk Device
        $devRelations = ['kategori', 'subKategori'];
        $devices = Device::with($devRelations)
            ->when($search, fn($query) => $filterDeviceQuery($query, $search, $devRelations))
            ->where('kondisi', '0')
            ->orderBy('nomor_it', 'asc')
            ->paginate(10);
    
        foreach ($devices as $item) {
            $item->calculated_age = $calculateAge($item);
        }
    
        // Return untuk AJAX
        if ($request->ajax()) {
            if ($type === 'device') {
                return view('endpoint device.device.component.search_table_device', ['devices' => $devices]);
            } elseif ($type === 'asset') {
                return view('asset.component.search_table_asset', ['asset' => $asset]);
            }
        }
    
        // Return untuk View Utama
        return view('asset.barang_rusak', compact(['asset', 'devices', 'kategori']));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendanaan = Pendanaan::all();
        $device = Device::all();
        $kategori = Kategori::where('jenis_kategori', '2')->get();
        $tipe = SubKategori::all();

        return view('asset.create', compact(
            ['pendanaan', 'device', 'kategori',  'tipe']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_asset' => 'required|unique:asset,nomor_asset|unique:device,nomor_it',
            'no_pmn' => 'required|exists:pendanaan,no_pmn',
            'id_kategori' => 'required|exists:kategori,id',
            'id_tipe' => 'required|exists:sub_kategori,id',
            'umur' => 'required|date',
            'kondisi' => 'required|boolean',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);
    
        $asset = [
            'nomor_asset' =>  $request->nomor_asset,
            'no_pmn' => $request->no_pmn,
            'id_kategori' => $request->id_kategori,
            'id_tipe' => $request->id_tipe,
            'umur' => $request->umur,
            'kondisi' => $request->input('kondisi'),
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('foto_asset'), $fileName);
            $asset['foto'] = 'foto_asset/' . $fileName;
        }
    
        Asset::create($asset);

        if ($request->kondisi == '0') {
            return redirect('/asset/barang-rusak')
                ->with('success', 'Asset berhasil ditambahkan.');
        }

        return redirect('/asset')->with('success', 'Asset berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset = Asset::find($id);
        $kategori = Kategori::where('jenis_kategori', '2')->get();
        $tipe = SubKategori::all();

        return view('asset.edit', compact(
            ['asset', 'kategori',  'tipe' ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);
        
        $request->validate([

            'nomor_asset' => 'required|unique:asset,nomor_asset,' . $asset->id . '|unique:device,nomor_it,' . $id, 
            'no_pmn' => 'required|exists:pendanaan,no_pmn',
            'id_kategori' => 'required|exists:kategori,id',
            'id_tipe' => 'required|exists:sub_kategori,id',
            'umur' => 'required|date',
            'kondisi' => 'required|boolean',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);
        
        $assetUpdate = [
            'nomor_asset' =>  $request->nomor_asset,
            'no_pmn' => $request->no_pmn,
            'id_kategori' => $request->id_kategori,
            'id_tipe' => $request->id_tipe,
            'umur' => $request->umur,
            'kondisi' => $request->input('kondisi'),
        ];

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($asset->foto && file_exists(public_path($asset->foto))) {
                unlink(public_path($asset->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_asset'), $fileName);

            $assetUpdate['foto'] = 'foto_asset/' . $fileName;
        }

        $asset->update($assetUpdate);

        if ($request->kondisi == '0') {
            return redirect('/asset/barang-rusak')
                ->with('success', 'Kondisi asset berhasil diperbarui');
        }
        elseif ($request->kondisi == '1') {
            return redirect('/asset')
                ->with('success', 'Asset berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset = Asset::find($id);
    
        if (!$asset) {
            return redirect('/asset')->with('error', 'Asset tidak ditemukan');
        }
    
        $kondisi = $asset->kondisi;    
        $asset->delete();
    
        if ($kondisi == 0) {
            return redirect('/asset/barang-rusak')->with('success', 'Asset berhasil dihapus');
        }
    
        return redirect('/asset')->with('success', 'Asset berhasil dihapus');
    }

    public function getDevRusakByKategori($idKategori)
    {
        \Log::info('ID Kategori diterima:', ['idKategori' => $idKategori]);
        $devices = Device::with([
            'pendanaan',
            'kategori',
            'subKategori',
            'processorType',
            'storageType',
            'memoryType',
            'vgaType',
            'operationSystem',
            'osLicense',
            'officeType',
            'officeLicense'
        ])->where('id_kategori', $idKategori)
        ->where('kondisi', '0')->get();
        
        foreach ($devices as $device) {
            if ($device->umur) {
                $parsedDate = Carbon::parse($device->umur);
                $currentDate = Carbon::now();
    
                $yearsDifference = $currentDate->year - $parsedDate->year;
    
                if (
                    $currentDate->month < $parsedDate->month ||
                    ($currentDate->month == $parsedDate->month && $currentDate->day < $parsedDate->day)
                ) {
                    $yearsDifference--;
                }
    
                $device->calculated_age = $yearsDifference;
            } else {
                $device->calculated_age = null;
            }
        }

        $formattedDevices = $devices->map(function ($device) {
            return [
                'id' => $device->id,
                'pendanaan' => $device->pendanaan->no_pmn,
                'nomor_it' => $device->nomor_it,
                'kategori' => $device->kategori->nama ?? '-',
                'sub_kategori' => $device->subKategori->nama ?? '-',
                'processor_type' => $device->processorType->nama ?? '-',
                'storage_type' => $device->storageType->nama ?? '-',
                'storage_capacity' => $device->storage_capacity,
                'memory_type' => $device->memoryType->nama ?? '-',
                'memory_capacity' => $device->memory_capacity,
                'vga_type' => $device->vgaType->nama ?? '-',
                'vga_capacity' => $device->vga_capacity,
                'serial_number' => $device->serial_number,
                'operation_system' => $device->operationSystem->nama ?? '-',
                'os_license' => $device->osLicense->nama ?? '-',
                'office_type' => $device->officeType->nama ?? '-',
                'office_license' => $device->officeLicense->nama ?? '-',
                'umur' => $device->calculated_age === 0 ? '0 tahun' : ($device->calculated_age ? $device->calculated_age . ' tahun' : '-'),                'aplikasi_lainnya' => $device->aplikasi_lainnya,
                'keterangan_tambahan' => $device->keterangan_tambahan,
                'kondisi' => $device->kondisi,
                'foto_kondisi' => $device->foto_kondisi,
            ];
        });
    
        return response()->json($formattedDevices);
    }

    public function editAssetKaryawan($nomor_asset){
        $disDetail = DistributionDetail::where('nomor_asset', $nomor_asset)->first();
        if ($disDetail->status_pengajuan == 1) {
            return view('karyawan.edit-asset-karyawan', compact('disDetail'))->with('status', 'Kerusakan telah diajukan, harap tunggu diverifikasi!');
        }
        return view('karyawan.edit-asset-karyawan', compact('disDetail'));
    }

    public function editFotoAsset(string $id){
        $asset = Asset::find($id);
        $kategori = Kategori::where('jenis_kategori', '2')->get();
        $tipe = SubKategori::all();

        return view('asset.edit-foto', compact(
            ['asset', 'kategori',  'tipe' ]));
    }


    public function updateFotoAsset(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);
        
        $request->validate([
            'kondisi' => 'required|boolean',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:10240',
        ]);
        $file = $request->file('foto');
        $fileName = $file->getClientOriginalName();  
        $path = $file->move(public_path('img'), $fileName);  
        $asset->update([
            'kondisi' => $request->input('kondisi'),
            'foto' => 'img/' . $fileName,
        ]);
    
        return redirect('/detail-notifikasi')->with('success', 'Asset berhasil diperbarui!');
    }

    public function checkNomorAsset(Request $request)
    {
        $nomor_asset = $request->input('nomor_asset');
        
        $exists = Asset::where('nomor_asset', $nomor_asset)->exists();
        $device = Device::where('nomor_it', $nomor_asset)->exists(); 
        if ($exists || $device) {
            return response()->json(['status' => 'taken']);
        }

        return response()->json(['status' => 'available']);
    }


    public function checkNomorAssetDist(Request $request)
    {
        $nomor_asset = $request->input('nomor_asset');
    
        $asset = Asset::where('nomor_asset', $nomor_asset)->first();
    
        if (!$asset) {
            return response()->json(['status' => 'not_registered', 'message' => 'Nomor Asset belum terdaftar']);
        }
    
        $existsInDistribution = DistributionDetail::where('nomor_asset', $nomor_asset)->exists();
    
        $kondisi = $asset->kondisi == 1 ? 'Baik' : 'Rusak';
    
        if ($existsInDistribution) {
            return response()->json([
                'status' => 'distributed',
                'message' => 'Nomor Asset sudah didistribusikan',
                'kondisi' => $kondisi
            ]);
        }
    
        return response()->json([
            'status' => 'available',
            'message' => 'Nomor Asset tersedia, tidak dapat didistribusikan',
            'kondisi' => $kondisi
        ]);
    }
    
    


}
