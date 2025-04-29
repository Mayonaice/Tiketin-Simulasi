@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Monitoring Tiket</h1>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Filter Tiket</h3>
            
            <form action="{{ route('admin.tickets') }}" method="GET" class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-3">
                <div>
                    <label for="maskapai_id" class="block text-sm font-medium text-gray-700">Maskapai</label>
                    <select id="maskapai_id" name="maskapai_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Maskapai</option>
                        @foreach($maskapais as $maskapai)
                            <option value="{{ $maskapai->id }}" {{ $maskapai_id == $maskapai->id ? 'selected' : '' }}>
                                {{ $maskapai->nama_maskapai }} ({{ $maskapai->kode_maskapai }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="jadwal_id" class="block text-sm font-medium text-gray-700">Jadwal Penerbangan</label>
                    <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Jadwal</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ $jadwal_id == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->maskapai->nama_maskapai }} | {{ $jadwal->kotaAsal->nama_kota }} - {{ $jadwal->kotaTujuan->nama_kota }} | {{ date('d/m/Y', strtotime($jadwal->tanggal_berangkat)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ $status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="dipesan" {{ $status == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                        <option value="terjual" {{ $status == 'terjual' ? 'selected' : '' }}>Terjual</option>
                    </select>
                </div>
                
                <div class="sm:col-span-3 flex justify-end space-x-3">
                    <a href="{{ route('admin.tickets') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <!-- Available Tickets -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tiket Tersedia
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $ticketStats['tersedia'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reserved Tickets -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tiket Dipesan
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $ticketStats['dipesan'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sold Tickets -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tiket Terjual
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $ticketStats['terjual'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Tiket {{ $jadwal_id || $maskapai_id || $status ? 'Terfilter' : 'Terbaru' }}</h3>
            
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maskapai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rute</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->kode_tiket }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $ticket->jadwal->maskapai->nama_maskapai }}</div>
                                    <div class="text-sm text-gray-500">{{ $ticket->jadwal->maskapai->kode_maskapai }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $ticket->jadwal->kotaAsal->nama_kota }} ({{ $ticket->jadwal->kotaAsal->kode_bandara }})</div>
                                    <div class="text-sm text-gray-500">ke {{ $ticket->jadwal->kotaTujuan->nama_kota }} ({{ $ticket->jadwal->kotaTujuan->kode_bandara }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ date('d M Y', strtotime($ticket->jadwal->tanggal_berangkat)) }}</div>
                                    <div class="text-sm text-gray-500">{{ date('H:i', strtotime($ticket->jadwal->jam_berangkat)) }} - {{ date('H:i', strtotime($ticket->jadwal->jam_tiba)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->status == 'tersedia')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Tersedia
                                        </span>
                                    @elseif($ticket->status == 'dipesan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Dipesan
                                        </span>
                                    @elseif($ticket->status == 'terjual')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Terjual
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data tiket</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 