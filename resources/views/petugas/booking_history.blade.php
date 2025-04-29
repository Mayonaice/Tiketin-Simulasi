@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Pemesanan</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Riwayat Pemesanan</span>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Filter Riwayat</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('petugas.history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date', date('Y-m-d', strtotime('-30 days'))) }}" 
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
                        Filter Riwayat
                    </button>
                </div>
            </form>
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
                    <span class="block text-2xl font-bold text-gray-800">{{ array_sum($countByStatus) }}</span>
                    <span class="text-gray-500 text-sm">Total Transaksi</span>
                </div>
            </div>
        </div>
        
        <!-- Approved Transactions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 py-3 px-4">
                <h3 class="text-white font-medium">Transaksi Approved</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ $countByStatus['approved'] ?? 0 }}</span>
                    <span class="text-gray-500 text-sm">Transaksi Approved</span>
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
                    <span class="block text-2xl font-bold text-gray-800">{{ $countByStatus['pending'] ?? 0 }}</span>
                    <span class="text-gray-500 text-sm">Menunggu Pembayaran</span>
                </div>
            </div>
        </div>
        
        <!-- Paid Transactions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 py-3 px-4">
                <h3 class="text-white font-medium">Transaksi Dibayar</h3>
            </div>
            <div class="p-4 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-gray-800">{{ $countByStatus['dibayar'] ?? 0 }}</span>
                    <span class="text-gray-500 text-sm">Dibayar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white">Daftar Riwayat Pemesanan</h2>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">ID</th>
                        <th class="py-3 px-6 text-left font-semibold">Pengguna</th>
                        <th class="py-3 px-6 text-left font-semibold">Tiket</th>
                        <th class="py-3 px-6 text-left font-semibold">Rute</th>
                        <th class="py-3 px-6 text-left font-semibold">Jumlah</th>
                        <th class="py-3 px-6 text-left font-semibold">Total</th>
                        <th class="py-3 px-6 text-left font-semibold">Status</th>
                        <th class="py-3 px-6 text-left font-semibold">Tanggal</th>
                        <th class="py-3 px-6 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-blue-50">
                        <td class="py-4 px-6">{{ $transaction->id }}</td>
                        <td class="py-4 px-6">{{ $transaction->user->name }}</td>
                        <td class="py-4 px-6">{{ $transaction->tiket->kode_tiket }}</td>
                        <td class="py-4 px-6">
                            {{ $transaction->tiket->jadwal->kotaAsal->nama_kota }} → 
                            {{ $transaction->tiket->jadwal->kotaTujuan->nama_kota }}
                        </td>
                        <td class="py-4 px-6">{{ $transaction->quantity ?? 1 }} tiket</td>
                        <td class="py-4 px-6">Rp {{ number_format($transaction->total_price ?? ($transaction->tiket->jadwal->harga_tiket * ($transaction->quantity ?? 1)), 0, ',', '.') }}</td>
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
                        <td class="py-4 px-6">
                            <a href="{{ route('petugas.history.show', $transaction->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                                <svg class="inline-block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-5 px-6 text-center">Tidak ada data transaksi untuk periode ini</td>
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
@endsection 