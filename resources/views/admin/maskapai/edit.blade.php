@extends('layouts.dashboard')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Maskapai</h2>
    <form action="{{ route('maskapai.update', $maskapai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Nama Maskapai</label>
            <input type="text" name="nama_maskapai" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('nama_maskapai', $maskapai->nama_maskapai) }}">
            @error('nama_maskapai')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Kode Maskapai</label>
            <input type="text" name="kode_maskapai" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('kode_maskapai', $maskapai->kode_maskapai) }}">
            @error('kode_maskapai')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Logo Maskapai</label>
            @if($maskapai->logo_path)
                <div class="mb-2">
                    <p class="text-sm text-gray-500 mb-1">Logo Saat Ini:</p>
                    <img src="{{ Storage::url($maskapai->logo_path) }}" alt="{{ $maskapai->nama_maskapai }}" class="h-16 w-auto border" onerror="this.src='{{ asset('images/no-image.png') }}'; this.onerror='';">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full border rounded px-3 py-2 mt-1">
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal ukuran: 2MB</p>
            @error('logo')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end">
            <a href="{{ route('maskapai.index') }}" class="mr-2 px-4 py-2 bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection 