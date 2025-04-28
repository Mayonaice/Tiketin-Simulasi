@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Laporan dan Statistik</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Laporan</span>
    </div>

    <!-- Report Navigation -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Jenis Laporan</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.reports.sales') }}" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex items-center hover:bg-blue-50 transition-colors">
                    <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Laporan Penjualan</h3>
                        <p class="text-gray-600 text-sm">Detail penjualan tiket berdasarkan periode</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.reports.airlines') }}" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex items-center hover:bg-blue-50 transition-colors">
                    <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Laporan Maskapai</h3>
                        <p class="text-gray-600 text-sm">Performa penjualan tiket per maskapai</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.reports.users') }}" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex items-center hover:bg-blue-50 transition-colors">
                    <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Laporan Pengguna</h3>
                        <p class="text-gray-600 text-sm">Statistik pengguna dan aktivitas</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Transactions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Transaksi</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ number_format($totalTransactions) }}</span>
                    <span class="text-gray-500 text-sm">Total Transaksi</span>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Pendapatan</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    <span class="text-gray-500 text-sm">Total Pendapatan</span>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Pengguna</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ array_sum($usersByRole) }}</span>
                    <span class="text-gray-500 text-sm">Total Pengguna</span>
                </div>
            </div>
        </div>
        
        <!-- Pending Transactions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 py-3 px-4">
                <h3 class="text-white font-medium">Transaksi Pending</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-amber-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ $transactionsByStatus['pending'] ?? 0 }}</span>
                    <span class="text-gray-500 text-sm">Menunggu Pembayaran</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions & Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                <h2 class="text-xl font-bold text-white">Transaksi Terbaru</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left font-semibold">ID</th>
                                <th class="py-3 px-6 text-left font-semibold">Pengguna</th>
                                <th class="py-3 px-6 text-left font-semibold">Status</th>
                                <th class="py-3 px-6 text-left font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($recentTransactions as $transaction)
                            <tr class="border-b border-gray-200 hover:bg-blue-50">
                                <td class="py-4 px-6">{{ $transaction->id }}</td>
                                <td class="py-4 px-6">{{ $transaction->user->name }}</td>
                                <td class="py-4 px-6">
                                    @if ($transaction->status_bayar == 'approved')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        Approved
                                    </span>
                                    @elseif ($transaction->status_bayar == 'dibayar')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        Dibayar
                                    </span>
                                    @elseif ($transaction->status_bayar == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                        Pending
                                    </span>
                                    @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                        Rejected
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">{{ $transaction->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td colspan="4" class="py-5 px-6 text-center">Tidak ada transaksi terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Monthly Transactions Chart -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                <h2 class="text-xl font-bold text-white">Transaksi Bulanan ({{ date('Y') }})</h2>
            </div>
            <div class="p-6">
                <canvas id="monthlyTransactionsChart" height="280"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Airline Stats -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Top Maskapai</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($topMaskapai as $maskapai)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-gray-800">{{ $maskapai->nama_maskapai }}</h3>
                        <span class="text-sm bg-blue-100 text-blue-800 rounded-full px-2 py-1">{{ $maskapai->transaction_count }} tiket</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(100, ($maskapai->transaction_count / max(1, $topMaskapai->max('transaction_count'))) * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthsData = @json($formattedMonthlyData);
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        const data = Object.keys(monthsData).map(month => monthsData[month]);
        
        const ctx = document.getElementById('monthlyTransactionsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 