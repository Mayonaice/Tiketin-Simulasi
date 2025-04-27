<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\JadwalPenerbangan;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jadwals = JadwalPenerbangan::all();
        $jadwal_id = $request->get('jadwal_id');
        $tikets = Tiket::with('jadwal');
        if ($jadwal_id) {
            $tikets = $tikets->where('jadwal_id', $jadwal_id);
        }
        $tikets = $tikets->get();
        return view('tiket.index', compact('tikets', 'jadwals', 'jadwal_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = JadwalPenerbangan::with('maskapai', 'kotaAsal', 'kotaTujuan')->findOrFail($id);
        $tikets = Tiket::where('jadwal_id', $id)->get();
        return view('tiket.show', compact('jadwal', 'tikets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
