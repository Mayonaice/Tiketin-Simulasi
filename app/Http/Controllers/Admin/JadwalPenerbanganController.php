<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenerbangan;
use App\Models\Maskapai;
use App\Models\Kota;
use App\Models\Tiket;
use Illuminate\Http\Request;

class JadwalPenerbanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maskapais = Maskapai::all();
        $kotas = Kota::all();
        return view('admin.jadwal.create', compact('maskapais', 'kotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'maskapai_id' => 'required|exists:maskapais,id',
            'kota_asal_id' => 'required|exists:kotas,id',
            'kota_tujuan_id' => 'required|exists:kotas,id|different:kota_asal_id',
            'tanggal_berangkat' => 'required|date|after_or_equal:today',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required|after:jam_berangkat',
            'harga_tiket' => 'required|numeric|min:1',
            'kapasitas_kursi' => 'required|integer|min:1',
        ]);

        // Create the flight schedule
        $jadwal = JadwalPenerbangan::create([
            'maskapai_id' => $request->maskapai_id,
            'kota_asal_id' => $request->kota_asal_id,
            'kota_tujuan_id' => $request->kota_tujuan_id,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'jam_tiba' => $request->jam_tiba,
            'harga_tiket' => $request->harga_tiket,
            'kapasitas_kursi' => $request->kapasitas_kursi,
            'sisa_kursi' => $request->kapasitas_kursi,
        ]);

        // Generate tickets for this schedule
        for ($i = 1; $i <= $request->kapasitas_kursi; $i++) {
            Tiket::create([
                'jadwal_id' => $jadwal->id,
                'kode_tiket' => strtoupper('TK'.$jadwal->id.str_pad($i, 4, '0', STR_PAD_LEFT)),
                'status' => 'tersedia',
            ]);
        }

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal penerbangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPenerbangan $jadwal)
    {
        $jadwal->load(['maskapai', 'kotaAsal', 'kotaTujuan']);
        $tikets = Tiket::where('jadwal_id', $jadwal->id)->get();
        $ticketStats = [
            'tersedia' => Tiket::where('jadwal_id', $jadwal->id)->where('status', 'tersedia')->count(),
            'dipesan' => Tiket::where('jadwal_id', $jadwal->id)->where('status', 'dipesan')->count(),
            'terjual' => Tiket::where('jadwal_id', $jadwal->id)->where('status', 'terjual')->count(),
        ];
        
        return view('admin.jadwal.show', compact('jadwal', 'tikets', 'ticketStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPenerbangan $jadwal)
    {
        $maskapais = Maskapai::all();
        $kotas = Kota::all();
        return view('admin.jadwal.edit', compact('jadwal', 'maskapais', 'kotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPenerbangan $jadwal)
    {
        $request->validate([
            'maskapai_id' => 'required|exists:maskapais,id',
            'kota_asal_id' => 'required|exists:kotas,id',
            'kota_tujuan_id' => 'required|exists:kotas,id|different:kota_asal_id',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required|after:jam_berangkat',
            'harga_tiket' => 'required|numeric|min:1',
        ]);

        // Get current tickets count
        $currentTickets = Tiket::where('jadwal_id', $jadwal->id)->count();
        
        $jadwal->update([
            'maskapai_id' => $request->maskapai_id,
            'kota_asal_id' => $request->kota_asal_id,
            'kota_tujuan_id' => $request->kota_tujuan_id,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'jam_tiba' => $request->jam_tiba,
            'harga_tiket' => $request->harga_tiket,
        ]);

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal penerbangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPenerbangan $jadwal)
    {
        // Check if there are any sold tickets
        $soldTickets = Tiket::where('jadwal_id', $jadwal->id)
                          ->whereIn('status', ['dipesan', 'terjual'])
                          ->exists();
        
        if ($soldTickets) {
            return redirect()->route('admin.jadwal.index')
                           ->with('error', 'Jadwal tidak dapat dihapus karena sudah ada tiket yang terjual!');
        }
        
        // Delete all tickets first
        Tiket::where('jadwal_id', $jadwal->id)->delete();
        
        // Then delete the schedule
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal penerbangan berhasil dihapus!');
    }
} 