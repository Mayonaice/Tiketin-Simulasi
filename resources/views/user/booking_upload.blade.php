@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Upload Bukti Pembayaran</h2>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Detail Pesanan</h3>
        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded">
            <div><b>Kode Tiket:</b> {{ $transaksi->tiket->kode_tiket }}</div>
            <div><b>Status:</b> 
                <span class="px-2 py-1 rounded text-xs {{ $transaksi->status_bayar == 'pending' ? 'bg-yellow-100 text-yellow-700' : ($transaksi->status_bayar == 'dibayar' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                    {{ ucfirst($transaksi->status_bayar) }}
                </span>
            </div>
            <div><b>Maskapai:</b> {{ $transaksi->tiket->jadwal->maskapai->nama_maskapai }}</div>
            <div><b>Tanggal:</b> {{ $transaksi->tiket->jadwal->tanggal_berangkat }}</div>
            <div><b>Dari:</b> {{ $transaksi->tiket->jadwal->kotaAsal->nama_kota }}</div>
            <div><b>Tujuan:</b> {{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota }}</div>
            <div><b>Berangkat:</b> {{ $transaksi->tiket->jadwal->jam_berangkat }}</div>
            <div><b>Tiba:</b> {{ $transaksi->tiket->jadwal->jam_tiba }}</div>
            <div><b>Harga Tiket:</b> Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket,0,',','.') }}</div>
        </div>
        
        @if($transaksi->status_bayar == 'pending')
        <form action="{{ route('booking.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_bayar" class="w-full border rounded px-3 py-2 mt-1" required>
                @error('bukti_bayar')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                <div class="text-sm text-gray-500 mt-1">Format: JPG, PNG, atau JPEG. Maks: 2MB</div>
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('booking.index') }}" class="py-2 px-4 bg-gray-200 rounded">Kembali</a>
                <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Upload Bukti</button>
            </div>
        </form>
        @else
        <div class="mt-4">
            <div class="text-green-600 mb-4">Bukti pembayaran sudah diupload, menunggu konfirmasi admin.</div>
            <div class="flex justify-end">
                <a href="{{ route('booking.index') }}" class="py-2 px-4 bg-gray-200 rounded">Kembali</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 