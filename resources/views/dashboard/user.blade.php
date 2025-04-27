@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di sistem pemesanan tiket pesawat</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Pesan Tiket -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Pesan Tiket Baru
                            </dt>
                            <dd class="mt-1">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Klik untuk memesan
                                </a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pemesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Riwayat Pemesanan
                            </dt>
                            <dd class="mt-1">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Lihat riwayat
                                </a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profil -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Profil Anda
                            </dt>
                            <dd class="mt-1">
                                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Kelola profil
                                </a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Pemesanan Terbaru
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
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Belum ada pemesanan</p>
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
</div>
@endsection 