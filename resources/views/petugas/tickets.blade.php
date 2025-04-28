@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6 flex items-center">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
            <h2 class="text-xl font-bold text-white">Manajemen Tiket</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Daftar Tiket</h3>
                <p class="text-gray-600 mb-4">
                    Halaman ini menampilkan semua tiket yang tersedia di sistem. Gunakan menu di bawah untuk mengelola tiket.
                </p>

                <div class="flex space-x-2 mb-6">
                    <a href="{{ route('tiket.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Monitoring Tiket
                    </a>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm leading-5 text-blue-700">
                            Sebagai petugas, Anda dapat melihat dan memantau status tiket pesawat.
                            Gunakan fitur 'Monitoring Tiket' untuk melihat detail dan status tiket secara lengkap.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Card Status Tiket -->
                <div class="bg-white shadow rounded-lg p-4 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Tiket Tersedia</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $ticketStats['tersedia'] ?? '--' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Tiket Dipesan</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $ticketStats['dipesan'] ?? '--' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg p-4 border-l-4 border-gray-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-gray-100 mr-4">
                            <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Tiket Terjual</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $ticketStats['terjual'] ?? '--' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 