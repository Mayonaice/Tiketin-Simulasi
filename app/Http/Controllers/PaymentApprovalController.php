<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Tiket;

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
        
        // Update status
        $transaksi->update(['status_bayar' => 'approved']);
        $tiket->update(['status' => 'terjual']);
        
        return redirect()->route('payment.approvals')->with('success', 'Pembayaran berhasil diapprove!');
    }

    /**
     * Reject a payment.
     */
    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $tiket = Tiket::findOrFail($transaksi->tiket_id);
        
        // Update status
        $transaksi->update(['status_bayar' => 'pending']);
        $tiket->update(['status' => 'dipesan']);
        
        return redirect()->route('payment.approvals')->with('success', 'Pembayaran ditolak dan dikembalikan ke status menunggu pembayaran!');
    }
}
