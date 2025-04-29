@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Tambah Tiket Baru
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('admin.tiket.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.tiket.store') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Ada beberapa masalah dengan input Anda:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Jadwal Penerbangan -->
                    <div class="sm:col-span-6">
                        <label for="jadwal_id" class="block text-sm font-medium text-gray-700">
                            Jadwal Penerbangan <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="jadwal_id" name="jadwal_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">-- Pilih Jadwal Penerbangan --</option>
                                @foreach ($jadwalPenerbangans as $jadwal)
                                <option value="{{ $jadwal->id }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->maskapai->nama_maskapai }} - {{ $jadwal->kotaAsal->nama_kota }} ke {{ $jadwal->kotaTujuan->nama_kota }} ({{ date('d/m/Y', strtotime($jadwal->tanggal_berangkat)) }} {{ date('H:i', strtotime($jadwal->jam_berangkat)) }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Pilih jadwal penerbangan untuk tiket ini.
                        </p>
                    </div>

                    <!-- Nomor Tiket -->
                    <div class="sm:col-span-3">
                        <label for="nomor_tiket" class="block text-sm font-medium text-gray-700">
                            Nomor Tiket <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" name="nomor_tiket" id="nomor_tiket" value="{{ old('nomor_tiket', 'TKT-' . strtoupper(substr(md5(uniqid()), 0, 8))) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                    </div>

                    <!-- Nomor Kursi -->
                    <div class="sm:col-span-3">
                        <label for="nomor_kursi" class="block text-sm font-medium text-gray-700">
                            Nomor Kursi <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" name="nomor_kursi" id="nomor_kursi" value="{{ old('nomor_kursi') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="sm:col-span-3">
                        <label for="harga" class="block text-sm font-medium text-gray-700">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="0" required>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="status" name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                                <option value="terjual" {{ old('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                            </select>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="sm:col-span-6">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">
                            Keterangan
                        </label>
                        <div class="mt-1">
                            <textarea id="keterangan" name="keterangan" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('keterangan') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Informasi tambahan tentang tiket ini.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.tiket.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 