<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Tiket;
use App\Models\JadwalPenerbangan;
use App\Models\Maskapai;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the main reports dashboard
     */
    public function index()
    {
        // Get count of transactions by status
        $transactionsByStatus = Transaksi::select('status_bayar', DB::raw('count(*) as count'))
            ->groupBy('status_bayar')
            ->pluck('count', 'status_bayar')
            ->toArray();
        
        // Total transactions
        $totalTransactions = Transaksi::count();
        
        // Total revenue from completed transactions
        $totalRevenue = Transaksi::whereIn('status_bayar', ['approved', 'dibayar'])
            ->whereNotNull('total_price')
            ->sum('total_price');
            
        // If no transactions with total_price, use the old method
        if ($totalRevenue == 0) {
            $totalRevenue = Transaksi::whereIn('status_bayar', ['approved', 'dibayar'])
                ->join('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
                ->join('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
                ->sum(DB::raw('jadwal_penerbangans.harga_tiket * COALESCE(transaksis.quantity, 1)'));
        }
            
        // Total users
        $totalUsers = User::count();
        
        // Pending transactions
        $pendingTransactions = Transaksi::where('status_bayar', 'pending')->count();
        
        // Recent transactions
        $recentTransactions = Transaksi::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Monthly transactions for the current year
        $monthlyTransactions = Transaksi::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        // Ensure all months are represented
        $formattedMonthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedMonthlyData[$i] = $monthlyTransactions[$i] ?? 0;
        }
        
        // Count users by role
        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
        
        // Top airlines by transaction count
        $topMaskapai = Maskapai::select(
                'maskapais.id',
                'maskapais.nama_maskapai as nama_maskapai',
                DB::raw('COUNT(transaksis.id) as transaction_count')
            )
            ->join('jadwal_penerbangans', 'maskapais.id', '=', 'jadwal_penerbangans.maskapai_id')
            ->join('tikets', 'jadwal_penerbangans.id', '=', 'tikets.jadwal_id')
            ->join('transaksis', 'tikets.id', '=', 'transaksis.tiket_id')
            ->groupBy('maskapais.id', 'maskapais.nama_maskapai')
            ->orderByDesc('transaction_count')
            ->limit(5)
            ->get();
        
        return view('admin.reports', compact(
            'transactionsByStatus', 
            'totalTransactions', 
            'totalRevenue', 
            'totalUsers', 
            'pendingTransactions', 
            'recentTransactions', 
            'formattedMonthlyData',
            'topMaskapai',
            'usersByRole'
        ));
    }

    /**
     * Display sales report
     */
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $status = $request->input('status');
        
        // Convert to Carbon instances for easier manipulation
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Base query with joins to get ticket price
        $query = Transaksi::with('user', 'tiket.jadwal')
            ->join('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
            ->join('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
            ->select(
                'transaksis.*', 
                'jadwal_penerbangans.harga_tiket',
                DB::raw('COALESCE(transaksis.quantity, 1) as jumlah_tiket'),
                DB::raw('COALESCE(transaksis.total_price, jadwal_penerbangans.harga_tiket * COALESCE(transaksis.quantity, 1)) as total_harga')
            )
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon]);
            
        // Filter by status if provided
        if ($status) {
            $query->where('transaksis.status_bayar', $status);
        }
        
        // Get transaction data
        $transactions = $query->latest('transaksis.created_at')->paginate(15);
        
        // Calculate summary metrics
        $totalSales = $query->count();
        $totalRevenue = $query->sum(DB::raw('COALESCE(transaksis.total_price, jadwal_penerbangans.harga_tiket * COALESCE(transaksis.quantity, 1))'));
        $averageTicketPrice = $totalSales > 0 ? $totalRevenue / array_sum($transactions->pluck('jumlah_tiket')->toArray()) : 0;
        
        // Calculate conversion rate (completed transactions / total)
        $completedTransactions = Transaksi::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->whereIn('status_bayar', ['approved', 'dibayar'])
            ->count();
        $conversionRate = $totalSales > 0 ? ($completedTransactions / $totalSales) * 100 : 0;
        
        // Get sales by date
        $salesByDate = DB::table('transaksis')
            ->join('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
            ->join('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon])
            ->selectRaw('
                DATE(transaksis.created_at) as date, 
                COUNT(*) as count, 
                SUM(COALESCE(transaksis.total_price, jadwal_penerbangans.harga_tiket * COALESCE(transaksis.quantity, 1))) as revenue
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck(null, 'date')
            ->map(function ($item) {
                return [
                    'count' => $item->count,
                    'revenue' => $item->revenue
                ];
            })
            ->toArray();
        
        // Get sales by status
        $salesByStatus = Transaksi::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->selectRaw('status_bayar, COUNT(*) as count')
            ->groupBy('status_bayar')
            ->pluck('count', 'status_bayar')
            ->toArray();
        
        return view('admin.reports.sales', compact(
            'transactions',
            'totalSales',
            'totalRevenue',
            'averageTicketPrice',
            'conversionRate',
            'salesByDate',
            'salesByStatus',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Export sales data to CSV
     */
    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $status = $request->input('status');
        
        // Convert to Carbon instances
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Base query
        $query = Transaksi::with(['user', 'tiket.jadwal'])
            ->join('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
            ->join('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
            ->select('transaksis.*', 'jadwal_penerbangans.harga_tiket')
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon]);
            
        // Filter by status if provided
        if ($status) {
            $query->where('status_bayar', $status);
        }
        
        // Get all transactions for export
        $transactions = $query->latest()->get();
        
        // Generate CSV filename
        $filename = 'sales_report_' . $startDate . '_to_' . $endDate . '.csv';
        
        // Set headers for CSV download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        // Create callback for streaming CSV data
        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 'Pengguna', 'Email', 'Jumlah Tiket', 'Total Harga', 
                'Status Pembayaran', 'Tanggal Transaksi'
            ]);
            
            // Add transaction data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->user->name,
                    $transaction->user->email,
                    1, // Each record represents one ticket
                    $transaction->harga_tiket,
                    $transaction->status_bayar,
                    $transaction->created_at->format('d/m/Y H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Display airline report
     */
    public function airlines(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        
        // Convert to Carbon instances
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Get airline statistics
        $airlines = Maskapai::select(
                'maskapais.id',
                'maskapais.nama_maskapai as name',
                DB::raw('COUNT(DISTINCT transaksis.id) as transaction_count'),
                DB::raw('SUM(jadwal_penerbangans.harga_tiket) as total_revenue'),
                DB::raw('COUNT(DISTINCT tikets.id) as ticket_count')
            )
            ->join('jadwal_penerbangans', 'maskapais.id', '=', 'jadwal_penerbangans.maskapai_id')
            ->join('tikets', 'jadwal_penerbangans.id', '=', 'tikets.jadwal_id')
            ->join('transaksis', 'tikets.id', '=', 'transaksis.tiket_id')
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon])
            ->groupBy('maskapais.id', 'maskapais.nama_maskapai')
            ->orderByDesc('transaction_count')
            ->paginate(10);
            
        // Get total metrics for percentages
        $totalTransactions = Transaksi::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])->count();
        $totalRevenue = Transaksi::join('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
            ->join('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon])
            ->sum('jadwal_penerbangans.harga_tiket');
        
        return view('admin.reports.airlines', compact(
            'airlines',
            'totalTransactions',
            'totalRevenue',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Display user report
     */
    public function users(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        
        // Convert to Carbon instances
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();
        
        // Get top users by transaction count and amount
        $users = User::select(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at as registered_at',
                DB::raw('COUNT(transaksis.id) as transaction_count'),
                DB::raw('SUM(jadwal_penerbangans.harga_tiket) as total_spent'),
                DB::raw('MAX(transaksis.created_at) as last_transaction_date')
            )
            ->leftJoin('transaksis', 'users.id', '=', 'transaksis.user_id')
            ->leftJoin('tikets', 'transaksis.tiket_id', '=', 'tikets.id')
            ->leftJoin('jadwal_penerbangans', 'tikets.jadwal_id', '=', 'jadwal_penerbangans.id')
            ->where('users.role', '!=', 'admin')
            ->whereBetween('transaksis.created_at', [$startDateCarbon, $endDateCarbon])
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->orderByDesc('total_spent')
            ->paginate(15);
            
        // User registration stats by month
        $userRegistrations = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        return view('admin.reports.users', compact(
            'users',
            'userRegistrations',
            'startDate',
            'endDate'
        ));
    }
} 