@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
        <h2 class="text-xl font-bold mb-2">Detail Jadwal Penerbangan</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><b>Maskapai:</b> {{ $jadwal->maskapai->nama_maskapai }}</div>
            <div><b>Tanggal:</b> {{ $jadwal->tanggal_berangkat }}</div>
            <div><b>Asal:</b> {{ $jadwal->kotaAsal->nama_kota }}</div>
            <div><b>Tujuan:</b> {{ $jadwal->kotaTujuan->nama_kota }}</div>
            <div><b>Jam Berangkat:</b> {{ $jadwal->jam_berangkat }}</div>
            <div><b>Jam Tiba:</b> {{ $jadwal->jam_tiba }}</div>
            <div><b>Harga Tiket:</b> Rp {{ number_format($jadwal->harga_tiket,0,',','.') }}</div>
            <div><b>Kapasitas Kursi:</b> {{ $jadwal->kapasitas_kursi }}</div>
            <div><b>Sisa Kursi:</b> {{ $jadwal->sisa_kursi }}</div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-lg font-bold mb-2">Daftar Tiket</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Kode Tiket</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tikets as $tiket)
                <tr>
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $tiket->kode_tiket }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs {{ $tiket->status == 'tersedia' ? 'bg-green-100 text-green-700' : ($tiket->status == 'dipesan' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-200 text-gray-700') }}">
                            {{ ucfirst($tiket->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 