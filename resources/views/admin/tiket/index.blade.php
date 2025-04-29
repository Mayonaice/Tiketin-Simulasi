@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Data Tiket
            </h2>
        </div>
    </div>

    <!-- Filter & Search Box -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.tiket.index') }}" method="GET" class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari</label>
                    <div class="mt-1">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Kode tiket" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1">
                        <select id="status" name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                            <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="jadwal" class="block text-sm font-medium text-gray-700">Jadwal Penerbangan</label>
                    <div class="mt-1">
                        <select id="jadwal" name="jadwal" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Semua Jadwal</option>
                            @foreach($jadwalPenerbangans as $jadwal)
                                <option value="{{ $jadwal->id }}" {{ request('jadwal') == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->maskapai->nama_maskapai }} - {{ $jadwal->kotaAsal->nama_kota }} ke {{ $jadwal->kotaTujuan->nama_kota }} ({{ date('d/m/Y', strtotime($jadwal->tanggal_berangkat)) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-6 flex justify-end">
                    <a href="{{ route('admin.tiket.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Reset
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Message Alert -->
    @if (session('success'))
    <div class="rounded-md bg-green-50 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kode Tiket
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jadwal Penerbangan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tikets as $tiket)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $tiket->nomor_tiket ?? 'TIK'.str_pad($tiket->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="h-8 w-8 flex-shrink-0">
                                    @php 
                                        $logoPath = $tiket->jadwal->maskapai->logo_path;
                                        $defaultLogoPath = 'images/default-airline.png';
                                    @endphp
                                    <img class="h-8 w-8 rounded-full object-contain" 
                                        src="{{ $logoPath ? asset('storage/' . $logoPath) : asset($defaultLogoPath) }}" 
                                        alt="{{ $tiket->jadwal->maskapai->nama_maskapai }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $tiket->jadwal->maskapai->nama_maskapai }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $tiket->jadwal->kotaAsal->nama_kota }} → {{ $tiket->jadwal->kotaTujuan->nama_kota }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ date('d M Y', strtotime($tiket->jadwal->tanggal_berangkat)) }} {{ date('H:i', strtotime($tiket->jadwal->jam_berangkat)) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($tiket->harga ?? $tiket->jadwal->harga_tiket ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.tiket.show', $tiket->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="mt-2 text-base font-medium text-gray-500">Tidak ada data tiket yang ditemukan</span>
                                <p class="mt-1 text-sm text-gray-500">Coba sesuaikan filter atau tambahkan tiket baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $tikets->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection 