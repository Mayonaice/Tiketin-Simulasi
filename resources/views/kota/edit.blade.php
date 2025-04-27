@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Kota</h1>
    
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('kota.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Kota</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-gray-500 md:ml-2">Edit</span>
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

    @if($errors->any())
    <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div>
            <span class="font-medium">Terdapat kesalahan:</span>
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 py-3 px-4">
            <h2 class="text-xl font-semibold text-white">Form Edit Kota</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('kota.update', $kota->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="nama_kota" class="block text-sm font-medium text-gray-700 mb-1">Nama Kota</label>
                        <input type="text" name="nama_kota" id="nama_kota" value="{{ old('nama_kota', $kota->nama_kota) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="kode_bandara" class="block text-sm font-medium text-gray-700 mb-1">Kode Bandara (3 huruf)</label>
                        <input type="text" name="kode_bandara" id="kode_bandara" value="{{ old('kode_bandara', $kota->kode_bandara) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required maxlength="3">
                        <p class="mt-1 text-sm text-gray-500">Kode harus terdiri dari 3 huruf</p>
                    </div>
                </div>
                
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('kota.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 