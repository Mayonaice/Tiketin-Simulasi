@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex items-center">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
            <h2 class="text-xl font-bold text-white">Monitoring Tiket</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <form method="GET" class="flex items-center">
                    <label class="text-gray-700 font-medium mr-3">Filter Jadwal:</label>
                    <select name="jadwal_id" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        <option value="">-- Semua Jadwal --</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ $jadwal_id == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->maskapai->nama_maskapai ?? '' }} | {{ $jadwal->tanggal_berangkat }} | {{ $jadwal->kotaAsal->nama_kota ?? '' }} - {{ $jadwal->kotaTujuan->nama_kota ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left font-semibold">No</th>
                            <th class="py-3 px-6 text-left font-semibold">Kode Tiket</th>
                            <th class="py-3 px-6 text-left font-semibold">Jadwal</th>
                            <th class="py-3 px-6 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($tikets as $index => $tiket)
                        <tr class="border-b border-gray-200 hover:bg-blue-50">
                            <td class="py-4 px-6">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-medium">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    {{ $tiket->kode_tiket }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('tiket.show', $tiket->jadwal_id) }}" class="text-blue-600 hover:text-blue-800">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        {{ $tiket->jadwal->maskapai->nama_maskapai ?? '' }} | {{ \Carbon\Carbon::parse($tiket->jadwal->tanggal_berangkat)->format('d M Y') }} | 
                                        <span class="font-medium mx-1">{{ $tiket->jadwal->kotaAsal->nama_kota ?? '' }}</span> 
                                        <svg class="mx-1 w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                        <span class="font-medium">{{ $tiket->jadwal->kotaTujuan->nama_kota ?? '' }}</span>
                                    </div>
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                @if($tiket->status == 'tersedia')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-bold text-xs flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Tersedia
                                </span>
                                @elseif($tiket->status == 'dipesan')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-bold text-xs flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Dipesan
                                </span>
                                @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-bold text-xs flex items-center w-fit">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ ucfirst($tiket->status) }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <td colspan="4" class="py-5 px-6 text-center">Tidak ada data tiket</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 