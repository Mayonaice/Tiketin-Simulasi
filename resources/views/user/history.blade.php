@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Perjalanan</h1>
    
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
                    <span class="ml-1 text-gray-500 md:ml-2">Riwayat Perjalanan</span>
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                Perjalanan yang Telah Dilakukan
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">No</th>
                        <th scope="col" class="px-6 py-3 text-left">Kode Tiket</th>
                        <th scope="col" class="px-6 py-3 text-left">Maskapai</th>
                        <th scope="col" class="px-6 py-3 text-left">Rute</th>
                        <th scope="col" class="px-6 py-3 text-left">Tanggal & Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left">Total</th>
                        <th scope="col" class="px-6 py-3 text-left">Status</th>
                        <th scope="col" class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis->where('status_bayar', 'approved') as $index => $item)
                    @php
                        $currentDate = \Carbon\Carbon::now();
                        $isComplete = false;
                        
                        if (isset($item->tiket) && isset($item->tiket->jadwal) && isset($item->tiket->jadwal->tanggal_berangkat)) {
                            $tglBerangkat = $item->tiket->jadwal->tanggal_berangkat;
                            $jamTiba = $item->tiket->jadwal->jam_tiba;
                            
                            if (is_string($tglBerangkat)) {
                                try {
                                    $tglBerangkat = \Carbon\Carbon::parse($tglBerangkat);
                                    
                                    // Jika tanggal berangkat sama dengan hari ini, periksa jam tiba
                                    if ($tglBerangkat->isSameDay($currentDate) && !empty($jamTiba)) {
                                        $waktuTiba = \Carbon\Carbon::parse($tglBerangkat->format('Y-m-d') . ' ' . $jamTiba);
                                        $isComplete = $waktuTiba->lt($currentDate);
                                    } else {
                                        // Jika tanggal berangkat lebih awal dari hari ini
                                        $isComplete = $tglBerangkat->lt($currentDate);
                                    }
                                } catch (\Exception $e) {
                                    $isComplete = false;
                                }
                            }
                        }
                        
                        if (!$isComplete) continue;
                    @endphp
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium">{{ $item->tiket->kode_tiket }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $item->tiket->jadwal->maskapai->nama_maskapai }}
                                    </p>
                                    <p class="text-gray-600 whitespace-no-wrap">{{ $item->tiket->jadwal->maskapai->kode_maskapai }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="flex items-center mb-1">
                                    <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $item->tiket->jadwal->kotaAsal->nama_kota }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $item->tiket->jadwal->kotaTujuan->nama_kota }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="flex items-center mb-1">
                                    <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($item->tiket->jadwal->tanggal_berangkat)->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($item->tiket->jadwal->jam_berangkat)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->tiket->jadwal->jam_tiba)->format('H:i') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $item->quantity ?? 1 }} tiket</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Rp {{ number_format($item->total_price ?? ($item->tiket->jadwal->harga_tiket * ($item->quantity ?? 1)),0,',','.') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-bold text-xs flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('booking.show', $item->id) }}" class="px-4 py-1 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <td colspan="7" class="py-5 px-6 text-center">Belum ada perjalanan yang selesai</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Perjalanan yang Akan Datang
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">No</th>
                        <th class="py-3 px-6 text-left font-semibold">Kode Tiket</th>
                        <th class="py-3 px-6 text-left font-semibold">Rute</th>
                        <th class="py-3 px-6 text-left font-semibold">Tanggal</th>
                        <th class="py-3 px-6 text-left font-semibold">Maskapai</th>
                        <th class="py-3 px-6 text-left font-semibold">Status</th>
                        <th class="py-3 px-6 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($transaksis->where('status_bayar', 'approved')->sortByDesc('created_at') as $index => $transaksi)
                    @php
                        $currentDate = \Carbon\Carbon::now();
                        $isUpcoming = false;
                        
                        if (isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->tanggal_berangkat)) {
                            $tglBerangkat = $transaksi->tiket->jadwal->tanggal_berangkat;
                            
                            if (is_string($tglBerangkat)) {
                                try {
                                    $tglBerangkat = \Carbon\Carbon::parse($tglBerangkat);
                                    $isUpcoming = $tglBerangkat->gte($currentDate);
                                } catch (\Exception $e) {
                                    $isUpcoming = false;
                                }
                            }
                        }
                        
                        if (!$isUpcoming) continue;
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-blue-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-medium">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                {{ $transaksi->tiket->kode_tiket ?? 'Tidak tersedia' }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->kotaAsal) && isset($transaksi->tiket->jadwal->kotaTujuan))
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaAsal->nama_kota ?? '-' }}</span>
                                    <svg class="mx-2 w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                    <span class="font-medium">{{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota ?? '-' }}</span>
                                </div>
                            @else
                                Informasi rute tidak tersedia
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->tanggal_berangkat))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    @php
                                        try {
                                            if (is_string($transaksi->tiket->jadwal->tanggal_berangkat)) {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat;
                                            } else {
                                                echo $transaksi->tiket->jadwal->tanggal_berangkat->format('d M Y');
                                            }
                                        } catch (\Exception $e) {
                                            echo 'Tanggal tidak valid';
                                        }
                                    @endphp
                                </div>
                            @else
                                Tanggal tidak tersedia
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if(isset($transaksi->tiket) && isset($transaksi->tiket->jadwal) && isset($transaksi->tiket->jadwal->maskapai))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $transaksi->tiket->jadwal->maskapai->nama_maskapai ?? '-' }}
                                </div>
                            @else
                                Informasi maskapai tidak tersedia
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-xs flex items-center w-fit">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Akan Datang
                            </span>
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
                                
                                <a href="{{ route('booking.cetak', $transaksi->id) }}" target="_blank" class="px-3 py-1 bg-green-100 text-green-600 rounded-full hover:bg-green-200 transition-colors flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak Tiket
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <td colspan="7" class="py-5 px-6 text-center">Belum ada perjalanan yang akan datang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 