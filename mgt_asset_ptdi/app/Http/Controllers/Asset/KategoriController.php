<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $kategoris = Kategori::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })
        ->orderBy('nama', 'asc')
        ->paginate(10);

        if ($request->ajax()) {
            return view('endpoint device.kategori.component.search_table', compact('kategoris'));
        }

        return view('endpoint device.kategori.kategori', compact('kategoris', 'search'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori=Kategori::all();
        return view('endpoint device.kategori.tambah_kategori', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kategori' => 'required|string|in:0,1,2', 
            'nama' => 'required|string|max:255',  
        ]);

        // Simpan data ke database
        Kategori::create([
            'nama' => $request->input('nama'),
            'jenis_kategori' => $request->input('jenis_kategori')
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
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
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id); 
        return view('endpoint device.kategori.edit_kategori', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kategori' => 'required|string|in:0,1,2',
        ]);
    
            $kategori = Kategori::findOrFail($id);    
            $kategori->update([
                'nama' => $request->nama,
                'jenis_kategori' => $request->jenis_kategori,
            ]);
    
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::where('id', $id)->first();

        if ($kategori) {
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
        }
    
        return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
    }


    public function checkNama(Request $request)
    {
        $nama = $request->input('nama');
        
        $exists = Kategori::where('nama', $nama)->exists(); 
        if ($exists) {
            return response()->json(['status' => 'taken']);
        }

        return response()->json(['status' => 'available']);
    }
}
