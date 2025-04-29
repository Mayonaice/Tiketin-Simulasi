<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Transaksi;
use App\Models\JadwalPenerbangan;
use App\Models\Maskapai;

class MonitoringController extends Controller
{
    /**
     * Display ticket monitoring dashboard for admin
     */
    public function tickets(Request $request)
    {
        $jadwal_id = $request->get('jadwal_id');
        $maskapai_id = $request->get('maskapai_id');
        $status = $request->get('status');
        
        // Base query for tickets with eager loading
        $query = Tiket::with(['jadwal.maskapai', 'jadwal.kotaAsal', 'jadwal.kotaTujuan']);
        
        // Apply jadwal filter if provided
        if ($jadwal_id) {
            $query->where('jadwal_id', $jadwal_id);
        }
        
        // Apply maskapai filter if provided
        if ($maskapai_id) {
            $query->whereHas('jadwal', function($q) use ($maskapai_id) {
                $q->where('maskapai_id', $maskapai_id);
            });
        }
        
        // Apply status filter if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        // Count tickets by status (based on current filters)
        $ticketStats = [
            'tersedia' => (clone $query)->where('status', 'tersedia')->count(),
            'dipesan' => (clone $query)->where('status', 'dipesan')->count(),
            'terjual' => (clone $query)->where('status', 'terjual')->count()
        ];
        
        // Get tickets with pagination
        $tickets = $query->latest()->paginate(10);
        
        // Maintain filter parameters in pagination links
        if ($jadwal_id || $maskapai_id || $status) {
            $tickets->appends(compact('jadwal_id', 'maskapai_id', 'status'));
        }
        
        // Get list of jadwal penerbangans and maskapais for filters
        $jadwals = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->get();
        $maskapais = Maskapai::all();
        
        return view('admin.monitoring.tickets', compact(
            'ticketStats', 
            'tickets', 
            'jadwals', 
            'maskapais', 
            'jadwal_id', 
            'maskapai_id', 
            'status'
        ));
    }
    
    /**
     * Display transaction monitoring dashboard for admin
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
        
        // Count by status
        $countByStatus = Transaksi::selectRaw('status_bayar, COUNT(*) as count')
            ->groupBy('status_bayar')
            ->pluck('count', 'status_bayar')
            ->toArray();
        
        return view('admin.monitoring.transactions', compact('transactions', 'status', 'countByStatus'));
    }
} 