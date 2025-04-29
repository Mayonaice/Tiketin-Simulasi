@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Detail Jadwal Penerbangan</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Jadwal Penerbangan</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail lengkap jadwal penerbangan.</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">ID Jadwal</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $jadwal->id }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Maskapai</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex items-center">
                            @if($jadwal->maskapai->logo_path)
                                <img src="{{ asset('storage/' . $jadwal->maskapai->logo_path) }}" alt="{{ $jadwal->maskapai->nama_maskapai }}" class="h-8 w-auto mr-2">
                            @endif
                            <div>
                                <div>{{ $jadwal->maskapai->nama_maskapai }}</div>
                                <div class="text-gray-500">{{ $jadwal->maskapai->kode_maskapai }}</div>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Rute</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div>
                            <span class="font-medium">{{ $jadwal->kotaAsal->nama_kota }}</span> 
                            <span class="text-gray-500">({{ $jadwal->kotaAsal->kode_bandara }})</span>
                            <svg class="inline-block h-4 w-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            <span class="font-medium">{{ $jadwal->kotaTujuan->nama_kota }}</span>
                            <span class="text-gray-500">({{ $jadwal->kotaTujuan->kode_bandara }})</span>
                        </div>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Berangkat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ date('d M Y', strtotime($jadwal->tanggal_berangkat)) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jam Berangkat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ date('H:i', strtotime($jadwal->jam_berangkat)) }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jam Tiba</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ date('H:i', strtotime($jadwal->jam_tiba)) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Harga Tiket</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kapasitas Kursi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $jadwal->kapasitas_kursi }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Sisa Kursi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div>{{ $jadwal->sisa_kursi }}</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($jadwal->sisa_kursi / $jadwal->kapasitas_kursi) * 100 }}%"></div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    
    <!-- Tiket Statistics -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Statistik Tiket</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Jumlah tiket berdasarkan status.</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-green-800">Tersedia</div>
                            <div class="text-2xl font-semibold text-green-900">{{ $ticketStats['tersedia'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-yellow-800">Dipesan</div>
                            <div class="text-2xl font-semibold text-yellow-900">{{ $ticketStats['dipesan'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-blue-800">Terjual</div>
                            <div class="text-2xl font-semibold text-blue-900">{{ $ticketStats['terjual'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 