<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\JadwalPenerbangan;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $jadwal_id = $request->get('jadwal');
        
        $query = Tiket::with(['jadwal.maskapai', 'jadwal.kotaAsal', 'jadwal.kotaTujuan']);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($jadwal_id) {
            $query->where('jadwal_id', $jadwal_id);
        }
        
        $tikets = $query->paginate(15);
        $jadwalPenerbangans = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        
        return view('admin.tiket.index', compact('tikets', 'jadwalPenerbangans', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tiket $tiket)
    {
        $tiket->load(['jadwal.maskapai', 'jadwal.kotaAsal', 'jadwal.kotaTujuan', 'transaksi']);
        return view('admin.tiket.show', compact('tiket'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jadwalPenerbangans = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        return view('admin.tiket.create', compact('jadwalPenerbangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_penerbangans,id',
            'nomor_tiket' => 'required|string|max:50|unique:tikets',
            'nomor_kursi' => 'required|string|max:10',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,dipesan,terjual',
            'keterangan' => 'nullable|string',
        ]);
        
        $tiket = Tiket::create($request->all());
        
        return redirect()->route('admin.tiket.index')
                         ->with('success', 'Tiket berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tiket $tiket)
    {
        $jadwalPenerbangans = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        $tiket->load(['jadwal.maskapai', 'jadwal.kotaAsal', 'jadwal.kotaTujuan']);
        return view('admin.tiket.edit', compact('tiket', 'jadwalPenerbangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tiket $tiket)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_penerbangans,id',
            'nomor_tiket' => 'required|string|max:50|unique:tikets,nomor_tiket,'.$tiket->id,
            'nomor_kursi' => 'required|string|max:10',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,dipesan,terjual',
            'keterangan' => 'nullable|string',
        ]);
        
        $oldStatus = $tiket->status;
        $newStatus = $request->status;
        
        $tiket->update($request->all());
        
        // Update jadwal penerbangan's sisa_kursi if status changed
        if ($oldStatus != $newStatus) {
            $jadwal = JadwalPenerbangan::find($tiket->jadwal_id);
            
            if ($oldStatus == 'tersedia' && ($newStatus == 'dipesan' || $newStatus == 'terjual')) {
                // Decrease available seats
                $jadwal->sisa_kursi = max(0, $jadwal->sisa_kursi - 1);
            } elseif (($oldStatus == 'dipesan' || $oldStatus == 'terjual') && $newStatus == 'tersedia') {
                // Increase available seats
                $jadwal->sisa_kursi = min($jadwal->kapasitas_kursi, $jadwal->sisa_kursi + 1);
            }
            
            $jadwal->save();
        }

        return redirect()->route('admin.tiket.index')
                         ->with('success', 'Tiket berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiket $tiket)
    {
        $tiket->delete();
        
        return redirect()->route('admin.tiket.index')
                         ->with('success', 'Tiket berhasil dihapus!');
    }
} 