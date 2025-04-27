@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Pembayaran</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('payment.approvals') }}" class="hover:text-blue-600">Pembayaran</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Detail Pembayaran #{{ $transaksi->id }}</span>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="h-6 w-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="h-6 w-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Detail Transaksi -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover w-full md:w-2/3">
            <div class="bg-blue-500 text-white px-6 py-4 flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="font-semibold">Informasi Transaksi</span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Transaksi</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Transaksi:</span>
                                <span class="font-medium">{{ $transaksi->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Pembayaran:</span>
                                <span class="font-medium text-blue-600">
                                    @if(isset($transaksi->total_bayar))
                                        Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket ?? 0, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pembayaran:</span>
                                <span class="font-medium">
                                    @if($transaksi->tanggal_bayar)
                                        {{ $transaksi->tanggal_bayar->format('d M Y H:i') }}
                                    @else
                                        {{ $transaksi->updated_at->format('d M Y H:i') }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Pembayaran:</span>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $transaksi->status_bayar }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Rekening:</span>
                                <span class="font-medium">{{ $transaksi->nomor_rekening ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Pengirim:</span>
                                <span class="font-medium">{{ $transaksi->nama_rekening ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Penumpang</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">{{ $transaksi->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $transaksi->user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Telepon:</span>
                                <span class="font-medium">{{ $transaksi->user->phone ?? '-' }}</span>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-4">Data Tiket</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kode Tiket:</span>
                                <span class="font-medium">{{ $transaksi->tiket->kode_tiket }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Maskapai:</span>
                                <span class="font-medium">{{ $transaksi->tiket->jadwal->maskapai->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Asal:</span>
                                <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaAsal->nama_kota ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tujuan:</span>
                                <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Berangkat:</span>
                                <span class="font-medium">
                                    @php
                                        try {
                                            if (is_string($transaksi->tiket->jadwal->tanggal_berangkat)) {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat . ' ' . ($transaksi->tiket->jadwal->jam_berangkat ?? '');
                                            } else {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat->format('d M Y H:i');
                                            }
                                        } catch (\Exception $e) {
                                            echo $transaksi->tiket->jadwal->tanggal_berangkat . ' ' . ($transaksi->tiket->jadwal->jam_berangkat ?? '');
                                        }
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bukti Pembayaran -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover w-full md:w-1/3">
            <div class="bg-blue-500 text-white px-6 py-4 flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-semibold">Bukti Pembayaran</span>
            </div>
            <div class="p-6">
                @if($transaksi->bukti_bayar)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-full h-auto rounded-lg shadow">
                </div>
                <div class="text-center">
                    <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Bukti
                    </a>
                </div>
                @else
                <div class="p-8 text-center">
                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500">Bukti pembayaran belum diunggah.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($transaksi->status_bayar == 'dibayar')
    <div class="mt-6 flex justify-center space-x-4">
        <form action="{{ route('payment.approve', $transaksi->id) }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Setujui Pembayaran
            </button>
        </form>
        <form action="{{ route('payment.reject', $transaksi->id) }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Tolak Pembayaran
            </button>
        </form>
    </div>
    @endif
</div>
@endsection 