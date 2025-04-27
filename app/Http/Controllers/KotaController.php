<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kotas = Kota::all();
        return view('kota.index', compact('kotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kota' => 'required|string|max:100',
            'kode_bandara' => 'required|string|max:10',
        ]);
        Kota::create($request->only(['nama_kota', 'kode_bandara']));
        return redirect()->route('kota.index')->with('success', 'Kota berhasil ditambahkan!');
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
        $kota = Kota::findOrFail($id);
        return view('kota.edit', compact('kota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kota = Kota::findOrFail($id);
        $request->validate([
            'nama_kota' => 'required|string|max:100',
            'kode_bandara' => 'required|string|max:10',
        ]);
        $kota->update($request->only(['nama_kota', 'kode_bandara']));
        return redirect()->route('kota.index')->with('success', 'Kota berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->delete();
        return redirect()->route('kota.index')->with('success', 'Kota berhasil dihapus!');
    }
}
