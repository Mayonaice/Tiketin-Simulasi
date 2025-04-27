@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg card-hover w-full">
        <div class="px-8 py-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }}!</h2>
                    <p class="mt-1 text-sm text-gray-500">Anda login sebagai Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
        <!-- Total Pengguna -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg card-hover flex flex-col justify-center min-h-[120px] w-full">
            <div class="flex items-center w-full p-6">
                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Total Pengguna
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">
                                {{ \App\Models\User::count() }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Petugas -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg card-hover flex flex-col justify-center min-h-[120px] w-full">
            <div class="flex items-center w-full p-6">
                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Total Petugas
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">
                                {{ \App\Models\User::where('role', 'petugas')->count() }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg card-hover flex flex-col justify-center min-h-[120px] w-full">
            <div class="flex items-center w-full p-6">
                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Total User
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">
                                {{ \App\Models\User::where('role', 'user')->count() }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white shadow-lg rounded-lg card-hover w-full">
        <div class="px-8 py-5 sm:px-10">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Aktivitas Terbaru
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <div class="px-8 py-5 sm:px-10">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Sistem siap digunakan</p>
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