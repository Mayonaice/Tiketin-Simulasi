@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Laporan Pengguna</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('admin.reports') }}" class="hover:text-blue-600">Laporan</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Laporan Pengguna</span>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Filter Laporan</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.reports.users') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

    <!-- User Registration Chart -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Registrasi Pengguna per Bulan</h2>
        </div>
        <div class="p-6">
            <canvas id="userRegistrationChart" height="300"></canvas>
        </div>
    </div>

    <!-- Users Report Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Data Pengguna</h2>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">ID</th>
                        <th class="py-3 px-6 text-left font-semibold">Nama</th>
                        <th class="py-3 px-6 text-left font-semibold">Email</th>
                        <th class="py-3 px-6 text-left font-semibold">Terdaftar Pada</th>
                        <th class="py-3 px-6 text-left font-semibold">Transaksi</th>
                        <th class="py-3 px-6 text-left font-semibold">Total Pengeluaran</th>
                        <th class="py-3 px-6 text-left font-semibold">Terakhir Transaksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
                    @forelse ($users as $user)
                    <tr class="hover:bg-blue-50">
                        <td class="py-4 px-6">#{{ $user->id }}</td>
                        <td class="py-4 px-6 font-medium">{{ $user->name }}</td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">{{ $user->registered_at ? Carbon\Carbon::parse($user->registered_at)->format('d M Y') : '-' }}</td>
                        <td class="py-4 px-6">{{ $user->transaction_count ?? 0 }}</td>
                        <td class="py-4 px-6">
                            @if($user->total_spent)
                                Rp {{ number_format($user->total_spent, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </td>
                        <td class="py-4 px-6">{{ $user->last_transaction_date ? Carbon\Carbon::parse($user->last_transaction_date)->format('d M Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-5 px-6 text-center">Tidak ada data pengguna untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // User Registration Chart
        const registrationData = @json($userRegistrations);
        const months = Object.keys(registrationData).map(month => {
            const [year, monthNum] = month.split('-');
            const date = new Date(year, monthNum - 1, 1);
            return date.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
        });
        
        const registrationCounts = Object.values(registrationData);
        
        const ctx = document.getElementById('userRegistrationChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Pendaftaran',
                    data: registrationCounts,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
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