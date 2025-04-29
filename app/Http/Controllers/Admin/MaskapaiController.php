<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maskapai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaskapaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maskapais = Maskapai::all();
        return view('admin.maskapai.index', compact('maskapais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.maskapai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:100',
            'kode_maskapai' => 'required|string|max:10|unique:maskapais',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $maskapai = new Maskapai();
        $maskapai->nama_maskapai = $request->nama_maskapai;
        $maskapai->kode_maskapai = $request->kode_maskapai;
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('maskapai', $logoName, 'public');
            $maskapai->logo_path = $logoPath;
        }
        
        $maskapai->save();

        return redirect()->route('admin.maskapai.index')
                         ->with('success', 'Maskapai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maskapai $maskapai)
    {
        return view('admin.maskapai.show', compact('maskapai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maskapai $maskapai)
    {
        return view('admin.maskapai.edit', compact('maskapai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maskapai $maskapai)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:100',
            'kode_maskapai' => 'required|string|max:10|unique:maskapais,kode_maskapai,' . $maskapai->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $maskapai->nama_maskapai = $request->nama_maskapai;
        $maskapai->kode_maskapai = $request->kode_maskapai;
        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($maskapai->logo_path) {
                Storage::disk('public')->delete($maskapai->logo_path);
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('maskapai', $logoName, 'public');
            $maskapai->logo_path = $logoPath;
        }
        
        $maskapai->save();

        return redirect()->route('admin.maskapai.index')
                         ->with('success', 'Data maskapai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maskapai $maskapai)
    {
        // Delete logo if exists
        if ($maskapai->logo_path) {
            Storage::disk('public')->delete($maskapai->logo_path);
        }
        
        $maskapai->delete();

        return redirect()->route('admin.maskapai.index')
                         ->with('success', 'Maskapai berhasil dihapus!');
    }
} 