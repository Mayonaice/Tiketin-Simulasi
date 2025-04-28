@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Hero Banner -->
        <div class="relative">
            <div class="h-48 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0 bg-repeat opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMwLTkuOTQtOC4wNi0xOC0xOC0xOHY2YzYuNjMgMCAxMiA1LjM3IDEyIDEyaC04djEyaDI0VjE4SDM2eiIgZmlsbD0iI2ZmZiIvPjwvZz48L3N2Zz4=');"></div>
                </div>
                <div class="text-center z-10 px-4">
                    <h2 class="text-3xl font-bold text-white mb-2 drop-shadow-md">Pesan Tiket Pesawat</h2>
                    <p class="text-white/90 text-lg max-w-xl mx-auto">Temukan penerbangan terbaik untuk perjalanan Anda ke berbagai destinasi</p>
                </div>
            </div>
        </div>
        
        <!-- Search Form -->
        <div class="p-6 bg-white border-b relative">
            <div class="absolute -top-7 left-1/2 transform -translate-x-1/2">
                <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
            </div>
        
            <form action="{{ route('booking.index') }}" method="GET" class="mt-4">
                <div class="bg-gray-50 rounded-xl shadow-inner p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Pencarian
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Kota Berangkat -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="kota_asal" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Kota Berangkat
                            </label>
                            <select id="kota_asal" name="kota_asal" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Semua Kota</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->id }}" {{ request('kota_asal') == $kota->id ? 'selected' : '' }}>
                                        {{ $kota->nama_kota }} ({{ $kota->kode_bandara }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Kota Tujuan -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="kota_tujuan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Kota Tujuan
                            </label>
                            <select id="kota_tujuan" name="kota_tujuan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Semua Kota</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->id }}" {{ request('kota_tujuan') == $kota->id ? 'selected' : '' }}>
                                        {{ $kota->nama_kota }} ({{ $kota->kode_bandara }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Maskapai -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="maskapai" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                                </svg>
                                Maskapai
                            </label>
                            <select id="maskapai" name="maskapai" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Semua Maskapai</option>
                                @foreach($maskapais as $maskapai)
                                    <option value="{{ $maskapai->id }}" {{ request('maskapai') == $maskapai->id ? 'selected' : '' }}>
                                        {{ $maskapai->nama_maskapai }} ({{ $maskapai->kode_maskapai }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Tanggal -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Berangkat
                            </label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        
                        <!-- Harga Min -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="harga_min" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Harga Minimum
                            </label>
                            <input type="number" id="harga_min" name="harga_min" placeholder="Min Harga" value="{{ request('harga_min') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        
                        <!-- Harga Max -->
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <label for="harga_max" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Harga Maksimum
                            </label>
                            <input type="number" id="harga_max" name="harga_max" placeholder="Max Harga" value="{{ request('harga_max') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-5">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-2 px-6 rounded-full shadow-md transition-all flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari Tiket
                        </button>
                        
                        <a href="{{ route('booking.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Hasil Pencarian
                <span class="ml-2 text-sm font-normal text-gray-500">({{ $jadwals->count() }} penerbangan ditemukan)</span>
            </h3>
            
            <div class="grid grid-cols-1 gap-4">
                @forelse($jadwals as $index => $jadwal)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="p-4 md:p-6">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <!-- Maskapai & Logo -->
                            <div class="w-full md:w-1/4 mb-4 md:mb-0">
                                <div class="flex flex-col items-center md:items-start">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-center md:text-left">
                                        <h4 class="font-bold text-gray-800">{{ $jadwal->maskapai->nama_maskapai }}</h4>
                                        <p class="text-sm text-gray-500">{{ $jadwal->maskapai->kode_maskapai }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Route Info -->
                            <div class="w-full md:w-2/4 mb-4 md:mb-0">
                                <div class="flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="font-bold text-lg text-gray-800">{{ $jadwal->kotaAsal->nama_kota }}</div>
                                        <div class="text-xs text-gray-500">{{ $jadwal->kotaAsal->kode_bandara }}</div>
                                        <div class="text-sm font-medium text-blue-600">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }}</div>
                                    </div>
                                    
                                    <div class="mx-4">
                                        <div class="w-32 border-t-2 border-gray-300 my-2 relative">
                                            <div class="absolute -top-2 left-0 w-2 h-2 rounded-full bg-gray-300"></div>
                                            <div class="absolute -top-2 right-0 w-2 h-2 rounded-full bg-gray-300"></div>
                                        </div>
                                        <div class="text-xs text-center text-gray-500">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->diff(\Carbon\Carbon::parse($jadwal->jam_tiba))->format('%h jam %i menit') }}
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="font-bold text-lg text-gray-800">{{ $jadwal->kotaTujuan->nama_kota }}</div>
                                        <div class="text-xs text-gray-500">{{ $jadwal->kotaTujuan->kode_bandara }}</div>
                                        <div class="text-sm font-medium text-blue-600">{{ \Carbon\Carbon::parse($jadwal->jam_tiba)->format('H:i') }}</div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->format('d M Y') }}
                                </div>
                            </div>
                            
                            <!-- Price & Booking -->
                            <div class="w-full md:w-1/4 flex flex-col items-center md:items-end">
                                <div class="mb-2">
                                    <div class="text-gray-500 text-sm">Mulai dari</div>
                                    <div class="text-2xl font-bold text-indigo-600">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">Tersisa {{ $jadwal->sisa_kursi }} kursi</div>
                                </div>
                                <a href="{{ route('booking.create', ['jadwal_id' => $jadwal->id]) }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium py-2 px-6 rounded-full transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white border border-gray-200 rounded-xl p-10 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada jadwal penerbangan yang tersedia</h3>
                        <p class="text-gray-500 mb-4">Coba ubah parameter pencarian Anda untuk menemukan tiket yang tersedia</p>
                        <a href="{{ route('booking.index') }}" class="text-blue-600 font-medium hover:text-blue-800 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Pencarian
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 