<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Employee;
use Validator;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jabatan = Jabatan::orderBy('nama', 'asc')->when($search, function($query, $search) {
            return $query->where('nama', 'like', '%'.$search.'%');
        })
        ->paginate(5);
        
        if ($request->ajax()) {
            return view('employee.jabatan.table_jabatan', compact('jabatan')); 
        }
    
        return view('employee.jabatan.daftar_jabatan', compact('jabatan'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('employee.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jabatan = Jabatan::create([
            'nama' => $request->nama,
        ]);

        return redirect('/jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
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
        $jabatan = Jabatan::find($id);
        return view('employee.jabatan.edit_jabatan', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jabatan = Jabatan::find($id);

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);
    
        $jabatan->update([
            'nama' => $request->nama,
        ]);

        return redirect('/jabatan')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::find($id);
        $isUsed = Employee::where('kode_jabatan', $jabatan->id)->exists();
    
        if ($isUsed) {
            return redirect('/jabatan')->with('error', 'Jabatan tidak bisa dihapus karena masih digunakan di tabel lain.');
        }
        else{
            $jabatan->listEmployee()->delete();
            $jabatan->delete();
        }
        return redirect('/jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}
