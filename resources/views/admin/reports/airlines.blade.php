@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Laporan Maskapai</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('admin.reports') }}" class="hover:text-blue-600">Laporan</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Laporan Maskapai</span>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Filter Laporan</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.reports.airlines') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors w-full">
                        Filter Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Airlines -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Maskapai</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ $airlines->count() }}</span>
                    <span class="text-gray-500 text-sm">Maskapai Aktif</span>
                </div>
            </div>
        </div>
        
        <!-- Total Tickets -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Tiket</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ number_format($totalTickets) }}</span>
                    <span class="text-gray-500 text-sm">Tiket Dipesan</span>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 py-3 px-4">
                <h3 class="text-white font-medium">Total Pendapatan</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    <span class="text-gray-500 text-sm">Pendapatan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Airlines Performance -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Kinerja Maskapai</h2>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">Maskapai</th>
                        <th class="py-3 px-6 text-left font-semibold">Jumlah Tiket</th>
                        <th class="py-3 px-6 text-left font-semibold">Persentase</th>
                        <th class="py-3 px-6 text-left font-semibold">Pendapatan (Rp)</th>
                        <th class="py-3 px-6 text-left font-semibold">Persentase</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
                    @forelse ($airlines as $airline)
                    <tr class="hover:bg-blue-50">
                        <td class="py-4 px-6 font-medium">{{ $airline->name }}</td>
                        <td class="py-4 px-6">{{ number_format($airline->ticket_count) }} tiket</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(100, ($airline->ticket_count / max(1, $totalTickets)) * 100) }}%"></div>
                                </div>
                                <span>{{ number_format(($airline->ticket_count / max(1, $totalTickets)) * 100, 1) }}%</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">Rp {{ number_format($airline->total_revenue, 0, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ min(100, ($airline->total_revenue / max(1, $totalRevenue)) * 100) }}%"></div>
                                </div>
                                <span>{{ number_format(($airline->total_revenue / max(1, $totalRevenue)) * 100, 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 px-6 text-center">Tidak ada data maskapai untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $airlines->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Airline Chart Comparison -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Perbandingan Maskapai</h2>
        </div>
        <div class="p-6">
            <canvas id="airlineComparisonChart" height="300"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Airline Comparison Chart
        const airlines = @json($airlines->pluck('name'));
        const ticketCounts = @json($airlines->pluck('ticket_count'));
        const revenues = @json($airlines->pluck('total_revenue'));
        
        const ctx = document.getElementById('airlineComparisonChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: airlines,
                datasets: [
                    {
                        label: 'Jumlah Tiket',
                        data: ticketCounts,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Pendapatan (dalam 10 ribu)',
                        data: revenues.map(value => value / 10000),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Jumlah Tiket'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Pendapatan (dalam 10 ribu Rupiah)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 