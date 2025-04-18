<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use App\Models\Organisasi;
use App\Models\Employee;

use Validator;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $org = Organisasi::orderBy('nama', 'asc')->when($search, function($query) use ($search) {
            return $query->where(function($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('kode_org', 'like', '%' . $search . '%');
            });
        })->paginate(10);
        
    
        if ($request->ajax()) {
            return view('employee.organisasi.table_organisasi', compact('org'));
        }
    
        return view('employee.organisasi.daftar_organisasi', compact('org'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('employee.organisasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_org' => 'required|string|max:255|unique:organisasi,kode_org',
            'nama' => 'required|string|max:255',
        ]);
    
        $org = Organisasi::create([
            'kode_org' => $request->kode_org,
            'nama' => $request->nama,
        ]);

        return redirect('/organisasi')->with('success', 'Organisasi berhasil ditambahkan.');
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
        $org = Organisasi::find($id);
        return view('employee.organisasi.edit_organisasi', compact('org'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $org = Organisasi::where('kode_org', $request->kode_org)->first();
    
        $request->validate([
            'kode_org' => 'required|string|max:255|unique:organisasi,kode_org,' . $org->id,
            'nama' => 'required|string|max:255',
        ]);
    
        $org->update([
            'kode_org' => $request->kode_org,
            'nama' => $request->nama,
        ]);
        return redirect('/organisasi')->with('success', 'Organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) 
    {
        $org = Organisasi::find($id);
    
        if (!$org) {
            return redirect('/organisasi')->with('error', 'Organisasi tidak ditemukan.');
        }
    
        $isUsed = Employee::where('kode_org', $org->kode_org)->exists();
    
        if ($isUsed) {
            return redirect('/organisasi')->with('error', 'Organisasi tidak bisa dihapus karena masih digunakan di tabel lain.');
        }
    
        $org->listEmployee()->delete();
    
        $org->delete();
    
        return redirect('/organisasi')->with('success', 'Organisasi berhasil dihapus.');
    }
    
}
