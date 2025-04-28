<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Transaksi;
use App\Models\JadwalPenerbangan;

class PetugasController extends Controller
{
    /**
     * Display ticket monitoring dashboard for petugas
     */
    public function tickets()
    {
        // Count tickets by status
        $ticketStats = [
            'tersedia' => Tiket::where('status', 'tersedia')->count(),
            'dipesan' => Tiket::where('status', 'dipesan')->count(),
            'terjual' => Tiket::where('status', 'terjual')->count()
        ];
        
        return view('petugas.tickets', compact('ticketStats'));
    }
    
    /**
     * Display transaction monitoring dashboard for petugas
     */
    public function transactions(Request $request)
    {
        $status = $request->get('status');
        
        // Base query for transactions with eager loading
        $query = Transaksi::with(['user', 'tiket.jadwal.maskapai'])
            ->orderBy('created_at', 'desc');
        
        // Apply status filter if provided
        if ($status) {
            $query->where('status_bayar', $status);
        }
        
        // Get transactions
        $transactions = $query->paginate(10);
        
        // Maintain status parameter in pagination links
        if ($status) {
            $transactions->appends(['status' => $status]);
        }
        
        return view('petugas.transactions', compact('transactions', 'status'));
    }
} 