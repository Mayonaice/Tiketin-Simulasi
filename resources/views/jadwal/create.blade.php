@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Tambah Jadwal Penerbangan</h2>
    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Maskapai</label>
            <select name="maskapai_id" class="w-full border rounded px-3 py-2 mt-1" required>
                <option value="">-- Pilih Maskapai --</option>
                @foreach($maskapais as $maskapai)
                    <option value="{{ $maskapai->id }}" {{ old('maskapai_id') == $maskapai->id ? 'selected' : '' }}>{{ $maskapai->nama_maskapai }}</option>
                @endforeach
            </select>
            @error('maskapai_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Kota Asal</label>
                <select name="kota_asal_id" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="">-- Pilih Kota Asal --</option>
                    @foreach($kotas as $kota)
                        <option value="{{ $kota->id }}" {{ old('kota_asal_id') == $kota->id ? 'selected' : '' }}>{{ $kota->nama_kota }}</option>
                    @endforeach
                </select>
                @error('kota_asal_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-gray-700">Kota Tujuan</label>
                <select name="kota_tujuan_id" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="">-- Pilih Kota Tujuan --</option>
                    @foreach($kotas as $kota)
                        <option value="{{ $kota->id }}" {{ old('kota_tujuan_id') == $kota->id ? 'selected' : '' }}>{{ $kota->nama_kota }}</option>
                    @endforeach
                </select>
                @error('kota_tujuan_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('tanggal_berangkat') }}">
                @error('tanggal_berangkat')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-gray-700">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('jam_berangkat') }}">
                @error('jam_berangkat')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Jam Tiba</label>
                <input type="time" name="jam_tiba" class="w-full border rounded px-3 py-2 mt-1" required value="{{ old('jam_tiba') }}">
                @error('jam_tiba')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-gray-700">Harga Tiket</label>
                <input type="number" name="harga_tiket" class="w-full border rounded px-3 py-2 mt-1" required min="0" value="{{ old('harga_tiket') }}">
                @error('harga_tiket')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Kapasitas Kursi</label>
                <input type="number" name="kapasitas_kursi" class="w-full border rounded px-3 py-2 mt-1" required min="1" value="{{ old('kapasitas_kursi') }}">
                @error('kapasitas_kursi')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('jadwal.index') }}" class="mr-2 px-4 py-2 bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection 