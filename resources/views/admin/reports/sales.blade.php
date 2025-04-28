@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Laporan Penjualan</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('admin.reports') }}" class="hover:text-blue-600">Laporan</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Laporan Penjualan</span>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Filter Laporan</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Semua Status</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dibayar" {{ request('status') === 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors w-full">
                        Filter Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Sales -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Penjualan</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ number_format($totalSales) }}</span>
                    <span class="text-gray-500 text-sm">Transaksi</span>
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
                    <span class="text-gray-500 text-sm">Pendapatan</span>
                </div>
            </div>
        </div>
        
        <!-- Average Ticket Price -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 py-3 px-4">
                <h3 class="text-white font-medium">Rata-rata Harga Tiket</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">Rp {{ number_format($averageTicketPrice, 0, ',', '.') }}</span>
                    <span class="text-gray-500 text-sm">Rata-rata</span>
                </div>
            </div>
        </div>
        
        <!-- Conversion Rate -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 py-3 px-4">
                <h3 class="text-white font-medium">Tingkat Konversi</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-amber-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ number_format($conversionRate, 1) }}%</span>
                    <span class="text-gray-500 text-sm">Transaksi Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart & Status Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Sales by Date Chart -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden lg:col-span-2">
            <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                <h2 class="text-xl font-bold text-white">Penjualan per Tanggal</h2>
            </div>
            <div class="p-6">
                <canvas id="salesByDateChart" height="300"></canvas>
            </div>
        </div>
        
        <!-- Sales by Status -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                <h2 class="text-xl font-bold text-white">Status Pembayaran</h2>
            </div>
            <div class="p-6">
                <canvas id="salesByStatusChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">Daftar Transaksi</h2>
            <a href="{{ route('admin.reports.sales.export', request()->all()) }}" class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-md shadow-sm transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export CSV
            </a>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">ID</th>
                        <th class="py-3 px-6 text-left font-semibold">Pengguna</th>
                        <th class="py-3 px-6 text-left font-semibold">Jumlah Tiket</th>
                        <th class="py-3 px-6 text-left font-semibold">Total Harga</th>
                        <th class="py-3 px-6 text-left font-semibold">Status</th>
                        <th class="py-3 px-6 text-left font-semibold">Tanggal Pembelian</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-blue-50">
                        <td class="py-4 px-6">#{{ $transaction->id }}</td>
                        <td class="py-4 px-6">{{ $transaction->user->name }}</td>
                        <td class="py-4 px-6">{{ $transaction->jumlah_tiket }}</td>
                        <td class="py-4 px-6">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
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
                        <td class="py-4 px-6">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 px-6 text-center">Tidak ada data transaksi untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales by Date Chart
        const salesByDateData = @json($salesByDate);
        const ctx1 = document.getElementById('salesByDateChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: Object.keys(salesByDateData),
                datasets: [
                    {
                        label: 'Jumlah Transaksi',
                        data: Object.values(salesByDateData).map(day => day.count),
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.2,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Total Pendapatan (Rp)',
                        data: Object.values(salesByDateData).map(day => day.revenue),
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.0)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.2,
                        fill: false,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Total Pendapatan (Rp)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });

        // Sales by Status Chart
        const salesByStatusData = @json($salesByStatus);
        const ctx2 = document.getElementById('salesByStatusChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: Object.keys(salesByStatusData).map(status => {
                    const statusMap = {
                        'approved': 'Approved',
                        'dibayar': 'Dibayar',
                        'pending': 'Pending',
                        'rejected': 'Rejected'
                    };
                    return statusMap[status] || status;
                }),
                datasets: [{
                    data: Object.values(salesByStatusData),
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // green for approved
                        'rgba(59, 130, 246, 0.8)',  // blue for dibayar
                        'rgba(245, 158, 11, 0.8)',  // amber for pending
                        'rgba(239, 68, 68, 0.8)',   // red for rejected
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 