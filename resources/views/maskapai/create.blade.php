@extends('layouts.dashboard')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Tambah Maskapai</h2>
    <form action="{{ route('maskapai.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nama Maskapai</label>
            <input type="text" name="nama_maskapai" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('nama_maskapai') }}">
            @error('nama_maskapai')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Kode Maskapai</label>
            <input type="text" name="kode_maskapai" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('kode_maskapai') }}">
            @error('kode_maskapai')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end">
            <a href="{{ route('maskapai.index') }}" class="mr-2 px-4 py-2 bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection 