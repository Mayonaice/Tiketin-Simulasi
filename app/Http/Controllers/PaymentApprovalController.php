<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Tiket;
use App\Models\JadwalPenerbangan;

class PaymentApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'tiket.jadwal.maskapai'])->where('status_bayar', 'dibayar')->get();
        return view('admin.payment_approvals', compact('transaksis'));
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
        $transaksi = Transaksi::with(['user', 'tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])->findOrFail($id);
        return view('admin.payment_show', compact('transaksi'));
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

    /**
     * Approve a payment.
     */
    public function approve($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $tiket = Tiket::findOrFail($transaksi->tiket_id);
        
        // Update transaksi status
        $transaksi->update(['status_bayar' => 'approved']);
        
        // Update status for multiple tickets if quantity > 1
        $jadwal = JadwalPenerbangan::findOrFail($tiket->jadwal_id);
        $quantity = $transaksi->quantity ?? 1;
        
        // Find all tickets with the same jadwal_id and status 'dipesan' (limit to quantity)
        $tikets = Tiket::where('jadwal_id', $tiket->jadwal_id)
                      ->where('status', 'dipesan')
                      ->take($quantity)
                      ->get();
                      
        foreach ($tikets as $t) {
            $t->update(['status' => 'terjual']);
        }
        
        // Update sisa kursi setelah pembayaran disetujui
        $jadwal->decrement('sisa_kursi', $quantity);
        
        return redirect()->route('payment.approvals')->with('success', 'Pembayaran berhasil diapprove!');
    }

    /**
     * Reject a payment.
     */
    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $tiket = Tiket::findOrFail($transaksi->tiket_id);
        $jadwal = JadwalPenerbangan::findOrFail($tiket->jadwal_id);
        
        // Get quantity
        $quantity = $transaksi->quantity ?? 1;
        
        // Update transaksi status
        $transaksi->update(['status_bayar' => 'pending']);
        
        // Find tickets with jadwal_id and 'dipesan' status
        $tikets = Tiket::where('jadwal_id', $tiket->jadwal_id)
                      ->where('status', 'dipesan')
                      ->take($quantity)
                      ->get();
        
        // Return tickets to 'tersedia' status
        foreach ($tikets as $t) {
            $t->update(['status' => 'tersedia']);
        }
        
        return redirect()->route('payment.approvals')->with('success', 'Pembayaran ditolak dan dikembalikan ke status menunggu pembayaran!');
    }
}
