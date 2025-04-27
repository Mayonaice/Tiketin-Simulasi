@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Konfirmasi Pemesanan Tiket</h2>
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif
    
    <form action="{{ route('booking.store') }}" method="POST">
        @csrf
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Detail Penerbangan</h3>
            @php
                $jadwal_id = request('jadwal_id');
                $jadwal = $jadwals->where('id', $jadwal_id)->first();
            @endphp
            
            @if($jadwal)
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded">
                    <div><b>Maskapai:</b> {{ $jadwal->maskapai->nama_maskapai }}</div>
                    <div><b>Tanggal:</b> {{ $jadwal->tanggal_berangkat }}</div>
                    <div><b>Dari:</b> {{ $jadwal->kotaAsal->nama_kota }}</div>
                    <div><b>Tujuan:</b> {{ $jadwal->kotaTujuan->nama_kota }}</div>
                    <div><b>Berangkat:</b> {{ $jadwal->jam_berangkat }}</div>
                    <div><b>Tiba:</b> {{ $jadwal->jam_tiba }}</div>
                    <div><b>Harga Tiket:</b> Rp {{ number_format($jadwal->harga_tiket,0,',','.') }}</div>
                    <div><b>Sisa Kursi:</b> {{ $jadwal->sisa_kursi }}</div>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('booking.index') }}" class="py-2 px-4 bg-gray-200 rounded">Batal</a>
                    <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Lanjutkan Pemesanan</button>
                </div>
            @else
                <div class="text-red-600 mb-4">Jadwal penerbangan tidak ditemukan.</div>
                <a href="{{ route('booking.index') }}" class="inline-block py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Kembali ke Daftar Jadwal</a>
            @endif
        </div>
    </form>
</div>
@endsection 