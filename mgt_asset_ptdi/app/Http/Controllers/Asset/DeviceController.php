<?php

namespace App\Http\Controllers\Asset;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Pendanaan;
use App\Models\Asset;
use App\Models\DistributionDetail;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $search = $request->input('search');
     
         $kategori = Kategori::where('jenis_kategori', '1')->get();
         $relations = [
             'kategori', 'subKategori', 'processorType', 
             'storageType', 'memoryType', 'vgaType', 
             'operationSystem', 'osLicense', 'officeType'
         ];
     
         $devices = Device::with($relations)
            ->where('kondisi', '1') 
            ->when($search, function ($query, $search) use ($relations) {
                $query->where(function ($query) use ($search, $relations) {
                    $query->where('nomor_it', 'like', "%{$search}%")
                        ->orWhere('no_pmn', 'like', "%{$search}%")
                        ->orWhere('storage_capacity', 'like', "%{$search}%")
                        ->orWhere('vga_capacity', 'like', "%{$search}%")
                        ->orWhere('memory_capacity', 'like', "%{$search}%")
                        ->orWhere('serial_number', 'like', "%{$search}%")
                        ->orWhere('aplikasi_lainnya', 'like', "%{$search}%")
                        ->orWhere('keterangan_tambahan', 'like', "%{$search}%")
                        ->orWhereRaw("(CASE 
                                            WHEN kondisi = 1 THEN 'Baik' 
                                            WHEN kondisi = 0 THEN 'Rusak' 
                                        END) LIKE ?", ["%$search%"]);
                
                    
                    // Jika pencarian berupa angka, cari berdasarkan umur
                    if (is_numeric($search)) {
                        $query->orWhereRaw("TIMESTAMPDIFF(YEAR, umur, CURDATE()) = ?", [$search]);
                    }

                    // Cari juga di relasi
                    foreach ($relations as $relation) {
                        $query->orWhereHas($relation, function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                    }
                });
            })
            ->orderBy('nomor_it', 'asc')
            ->paginate(10);
             
     
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
         
     
         if ($request->ajax()) {
             return view('endpoint device.device.component.search_table_device', ['devices' => $devices]);
         }
     
         return view('endpoint device.device.device', ['devices' => $devices, 'kategori' => $kategori]);
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $device = Device::all();
        $kategori = Kategori::where('jenis_kategori', '1')->get();;
        $tipe = SubKategori::all();

        $processor = SubKategori::where('id_kategori', 2)->get();
        $storageType = SubKategori::where('id_kategori', 5)->get();
        $memoryType = SubKategori::where('id_kategori', 6)->get();
        $VGAType = SubKategori::where('id_kategori', 7)->get();
        $osType = SubKategori::where('id_kategori', 8)->get();
        $officeType = SubKategori::where('id_kategori', 9)->get();
        $license = SubKategori::where('id_kategori', 10)->get();
        return view('endpoint device.device.tambah_device', compact(
            ['device', 'kategori',  'tipe', 'processor', 'storageType', 'memoryType', 'VGAType', 'osType', 'officeType', 'license',]));

    }

    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
    {
        $request->validate([
            'no_pmn' => 'required|exists:pendanaan,no_pmn',
            'nomor_it' => 'required|string|unique:device,nomor_it|unique:asset,nomor_asset',
            'id_kategori' => 'required|exists:kategori,id',
            'id_tipe' => 'required|exists:sub_kategori,id',
            'processor' => 'required|exists:sub_kategori,id',
            'storage_type' => 'required|exists:sub_kategori,id',
            'storage_capacity' => 'required|integer',
            'memory_type' => 'required|exists:sub_kategori,id',
            'memory_capacity' => 'required|integer',
            'vga_type' => 'required|exists:sub_kategori,id',
            'vga_capacity' => 'required|integer',
            'serial_number' => 'required|string',
            'operation_system' => 'required|exists:sub_kategori,id',
            'os_license' => 'required|exists:sub_kategori,id',
            'office' => 'required|exists:sub_kategori,id',
            'office_license' => 'required|exists:sub_kategori,id',
            'umur' => 'required|date',
            'aplikasi_lainnya' => 'required|string',
            'keterangan_tambahan' => 'required|string',
            'kondisi' => 'required|in:0,1',
            'foto_kondisi' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);
    
        $deviceData = [
            'no_pmn' => $request->no_pmn,
            'nomor_it' => $request->nomor_it,
            'id_kategori' => $request->id_kategori,
            'id_tipe' => $request->id_tipe,
            'processor' => $request->processor,
            'storage_type' => $request->storage_type,
            'storage_capacity' => $request->storage_capacity,
            'memory_type' => $request->memory_type,
            'memory_capacity' => $request->memory_capacity,
            'vga_type' => $request->vga_type,
            'vga_capacity' => $request->vga_capacity,
            'serial_number' => $request->serial_number,
            'operation_system' => $request->operation_system,
            'os_license' => $request->os_license,
            'office' => $request->office,
            'office_license' => $request->office_license,
            'umur' => $request->umur,
            'aplikasi_lainnya' => $request->aplikasi_lainnya,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'kondisi' => $request->kondisi,
        ];
    
        if ($request->hasFile('foto_kondisi')) {
            $file = $request->file('foto_kondisi');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('foto_kondisi_device'), $fileName);
            $deviceData['foto_kondisi'] = 'foto_kondisi_device/' . $fileName;
        }
    
        Device::create($deviceData);
    
        if ($request->kondisi == '0') {
            return redirect('/asset/barang-rusak')
                ->with('success', 'Device berhasil ditambahkan.');
        }
    
        return redirect('/device')->with('success', 'Device berhasil ditambahkan.');
    }
    public function fetchNoPMN(Request $request)
    {
        $no_pmn = $request->no_pmn;
        if (!$no_pmn) {
            return response()->json([
                'success' => false,
                'message' => 'No PMN harus diisi.',
            ]);
        }
        $pendanaan = Pendanaan::whereRaw('BINARY `no_pmn` = ?', [$no_pmn])->first();
        if ($pendanaan) {
            return response()->json([
                'success' => true,
                'no_pmn' => $pendanaan->no_pmn,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data pendanaan tidak ditemukan.',
            ]);
        }
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
        $device = Device::findOrFail($id); 
        $kategori = Kategori::where('jenis_kategori', '1')->get();;
        $subkategori = SubKategori::all();

        $processor = SubKategori::where('id_kategori', 2)->get();
        $storageType = SubKategori::where('id_kategori', 5)->get();
        $memoryType = SubKategori::where('id_kategori', 6)->get();
        $VGAType = SubKategori::where('id_kategori', 7)->get();
        $osType = SubKategori::where('id_kategori', 8)->get();
        $officeType = SubKategori::where('id_kategori', 9)->get();
        $license = SubKategori::where('id_kategori', 10)->get();
        return view('endpoint device.device.edit_device', compact(['device', 'kategori',  'subkategori', 'processor', 'storageType', 'memoryType', 'VGAType', 'osType', 'officeType', 'license']));
    }

    public function getDeviceByKategori($idKategori)
    {
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
        ->where('kondisi', '1')->get();
        
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
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $device = Device::findOrFail($id);

        $request->validate([
            'no_pmn' => 'required|exists:pendanaan,no_pmn',
            'nomor_it' => 'required|unique:device,nomor_it,' . $id . '|unique:asset,nomor_asset,' . $id,
            'id_kategori' => 'required|exists:kategori,id',
            'id_tipe' => 'required|exists:sub_kategori,id',
            'processor' => 'required|exists:sub_kategori,id',
            'storage_type' => 'required|exists:sub_kategori,id',
            'storage_capacity' => 'required|integer',
            'memory_type' => 'required|exists:sub_kategori,id',
            'memory_capacity' => 'required|integer',
            'vga_type' => 'required|exists:sub_kategori,id',
            'vga_capacity' => 'required|integer',
            'serial_number' => 'required|string',
            'operation_system' => 'required|exists:sub_kategori,id',
            'os_license' => 'required|exists:sub_kategori,id',
            'office' => 'required|exists:sub_kategori,id',
            'office_license' => 'required|exists:sub_kategori,id',
            'umur' => 'required|date',
            'aplikasi_lainnya' => 'required|string',
            'keterangan_tambahan' => 'required|string',
            'kondisi' => 'required|in:0,1',
            'foto_kondisi' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $updateData = [
            'no_pmn' => $request->no_pmn,
            'nomor_it' => $request->nomor_it,
            'id_kategori' => $request->id_kategori,
            'id_tipe' => $request->id_tipe,
            'processor' => $request->processor,
            'storage_type' => $request->storage_type,
            'storage_capacity' => $request->storage_capacity,
            'memory_type' => $request->memory_type,
            'memory_capacity' => $request->memory_capacity,
            'vga_type' => $request->vga_type,
            'vga_capacity' => $request->vga_capacity,
            'serial_number' => $request->serial_number,
            'operation_system' => $request->operation_system,
            'os_license' => $request->os_license,
            'office' => $request->office,
            'office_license' => $request->office_license,
            'umur' => $request->umur,
            'aplikasi_lainnya' => $request->aplikasi_lainnya,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'kondisi' => $request->kondisi,
        ];

        if ($request->hasFile('foto_kondisi') && $request->file('foto_kondisi')->isValid()) {
            if ($device->foto_kondisi && file_exists(public_path($device->foto_kondisi))) {
                unlink(public_path($device->foto_kondisi));
            }

            $file = $request->file('foto_kondisi');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_kondisi_device'), $fileName);

            $updateData['foto_kondisi'] = 'foto_kondisi_device/' . $fileName;
        }

        $device->update($updateData);

        if ($request->kondisi == '0') {
            return redirect('/asset/barang-rusak')->with('success', 'Kondisi device berhasil diperbarui.');
        }
        return redirect('/device')->with('success', 'Device berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = Device::find($id);
        if (!$device){
            return redirect()->route('device.index')->with('error', 'Device tidak ditemukan');
        }

        $kondisi = $device->kondisi;
        $device->delete();

        if ($kondisi == '0') {
            return redirect('/asset/barang-rusak')->with('success', 'Device berhasil dihapus');
        }
        return redirect()->route('device.index')->with('success', 'Device berhasil dihapus');
    }

    // public function getDeviceData()
    // {
    //     $devices = Device::selectRaw("FLOOR(DATEDIFF(CURDATE(), umur) / 365) as age, kondisi")
    //         ->get()
    //         ->groupBy('age')
    //         ->map(function ($items, $age) {
    //             return [
    //                 'age' => $age,
    //                 'baik' => $items->where('kondisi', '1')->count(),
    //                 'rusak' => $items->where('kondisi', '0')->count(),
    //             ];
    //         })
    //         ->filter(function ($data) {
    //             return $data['age'] >= 3;
    //         })
    //         ->values();
    
    //     Log::info('Device Data:', $devices->toArray());
    
    //     return view('component.grafik_umur_device', [
    //         'deviceDataJson' => $devices->toJson(),
    //     ]);
    // }

    // public function fetchDeviceData()
    // {
    //     $threeYearsAgo = Carbon::now()->subYears(3)->toDateString();

    //     $deviceDataQuery = DB::table('device')
    //         ->select(
    //             DB::raw("DAYNAME(umur) as day"),
    //             DB::raw("SUM(CASE WHEN kondisi = '1' THEN 1 ELSE 0 END) as deposit"),
    //             DB::raw("SUM(CASE WHEN kondisi = '0' THEN 1 ELSE 0 END) as withdraw")
    //         )
    //         ->where('umur', '<=', $threeYearsAgo)
    //         ->groupBy(DB::raw("DAYNAME(umur)"));

    //     // Log SQL query
    //     \Log::info('Device Data Query:', ['query' => $deviceDataQuery->toSql()]);

    //     $deviceData = $deviceDataQuery->get();

    //     return response()->json($deviceData);
    // }

    public function fetchDeviceData()
    {
        $deviceDataQuery = DB::table('device')
            ->select(
                DB::raw("SUM(CASE WHEN kondisi = '1' THEN 1 ELSE 0 END) as baik"), 
                DB::raw("SUM(CASE WHEN kondisi = '0' THEN 1 ELSE 0 END) as rusak") 
            )
            ->whereRaw("TIMESTAMPDIFF(YEAR, umur, CURRENT_DATE) >= 3") 
            ->get();
    
        return response()->json($deviceDataQuery);
    }



    public function editDeviceKaryawan($nomor_it){
        $disDetail = DistributionDetail::where('nomor_it', $nomor_it)->firstOrFail();
        if ($disDetail->status_pengajuan == 1) {
            return view('karyawan.device-rusak-karyawan', compact('disDetail'))->with('status', 'Kerusakan telah diajukan, harap tunggu diverifikasi!');
        }
        return view('karyawan.device-rusak-karyawan', compact('disDetail'));
    }

    public function karyawanEditDev($nomor_it)
    {
        $device = Device::where('nomor_it', $nomor_it)->firstOrFail(); 
        $kategori = Kategori::where('jenis_kategori', '1')->get();;
        $subkategori = SubKategori::all();

        $storageType = SubKategori::where('id_kategori', 5)->get();
        $memoryType = SubKategori::where('id_kategori', 6)->get();
        $VGAType = SubKategori::where('id_kategori', 7)->get();
        return view('karyawan.edit-device-karyawan', compact(['device', 'kategori',  'subkategori', 'storageType', 'memoryType', 'VGAType']));
    }

    public function karyawanUpdateDev(Request $request, $nomor_it)
    {
        $device = Device::where('nomor_it', $nomor_it)->first();
    
        $request->validate([
            'storage_type' => 'required|integer|exists:sub_kategori,id',
            'memory_type' => 'required|integer|exists:sub_kategori,id',
            'vga_type' => 'required|integer|exists:sub_kategori,id',
            'storage_capacity' => 'required|integer',
            'memory_capacity' => 'required|integer',
            'vga_capacity' => 'required|integer',
        ]);
    
        Log::info('Request yang diterima:', $request->all());
    
        $device->update([
            'storage_type' => $request->storage_type,
            'memory_type' => $request->memory_type,
            'vga_type' => $request->vga_type,
            'storage_capacity' => $request->storage_capacity,
            'memory_capacity' => $request->memory_capacity,
            'vga_capacity' => $request->vga_capacity,
        ]);
        
        return redirect('/karyawan/dashboard')->with('success', 'Device berhasil diupdate.');
    }


    public function editFotoDevice(string $id)
    {
        $device = Device::findOrFail($id); 
        $kategori = Kategori::where('jenis_kategori', '1')->get();;
        $subkategori = SubKategori::all();

        $processor = SubKategori::where('id_kategori', 2)->get();
        $storageType = SubKategori::where('id_kategori', 5)->get();
        $memoryType = SubKategori::where('id_kategori', 6)->get();
        $VGAType = SubKategori::where('id_kategori', 7)->get();
        $osType = SubKategori::where('id_kategori', 8)->get();
        $officeType = SubKategori::where('id_kategori', 9)->get();
        $license = SubKategori::where('id_kategori', 10)->get();
        return view('endpoint device.device.edit-foto-device', compact(['device', 'kategori',  'subkategori', 'processor', 'storageType', 'memoryType', 'VGAType', 'osType', 'officeType', 'license']));
    }


    public function updateFotoDevice(Request $request, string $id)
    {
        try {
            $device = Device::findOrFail($id);
            $device->update($request->all());

            $request->validate([
                'foto_kondisi' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            ]);
            
            if ($request->hasFile('foto_kondisi') && $request->file('foto_kondisi')->isValid()) {
                $file = $request->file('foto_kondisi');  
                $fileName = $file->getClientOriginalName();  
                $path = $file->move(public_path('foto_kondisi_device'), $fileName);  
            } else {
                return back()->withErrors(['foto_kondisi' => 'File tidak valid atau tidak ditemukan.']);
            }
            \Log::info('Path gambar disimpan: ' . $path);

            $device = Device::findOrFail($id);
            $device->update([
                'foto_kondisi' => 'foto_kondisi_device/' .$fileName,
            ]);
            
            if ($request->kondisi == '0') {
                return redirect('/detail-notifikasi')
                    ->with('success', 'Kondisi device berhasil diperbarui');
            }
            elseif ($request->kondisi == '1') {
                return redirect('/detail-notifikasi')
                    ->with('success', 'Kondisi device berhasil diperbarui.');
            }
        } catch (\Exception $e) {
            \Log::error('Error updating device:', ['error' => $e->getMessage()]);
            dd($e->getMessage());
        }
        return redirect('/detail-notifikasi')->with('success', 'Device berhasil diperbarui.');
    }

    public function checkNomorIT(Request $request)
    {
        $nomor_it = $request->input('nomor_it');
    
        $existsInDevice = Device::where('nomor_it', $nomor_it)->exists();
        $existsInAsset = Asset::where('nomor_asset', $nomor_it)->exists(); 
    
        if ($existsInDevice || $existsInAsset) {
            return response()->json(['status' => 'taken']);
        }
    
        return response()->json(['status' => 'available']);
    }



    public function checkNomorITDist(Request $request)
    {
        $nomor_it = $request->input('nomor_it');
    
        $device = Device::where('nomor_it', $nomor_it)->first();
    
        if (!$device) {
            return response()->json(['status' => 'not_registered', 'message' => 'Nomor Asset belum terdaftar']);
        }
    
        $existsInDistribution = DistributionDetail::where('nomor_it', $nomor_it)->exists();
    
        $kondisi = $device->kondisi == 1 ? 'Baik' : 'Rusak';
    
        if ($existsInDistribution) {
            return response()->json([
                'status' => 'distributed',
                'message' => 'Nomor Asset sudah didistribusikan',
                'kondisi' => $kondisi
            ]);
        }
    
        return response()->json([
            'status' => 'available',
            'message' => 'Nomor Asset tersedia, belum didistribusikan',
            'kondisi' => $kondisi
        ]);
    }
    
    


}
