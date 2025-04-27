<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPenerbangan;
use App\Models\Maskapai;
use App\Models\Kota;
use App\Models\Tiket;

class JadwalPenerbanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        return view('jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maskapais = Maskapai::all();
        $kotas = Kota::all();
        return view('jadwal.create', compact('maskapais', 'kotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'maskapai_id' => 'required|exists:maskapais,id',
            'kota_asal_id' => 'required|exists:kotas,id|different:kota_tujuan_id',
            'kota_tujuan_id' => 'required|exists:kotas,id|different:kota_asal_id',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'harga_tiket' => 'required|numeric|min:0',
            'kapasitas_kursi' => 'required|integer|min:1',
        ]);
        $data = $request->all();
        $data['sisa_kursi'] = $data['kapasitas_kursi'];
        $jadwal = JadwalPenerbangan::create($data);
        // Generate tiket otomatis
        for ($i = 1; $i <= $jadwal->kapasitas_kursi; $i++) {
            Tiket::create([
                'jadwal_id' => $jadwal->id,
                'kode_tiket' => strtoupper('TK'.$jadwal->id.str_pad($i, 4, '0', STR_PAD_LEFT)),
                'status' => 'tersedia',
            ]);
        }
        return redirect()->route('jadwal.index')->with('success', 'Jadwal penerbangan & tiket berhasil ditambahkan!');
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
        $jadwal = JadwalPenerbangan::findOrFail($id);
        $maskapais = Maskapai::all();
        $kotas = Kota::all();
        return view('jadwal.edit', compact('jadwal', 'maskapais', 'kotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPenerbangan::findOrFail($id);
        $request->validate([
            'maskapai_id' => 'required|exists:maskapais,id',
            'kota_asal_id' => 'required|exists:kotas,id|different:kota_tujuan_id',
            'kota_tujuan_id' => 'required|exists:kotas,id|different:kota_asal_id',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'harga_tiket' => 'required|numeric|min:0',
            'kapasitas_kursi' => 'required|integer|min:1',
        ]);
        $data = $request->all();
        // Jika kapasitas diubah, update sisa kursi jika perlu
        if ($jadwal->kapasitas_kursi != $data['kapasitas_kursi']) {
            $data['sisa_kursi'] = $data['kapasitas_kursi'];
        }
        $jadwal->update($data);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal penerbangan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = JadwalPenerbangan::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal penerbangan berhasil dihapus!');
    }
}
