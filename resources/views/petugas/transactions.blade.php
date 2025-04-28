@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex items-center">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="text-xl font-bold text-white">Manajemen Transaksi</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Daftar Transaksi</h3>
                <p class="text-gray-600 mb-4">
                    Halaman ini menampilkan semua transaksi pembelian tiket di sistem. Gunakan filter untuk melihat transaksi berdasarkan status pembayaran.
                </p>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm leading-5 text-blue-700">
                                Sebagai petugas, Anda dapat melihat dan memantau transaksi pembelian tiket.
                                Gunakan filter status untuk melihat transaksi berdasarkan status pembayarannya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h4 class="text-md font-medium text-gray-700">Filter Status Pembayaran</h4>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('petugas.transactions') }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                            Semua
                        </a>
                        <a href="{{ route('petugas.transactions', ['status' => 'pending']) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150">
                            Pending
                        </a>
                        <a href="{{ route('petugas.transactions', ['status' => 'dibayar']) }}" class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:shadow-outline-blue transition ease-in-out duration-150">
                            Dibayar
                        </a>
                        <a href="{{ route('petugas.transactions', ['status' => 'approved']) }}" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150">
                            Approved
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left font-semibold">ID</th>
                            <th class="py-3 px-6 text-left font-semibold">Pengguna</th>
                            <th class="py-3 px-6 text-left font-semibold">Kode Tiket</th>
                            <th class="py-3 px-6 text-left font-semibold">Status</th>
                            <th class="py-3 px-6 text-left font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse ($transactions ?? [] as $transaction)
                        <tr class="border-b border-gray-200 hover:bg-blue-50">
                            <td class="py-4 px-6">#{{ $transaction->id }}</td>
                            <td class="py-4 px-6">{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $transaction->tiket->kode_tiket ?? 'N/A' }}</td>
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
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <td colspan="5" class="py-5 px-6 text-center">Tidak ada data transaksi yang tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            @if(isset($transactions) && $transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 