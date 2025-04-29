@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Detail Tiket
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <a href="{{ route('admin.tiket.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Tiket</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail tiket dan informasi terkait.</p>
        </div>
        
        <!-- Ticket Information -->
        <div class="border-b border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kode Tiket</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tiket->nomor_tiket ?? 'TIK'.str_pad($tiket->id, 5, '0', STR_PAD_LEFT) }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        @if($tiket->status == 'tersedia')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Tersedia
                            </span>
                        @elseif($tiket->status == 'dipesan')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Dipesan
                            </span>
                        @elseif($tiket->status == 'terjual')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Terjual
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Harga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($tiket->harga ?? $tiket->jadwal->harga_tiket ?? 0, 0, ',', '.') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tiket->keterangan ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Flight Information -->
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Penerbangan</h3>
        </div>
        <div class="border-b border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Maskapai</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                @php 
                                    $logoPath = $tiket->jadwal->maskapai->logo_path;
                                    $defaultLogoPath = 'images/default-airline.png';
                                @endphp
                                <img class="h-10 w-10 rounded-full object-contain" 
                                    src="{{ $logoPath ? asset('storage/' . $logoPath) : asset($defaultLogoPath) }}" 
                                    alt="{{ $tiket->jadwal->maskapai->nama_maskapai }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $tiket->jadwal->maskapai->nama_maskapai }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $tiket->jadwal->maskapai->kode_maskapai }}
                                </div>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Rute</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 relative flex items-center justify-center">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $tiket->jadwal->kotaAsal->nama_kota }}</p>
                                    <p class="text-xs text-gray-500">Bandara ({{ $tiket->jadwal->kotaAsal->kode_bandara }})</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 relative flex items-center justify-center">
                                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $tiket->jadwal->kotaTujuan->nama_kota }}</p>
                                    <p class="text-xs text-gray-500">Bandara ({{ $tiket->jadwal->kotaTujuan->kode_bandara }})</p>
                                </div>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex flex-col space-y-1">
                            <p>{{ date('d F Y', strtotime($tiket->jadwal->tanggal_berangkat)) }}</p>
                            <p>
                                <span class="font-medium">Berangkat:</span> {{ date('H:i', strtotime($tiket->jadwal->jam_berangkat)) }} WIB
                            </p>
                            <p>
                                <span class="font-medium">Tiba:</span> {{ date('H:i', strtotime($tiket->jadwal->jam_tiba)) }} WIB
                            </p>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Transaction Information (if exists) -->
        @if($tiket->transaksi)
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Transaksi</h3>
        </div>
        <div>
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kode Transaksi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tiket->transaksi->kode_transaksi }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Transaksi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('d F Y H:i', strtotime($tiket->transaksi->created_at)) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        @if($tiket->transaksi->status_pembayaran == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Pembayaran
                            </span>
                        @elseif($tiket->transaksi->status_pembayaran == 'paid')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Lunas
                            </span>
                        @elseif($tiket->transaksi->status_pembayaran == 'failed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Gagal
                        </span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($tiket->transaksi->total, 0, ',', '.') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Penumpang</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tiket->transaksi->nama_penumpang }}</dd>
                </div>
            </dl>
        </div>
        @endif
    </div>
</div>
@endsection 