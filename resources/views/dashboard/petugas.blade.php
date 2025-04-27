@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="mt-1 text-sm text-gray-500">Anda login sebagai Petugas</p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Total Tiket Hari Ini -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tiket Hari Ini
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Transaksi
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Pendapatan Hari Ini
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    Rp 0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Transaksi Terbaru
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Belum ada transaksi</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="2024-01-01">Baru saja</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Maskapai -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                </svg>
                <h2 class="text-xl font-bold text-white">Daftar Maskapai</h2>
            </div>
            <a href="{{ route('maskapai.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Maskapai
            </a>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left font-semibold">No</th>
                            <th class="py-3 px-6 text-left font-semibold">Nama Maskapai</th>
                            <th class="py-3 px-6 text-left font-semibold">Kode Maskapai</th>
                            <th class="py-3 px-6 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @if(isset($maskapais) && count($maskapais) > 0)
                            @foreach($maskapais as $index => $maskapai)
                            <tr class="border-b border-gray-200 hover:bg-blue-50">
                                <td class="py-4 px-6">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-medium">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 22h14a2 2 0 002-2V9a1 1 0 00-1-1h-3v-.5a2.5 2.5 0 00-5 0V8H8a1 1 0 00-1 1v11a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $maskapai->nama_maskapai }}
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        {{ $maskapai->kode_maskapai }}
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('maskapai.edit', $maskapai->id) }}" class="px-3 py-1 bg-amber-500 text-white rounded-full hover:bg-amber-600 transition-colors flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('maskapai.destroy', $maskapai->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors flex items-center" onclick="return confirm('Apakah Anda yakin ingin menghapus maskapai ini?')">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <td colspan="4" class="py-5 px-6 text-center">Belum ada data maskapai</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 