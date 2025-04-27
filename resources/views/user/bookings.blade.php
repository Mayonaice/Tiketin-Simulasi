@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Pemesanan Tiket</h1>
    
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-gray-500 md:ml-2">Riwayat Pemesanan</span>
                </div>
            </li>
        </ol>
    </nav>

    @if(session('success'))
    <div class="flex p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <div class="mb-4 flex justify-end">
        <a href="{{ route('booking.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Pesan Tiket Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex items-center">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h2 class="text-xl font-bold text-white">Riwayat Pemesanan Tiket</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">No</th>
                        <th class="py-3 px-6 text-left font-semibold">Kode Tiket</th>
                        <th class="py-3 px-6 text-left font-semibold">Rute</th>
                        <th class="py-3 px-6 text-left font-semibold">Tanggal</th>
                        <th class="py-3 px-6 text-left font-semibold">Status</th>
                        <th class="py-3 px-6 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($transaksis as $index => $transaksi)
                    <tr class="border-b border-gray-200 hover:bg-blue-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-medium">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                {{ $transaksi->tiket->kode_tiket }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaAsal->nama_kota }}</span>
                                <svg class="mx-2 w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                                <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($transaksi->tiket->jadwal->tanggal_berangkat)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($transaksi->status_bayar == 'approved')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-bold text-xs flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Disetujui
                            </span>
                            @elseif($transaksi->status_bayar == 'dibayar')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-bold text-xs flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Konfirmasi
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-bold text-xs flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Belum Dibayar
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <a href="{{ route('booking.show', $transaksi->id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                                
                                @if($transaksi->status_bayar == 'pending')
                                <a href="{{ route('booking.edit', $transaksi->id) }}" class="px-3 py-1 bg-green-100 text-green-600 rounded-full hover:bg-green-200 transition-colors flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload Bukti
                                </a>
                                @endif
                                
                                @if($transaksi->status_bayar == 'approved')
                                <a href="{{ route('booking.cetak', $transaksi->id) }}" target="_blank" class="px-3 py-1 bg-amber-100 text-amber-600 rounded-full hover:bg-amber-200 transition-colors flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak Tiket
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <td colspan="6" class="py-5 px-6 text-center">Belum ada pemesanan tiket</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 