@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 print:mx-0 print:px-0">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <h1 class="text-2xl font-bold text-gray-800">Cetak Tiket</h1>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Tiket
        </button>
    </div>
    
    <nav class="flex mb-5 print:hidden" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('user.history') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Riwayat Perjalanan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-gray-500 md:ml-2">Cetak Tiket</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Ticket Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden border-t-4 border-blue-600 mx-auto max-w-2xl">
        <div class="p-1 bg-gradient-to-r from-blue-700 to-blue-500">
            <div class="p-4 bg-white border-t border-l border-r border-gray-200 rounded-t-lg">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <div class="bg-blue-600 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Tiket Penerbangan</h2>
                            <p class="text-sm text-gray-500">{{ $transaksi->tiket->kode_tiket ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Tanggal Cetak</p>
                        <p class="text-sm font-medium">{{ now()->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Airline Info -->
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                    <div>
                        <p class="text-xs text-gray-500">Maskapai</p>
                        <p class="text-lg font-bold">
                            @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->maskapai))
                                {{ $transaksi->tiket->jadwal->maskapai->nama ?? 'Tidak tersedia' }}
                            @else
                                Tidak tersedia
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Nomor Penerbangan</p>
                        <p class="text-lg font-bold">
                            @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kode_penerbangan))
                                {{ $transaksi->tiket->jadwal->kode_penerbangan ?? 'Tidak tersedia' }}
                            @else
                                Tidak tersedia
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Route and Schedule -->
                <div class="mb-6">
                    <div class="flex justify-between mb-4">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Dari</p>
                            <p class="text-lg font-bold">
                                @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kotaAsal))
                                    {{ $transaksi->tiket->jadwal->kotaAsal->kode_kota ?? 'Tidak tersedia' }}
                                @else
                                    Tidak tersedia
                                @endif
                            </p>
                            <p class="text-sm">
                                @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kotaAsal))
                                    {{ $transaksi->tiket->jadwal->kotaAsal->nama_kota ?? 'Tidak tersedia' }}
                                @else
                                    Tidak tersedia
                                @endif
                            </p>
                        </div>
                        <div class="flex-1 flex items-center justify-center px-4">
                            <div class="w-full flex items-center">
                                <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                                <div class="flex-1 h-0.5 bg-gray-300"></div>
                                <div class="flex flex-col items-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11.43a1 1 0 00-.725-.962l-5-1.429a1 1 0 01.725-1.962l5 1.429a1 1 0 00.275.039h5.454l-2.17-4.341a1 1 0 00-.894-.553H10z"></path></svg>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->durasi_penerbangan))
                                            {{ $transaksi->tiket->jadwal->durasi_penerbangan ?? '0' }} menit
                                        @else
                                            - menit
                                        @endif
                                    </p>
                                </div>
                                <div class="flex-1 h-0.5 bg-gray-300"></div>
                                <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Ke</p>
                            <p class="text-lg font-bold">
                                @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kotaTujuan))
                                    {{ $transaksi->tiket->jadwal->kotaTujuan->kode_kota ?? 'Tidak tersedia' }}
                                @else
                                    Tidak tersedia
                                @endif
                            </p>
                            <p class="text-sm">
                                @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kotaTujuan))
                                    {{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota ?? 'Tidak tersedia' }}
                                @else
                                    Tidak tersedia
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-4">
                        <div>
                            <p class="text-xs text-gray-500">Tanggal Berangkat</p>
                            <p class="text-base font-medium">
                                @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->tanggal_berangkat))
                                    @php
                                        try {
                                            if (is_string($transaksi->tiket->jadwal->tanggal_berangkat)) {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat;
                                            } else {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat->format('d M Y');
                                            }
                                        } catch (\Exception $e) {
                                            echo 'Tidak tersedia';
                                        }
                                    @endphp
                                @else
                                    Tidak tersedia
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Waktu Berangkat</p>
                            <p class="text-base font-medium">
                                {{ $transaksi->tiket->jadwal->waktu_berangkat ?? $transaksi->tiket->jadwal->jam_berangkat ?? 'Tidak tersedia' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Waktu Tiba</p>
                            <p class="text-base font-medium">
                                {{ $transaksi->tiket->jadwal->waktu_tiba ?? $transaksi->tiket->jadwal->jam_tiba ?? 'Tidak tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Passenger Info -->
                <div class="mb-6 border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Penumpang</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Nama</p>
                            <p class="text-base font-medium">{{ $transaksi->user->name ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-base font-medium">{{ $transaksi->user->email ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kelas</p>
                            <p class="text-base font-medium">{{ $transaksi->tiket->kelas ?? 'Ekonomi' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">No. Kursi</p>
                            <p class="text-base font-medium">{{ $transaksi->tiket->nomor_kursi ?? 'Belum ditentukan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Price Info -->
                <div class="mb-6 border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Pembayaran</h3>
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-sm">Harga per Tiket</p>
                        <p class="text-sm font-medium">Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket,0,',','.') }}</p>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-sm">Jumlah Tiket</p>
                        <p class="text-sm font-medium">{{ $transaksi->quantity ?? 1 }} tiket</p>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <p class="text-sm font-semibold">Total Pembayaran</p>
                        <p class="text-base font-bold text-blue-600">Rp {{ number_format($transaksi->total_price ?? ($transaksi->tiket->jadwal->harga_tiket * ($transaksi->quantity ?? 1)),0,',','.') }}</p>
                    </div>
                </div>

                <!-- Barcode -->
                <div class="border-t border-gray-200 pt-4 text-center">
                    <div class="mb-2">
                        <p class="text-xs text-gray-500">Scan kode ini di bandara</p>
                        <div class="inline-block bg-gray-200 px-12 py-3 mt-2">
                            <p class="font-mono font-bold tracking-widest">{{ $transaksi->tiket->kode_tiket ?? 'ERROR' }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Tiket ini adalah bukti pembayaran yang sah. Mohon dibawa saat melakukan check-in.</p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 text-center py-3 px-4 text-xs text-gray-500">
            <p>Terima kasih telah memesan tiket melalui layanan kami</p>
        </div>
    </div>

    <div class="mt-6 text-center print:hidden">
        <a href="{{ route('user.history') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            &larr; Kembali ke Riwayat Perjalanan
        </a>
    </div>
</div>

<style>
    @media print {
        body {
            background-color: white;
        }
        @page {
            size: auto;
            margin: 0mm;
        }
        .print\\:hidden {
            display: none !important;
        }
        .print\\:mx-0 {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .print\\:px-0 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }
</style>
@endsection 