<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Tiket;
use Carbon\Carbon;

class BookingHistoryController extends Controller
{
    /**
     * Display booking history for admin
     */
    public function adminIndex(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $status = $request->input('status');
        
        // Convert to Carbon instances
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Base query with joins
        $query = Transaksi::with(['user', 'tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])
            ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
            
        // Filter by status if provided
        if ($status) {
            $query->where('status_bayar', $status);
        }
        
        // Get transactions
        $transactions = $query->latest()->paginate(15);
        
        // Get count by status
        $countByStatus = Transaksi::selectRaw('status_bayar, COUNT(*) as count')
            ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->groupBy('status_bayar')
            ->pluck('count', 'status_bayar')
            ->toArray();
            
        return view('admin.booking_history', compact(
            'transactions',
            'countByStatus',
            'startDate',
            'endDate',
            'status'
        ));
    }
    
    /**
     * Display booking history for petugas
     */
    public function petugasIndex(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $status = $request->input('status');
        
        // Convert to Carbon instances
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Base query with joins
        $query = Transaksi::with(['user', 'tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])
            ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
            
        // Filter by status if provided
        if ($status) {
            $query->where('status_bayar', $status);
        }
        
        // Get transactions
        $transactions = $query->latest()->paginate(15);
        
        // Get count by status
        $countByStatus = Transaksi::selectRaw('status_bayar, COUNT(*) as count')
            ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->groupBy('status_bayar')
            ->pluck('count', 'status_bayar')
            ->toArray();
            
        return view('petugas.booking_history', compact(
            'transactions',
            'countByStatus',
            'startDate',
            'endDate',
            'status'
        ));
    }
    
    /**
     * Display detail of booking for admin
     */
    public function adminShow($id)
    {
        $transaksi = Transaksi::with(['user', 'tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])
            ->findOrFail($id);
            
        return view('admin.booking_detail', compact('transaksi'));
    }
    
    /**
     * Display detail of booking for petugas
     */
    public function petugasShow($id)
    {
        $transaksi = Transaksi::with(['user', 'tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])
            ->findOrFail($id);
            
        return view('petugas.booking_detail', compact('transaksi'));
    }
} 