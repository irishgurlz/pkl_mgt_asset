<?php

namespace App\Http\Controllers\Asset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $kategori = Kategori::all();

        $subKategorisQuery = SubKategori::join('kategori', 'sub_kategori.id_kategori', '=', 'kategori.id')
            ->orderBy('kategori.nama', 'asc')  
            ->orderBy('sub_kategori.nama', 'asc')  
            ->select('sub_kategori.*');
        
        if (!empty($search)) {
            $subKategorisQuery->where(function ($query) use ($search) {
                $query->where('sub_kategori.nama', 'like', "%{$search}%")
                    ->orWhere('kategori.nama', 'like', "%{$search}%");
            });
        }

        $subKategoris = $subKategorisQuery->paginate(10);

        if ($request->ajax()) {
            return view('endpoint device.type kategori.component.search_table_tipe', compact('subKategoris'));
        }
        return view('endpoint device.type kategori.type_kategori', compact(['subKategoris', 'kategori']));
    }

    public function getSubByKategori($idKategori)
    {
        $subKategori = SubKategori::with('kategori')->where('id_kategori', $idKategori)->get();
        return response()->json($subKategori);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $subKategori = SubKategori::all();
        return view('endpoint device.type kategori.tambah_tipe', compact(['kategori', 'subKategori']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
        ]);

            $subKategori = SubKategori::create([
                'id_kategori' => $request->kategori, 
                'nama' => $request->nama,
            ]);
    
            return redirect()->route('sub-kategori.index')->with('success', 'Sub kategori berhasil ditambahkan!');

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
        $kategori = Kategori::all();
        $subKategori = SubKategori::findOrFail($id); 
        return view('endpoint device.type kategori.edit_type', compact(['kategori', 'subKategori']));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
        ]);
    
        try {
            $subKategori = SubKategori::findOrFail($id);
            $subKategori->update([
                'id_kategori' => $request->kategori, 
                'nama' => $request->nama,
            ]);
    
            return redirect()->route('sub-kategori.index')->with('success', 'Sub kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subKategori = SubKategori::where('id', $id)->first();

        if ($subKategori) {
            $subKategori->delete();
            return redirect()->route('sub-kategori.index')->with('success', 'Sub kategori berhasil dihapus');
        }
    
        return redirect()->route('sub-kategori.index')->with('error', 'Sub kategori tidak ditemukan');
 
    }


    public function checkNama(Request $request)
    {
        $nama = $request->input('nama');
        
        $exists = SubKategori::where('nama', $nama)->exists(); 
        if ($exists) {
            return response()->json(['status' => 'taken']);
        }

        return response()->json(['status' => 'available']);
    }
}
