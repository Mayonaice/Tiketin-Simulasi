@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Pemesanan #{{ $transaksi->id }}</h1>
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('petugas.history') }}" class="hover:text-blue-600">Riwayat Pemesanan</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-blue-600">Detail Pemesanan #{{ $transaksi->id }}</span>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Transaction Details -->
        <div class="w-full md:w-2/3">
            <!-- Transaction Status Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                    <h2 class="text-xl font-bold text-white">Status Pemesanan</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="rounded-full p-3 mr-4
                            @if($transaksi->status_bayar == 'approved')
                                bg-green-100
                            @elseif($transaksi->status_bayar == 'dibayar')
                                bg-blue-100
                            @elseif($transaksi->status_bayar == 'pending')
                                bg-yellow-100
                            @else
                                bg-red-100
                            @endif
                        ">
                            <svg class="w-8 h-8
                                @if($transaksi->status_bayar == 'approved')
                                    text-green-500
                                @elseif($transaksi->status_bayar == 'dibayar')
                                    text-blue-500
                                @elseif($transaksi->status_bayar == 'pending')
                                    text-yellow-500
                                @else
                                    text-red-500
                                @endif
                            " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($transaksi->status_bayar == 'approved')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @elseif($transaksi->status_bayar == 'dibayar')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                @elseif($transaksi->status_bayar == 'pending')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                @endif
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Status Pembayaran:</h3>
                            <span class="text-xl
                                @if($transaksi->status_bayar == 'approved')
                                    text-green-600
                                @elseif($transaksi->status_bayar == 'dibayar')
                                    text-blue-600
                                @elseif($transaksi->status_bayar == 'pending')
                                    text-yellow-600
                                @else
                                    text-red-600
                                @endif
                            ">
                                @if($transaksi->status_bayar == 'approved')
                                    Approved
                                @elseif($transaksi->status_bayar == 'dibayar')
                                    Dibayar
                                @elseif($transaksi->status_bayar == 'pending')
                                    Pending
                                @else
                                    Rejected
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Kode Booking:</p>
                            <p class="font-semibold">{{ $transaksi->kode_booking }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal Pemesanan:</p>
                            <p class="font-semibold">{{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jumlah Tiket:</p>
                            <p class="font-semibold">{{ $transaksi->quantity ?? 1 }} tiket</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Pembayaran:</p>
                            <p class="font-semibold text-lg text-blue-600">
                                Rp {{ number_format($transaksi->total_price ?? ($transaksi->tiket->jadwal->harga_tiket * ($transaksi->quantity ?? 1)), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flight Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                    <h2 class="text-xl font-bold text-white">Detail Penerbangan</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4 flex justify-between">
                        <div>
                            <h3 class="text-xl font-bold">{{ $transaksi->tiket->jadwal->maskapai->nama_maskapai }}</h3>
                            <p class="text-gray-600">{{ $transaksi->tiket->kode_tiket }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                @if($transaksi->tiket->jadwal->status == 'scheduled')
                                    bg-blue-100 text-blue-800
                                @elseif($transaksi->tiket->jadwal->status == 'departed')
                                    bg-green-100 text-green-800
                                @elseif($transaksi->tiket->jadwal->status == 'arrived')
                                    bg-purple-100 text-purple-800
                                @elseif($transaksi->tiket->jadwal->status == 'cancelled')
                                    bg-red-100 text-red-800
                                @elseif($transaksi->tiket->jadwal->status == 'delayed')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($transaksi->tiket->jadwal->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center my-6">
                        <div class="text-center mr-8">
                            <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($transaksi->tiket->jadwal->waktu_berangkat)->format('H:i') }}</p>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($transaksi->tiket->jadwal->tanggal)->format('d M Y') }}</p>
                            <p class="font-medium">{{ $transaksi->tiket->jadwal->kotaAsal->nama_kota }}</p>
                            <p class="text-sm text-gray-600">{{ $transaksi->tiket->jadwal->kotaAsal->kode_kota }}</p>
                        </div>

                        <div class="flex-1 px-4">
                            <div class="relative">
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs text-gray-500">{{ $transaksi->tiket->jadwal->durasi_penerbangan }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                                    <div class="flex-1 h-0.5 mx-2 bg-gray-300 relative">
                                        <div class="absolute w-full flex justify-center -top-3">
                                            <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center ml-8">
                            <p class="text-3xl font-bold">{{ \Carbon\Carbon::parse($transaksi->tiket->jadwal->waktu_berangkat)->addMinutes(intval($transaksi->tiket->jadwal->durasi_penerbangan))->format('H:i') }}</p>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($transaksi->tiket->jadwal->tanggal)->format('d M Y') }}</p>
                            <p class="font-medium">{{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota }}</p>
                            <p class="text-sm text-gray-600">{{ $transaksi->tiket->jadwal->kotaTujuan->kode_kota }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                        <div>
                            <p class="text-gray-600">Kelas:</p>
                            <p class="font-semibold">{{ $transaksi->tiket->jadwal->kelas }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Harga per Tiket:</p>
                            <p class="font-semibold">Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Terminal:</p>
                            <p class="font-semibold">{{ $transaksi->tiket->jadwal->terminal ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full md:w-1/3">
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                    <h2 class="text-xl font-bold text-white">Data Pemesan</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="rounded-full bg-blue-100 p-3 mr-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">{{ $transaksi->user->name }}</h3>
                            <p class="text-gray-600">{{ $transaksi->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div>
                            <p class="text-gray-600">Nomor Telepon:</p>
                            <p class="font-semibold">{{ $transaksi->user->phone ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal Registrasi:</p>
                            <p class="font-semibold">{{ $transaksi->user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Alamat:</p>
                            <p class="font-semibold">{{ $transaksi->user->alamat ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            @if($transaksi->bukti_bayar)
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                    <h2 class="text-xl font-bold text-white">Bukti Pembayaran</h2>
                </div>
                <div class="p-6">
                    <img src="{{ asset('storage/'.$transaksi->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-full rounded-lg mb-3">
                    <p class="text-gray-600 text-sm">Bukti pembayaran diunggah pada {{ $transaksi->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
                    <h2 class="text-xl font-bold text-white">Tindakan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('petugas.history') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md text-center transition-colors">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 