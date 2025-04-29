<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maskapai;
use Illuminate\Support\Facades\Storage;

class MaskapaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maskapais = Maskapai::all();
        return view('dashboard.petugas', compact('maskapais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maskapai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:100',
            'kode_maskapai' => 'required|string|max:10|unique:maskapais,kode_maskapai',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->only(['nama_maskapai', 'kode_maskapai']);
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('maskapai_logos', 'public');
            $data['logo_path'] = $path;
        }
        
        Maskapai::create($data);
        return redirect()->route('maskapai.index')->with('success', 'Maskapai berhasil ditambahkan!');
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
        $maskapai = Maskapai::findOrFail($id);
        return view('maskapai.edit', compact('maskapai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $maskapai = Maskapai::findOrFail($id);
        $request->validate([
            'nama_maskapai' => 'required|string|max:100',
            'kode_maskapai' => 'required|string|max:10|unique:maskapais,kode_maskapai,' . $maskapai->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->only(['nama_maskapai', 'kode_maskapai']);
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($maskapai->logo_path && Storage::disk('public')->exists($maskapai->logo_path)) {
                Storage::disk('public')->delete($maskapai->logo_path);
            }
            
            // Upload new logo
            $path = $request->file('logo')->store('maskapai_logos', 'public');
            $data['logo_path'] = $path;
        }
        
        $maskapai->update($data);
        return redirect()->route('maskapai.index')->with('success', 'Maskapai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maskapai = Maskapai::findOrFail($id);
        
        // Delete logo file if exists
        if ($maskapai->logo_path && Storage::disk('public')->exists($maskapai->logo_path)) {
            Storage::disk('public')->delete($maskapai->logo_path);
        }
        
        $maskapai->delete();
        return redirect()->route('maskapai.index')->with('success', 'Maskapai berhasil dihapus!');
    }
}
