<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Tiket;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display list of payments waiting for approval
     *
     * @return \Illuminate\View\View
     */
    public function approvalList()
    {
        $transaksis = Transaksi::where('status_bayar', 'dibayar')
            ->with(['tiket', 'user', 'tiket.jadwal.maskapai'])
            ->latest()
            ->get();
            
        return view('admin.payment_approvals', compact('transaksis'));
    }
    
    /**
     * Show detail of a payment transaction
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['tiket', 'user', 'tiket.jadwal.maskapai'])
            ->findOrFail($id);
            
        return view('admin.payment_show', compact('transaksi'));
    }
    
    /**
     * Approve payment
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Jika sudah diapprove, tidak perlu proses lagi
        if ($transaksi->status_bayar == 'approved') {
            return redirect()->route('payment.approvals')
                ->with('success', 'Pembayaran sudah diapprove sebelumnya!');
        }
        
        // Jika belum dibayar, tidak bisa diapprove
        if ($transaksi->status_bayar != 'dibayar') {
            return redirect()->route('payment.approvals')
                ->with('error', 'Pembayaran belum dilakukan!');
        }
        
        // Update status transaksi
        $transaksi->status_bayar = 'approved';
        $transaksi->save();
        
        // Update status tiket
        $tiket = Tiket::find($transaksi->tiket_id);
        if ($tiket) {
            $tiket->status = 'terjual';
            $tiket->save();
        }
        
        return redirect()->route('payment.approvals')
            ->with('success', 'Pembayaran berhasil diapprove!');
    }
} 