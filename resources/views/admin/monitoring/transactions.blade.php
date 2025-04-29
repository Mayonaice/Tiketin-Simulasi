@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Monitoring Transaksi</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <!-- All Transactions -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gray-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Semua Transaksi
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ array_sum($countByStatus ?? []) }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Payment -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Menunggu Pembayaran
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $countByStatus['pending'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Dibayar
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $countByStatus['dibayar'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Selesai
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $countByStatus['selesai'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow-lg rounded-lg p-4">
        <form action="{{ route('admin.transactions') }}" method="GET">
            <div class="flex items-center space-x-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Filter Status</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Semua</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="dibayar" {{ $status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions List -->
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Transaksi</h3>
            
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaction->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $transaction->tiket->jadwal->maskapai->nama_maskapai }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaction->tiket->jadwal->kotaAsal->nama_kota }} ke {{ $transaction->tiket->jadwal->kotaTujuan->nama_kota }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ date('d M Y H:i', strtotime($transaction->created_at)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->status_bayar == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($transaction->status_bayar == 'dibayar')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Dibayar
                                        </span>
                                    @elseif($transaction->status_bayar == 'selesai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @elseif($transaction->status_bayar == 'dibatalkan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 