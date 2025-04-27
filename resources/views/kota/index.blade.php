@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Kota</h1>
    
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
                    <span class="ml-1 text-gray-500 md:ml-2">Kota</span>
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover mb-6">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 to-sky-400 py-4 px-6">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h2 class="text-xl font-bold text-white">Daftar Kota</h2>
            </div>
            <a href="{{ route('kota.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Kota
            </a>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-sky-50 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left font-semibold">No</th>
                            <th class="py-3 px-6 text-left font-semibold">Nama Kota</th>
                            <th class="py-3 px-6 text-left font-semibold">Kode Bandara</th>
                            <th class="py-3 px-6 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($kotas as $index => $kota)
                        <tr class="border-b border-gray-200 hover:bg-blue-50">
                            <td class="py-4 px-6">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-medium">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $kota->nama_kota }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    {{ $kota->kode_bandara }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kota.edit', $kota->id) }}" class="px-3 py-1 bg-amber-500 text-white rounded-full hover:bg-amber-600 transition-colors flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('kota.destroy', $kota->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors flex items-center" onclick="return confirm('Apakah Anda yakin ingin menghapus kota ini?')">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <td colspan="4" class="py-5 px-6 text-center">Tidak ada data kota</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 