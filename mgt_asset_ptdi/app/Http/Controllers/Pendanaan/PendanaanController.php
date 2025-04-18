<?php

namespace App\Http\Controllers\Pendanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendanaan;

class PendanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); 
    
        $pendanaan = Pendanaan::when($search, function ($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('no_pmn', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%')
                      ->orWhere('tanggal', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('no_pmn', 'asc')
        ->paginate(10);
    
        if ($request->ajax()) {
            return view('pendanaan.component.tabel_pendanaan', ['pendanaan' => $pendanaan]);
        }
    
        return view('pendanaan.pendanaan', compact('pendanaan'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pendanaan.tambah_pendanaan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_pmn' => 'required|unique:pendanaan,no_pmn',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'file_attach' => 'required|file|mimes:pdf|max:10240',  
        ]);

        if ($request->hasFile('file_attach') && $request->file('file_attach')->isValid()) {
            $file = $request->file('file_attach');  
            $fileName = $file->getClientOriginalName();  
            $path = $file->move(public_path('dokumen_pendanaan'), $fileName);  
        } else {
            return back()->withErrors(['file_attach' => 'File dokumen tidak valid atau tidak ditemukan.']);
        }

        $pendanaan = Pendanaan::create([
            'no_pmn' => $request->no_pmn,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'file_attach' => 'dokumen_pendanaan/' . $fileName, 
        ]);

        return redirect('/pendanaan')->with('success', 'Pendanaan berhasil ditambahkan.');
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
        
        $pendanaan = Pendanaan::findOrFail($id);
        return view('pendanaan.edit_pendanaan', compact('pendanaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pendanaan = Pendanaan::findOrFail($id);
    
        $request->validate([
            'no_pmn' => 'required|unique:pendanaan,no_pmn,' . $pendanaan->id, 
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'file_attach' => 'nullable|file|mimes:pdf|max:10240', 
        ]);
    
        if ($request->hasFile('file_attach') && $request->file('file_attach')->isValid()) {
            $file = $request->file('file_attach');
            $fileName = $file->getClientOriginalName();
            $path = $file->move(public_path('dokumen_pendanaan'), $fileName);
    
            $pendanaan->file_attach = 'dokumen_pendanaan/' . $fileName; 
        }
    
        $pendanaan->update([
            'no_pmn' => $request->no_pmn,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'file_attach' => 'dokumen_pendanaan/' . $fileName,
        ]);
    
        $pendanaan->save(); 
    
        return redirect('/pendanaan')->with('success', 'Pendanaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pendanaan = Pendanaan::where('id', $id)->first();
        if ($pendanaan){
            $pendanaan->delete();
            return redirect()->route('pendanaan.index')->with('success', 'Pendanaan berhasil dihapus');
        }
    
        return redirect()->route('pendanaan.index')->with('error', 'Pendanaan tidak ditemukan');
    }

    public function checkPMN(Request $request)
    {
        $request->validate([
            'no_pmn' => 'required|unique:pendanaan,no_pmn', 
        ]);

        return response()->json(['status' => 'available']);
    }
}
