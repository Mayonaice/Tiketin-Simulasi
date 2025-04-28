@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Detail Pemesanan Tiket</h2>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Detail Pesanan</h3>
        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded">
            <div><b>Kode Tiket:</b> {{ $transaksi->tiket->kode_tiket }}</div>
            <div><b>Status Pembayaran:</b> 
                <span class="px-2 py-1 rounded text-xs {{ $transaksi->status_bayar == 'pending' ? 'bg-yellow-100 text-yellow-700' : ($transaksi->status_bayar == 'dibayar' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                    {{ ucfirst($transaksi->status_bayar) }}
                </span>
            </div>
            <div><b>Tanggal Pemesanan:</b> {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
            <div><b>Status Tiket:</b> 
                <span class="px-2 py-1 rounded text-xs {{ $transaksi->tiket->status == 'tersedia' ? 'bg-green-100 text-green-700' : ($transaksi->tiket->status == 'dipesan' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-200 text-gray-700') }}">
                    {{ ucfirst($transaksi->tiket->status) }}
                </span>
            </div>
            <div><b>Jumlah Tiket:</b> {{ $transaksi->quantity ?? 1 }}</div>
        </div>
    </div>
    
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Detail Penerbangan</h3>
        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded">
            <div><b>Maskapai:</b> {{ $transaksi->tiket->jadwal->maskapai->nama_maskapai }}</div>
            <div><b>Tanggal:</b> {{ $transaksi->tiket->jadwal->tanggal_berangkat }}</div>
            <div><b>Dari:</b> {{ $transaksi->tiket->jadwal->kotaAsal->nama_kota }}</div>
            <div><b>Tujuan:</b> {{ $transaksi->tiket->jadwal->kotaTujuan->nama_kota }}</div>
            <div><b>Berangkat:</b> {{ $transaksi->tiket->jadwal->jam_berangkat }}</div>
            <div><b>Tiba:</b> {{ $transaksi->tiket->jadwal->jam_tiba }}</div>
            <div><b>Harga Tiket:</b> Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket,0,',','.') }}</div>
        </div>
    </div>
    
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Rincian Pembayaran</h3>
        <div class="bg-blue-50 p-4 rounded">
            <div class="flex justify-between items-center mb-2">
                <div>Harga per Tiket</div>
                <div>Rp {{ number_format($transaksi->tiket->jadwal->harga_tiket,0,',','.') }}</div>
            </div>
            <div class="flex justify-between items-center mb-2">
                <div>Jumlah Tiket</div>
                <div>{{ $transaksi->quantity ?? 1 }} tiket</div>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-blue-200">
                <div class="font-semibold">Total Pembayaran</div>
                <div class="text-lg font-bold text-blue-600">
                    Rp {{ number_format($transaksi->total_price ?? ($transaksi->tiket->jadwal->harga_tiket * ($transaksi->quantity ?? 1)),0,',','.') }}
                </div>
            </div>
        </div>
    </div>
    
    @if($transaksi->bukti_bayar)
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Bukti Pembayaran</h3>
        <div class="border rounded p-4">
            <img src="{{ asset('storage/'.$transaksi->bukti_bayar) }}" alt="Bukti Pembayaran" class="max-w-full h-auto rounded">
        </div>
    </div>
    @endif
    
    <div class="flex justify-between">
        <a href="{{ route('booking.index') }}" class="py-2 px-4 bg-gray-200 rounded">Kembali ke Daftar</a>
        @if($transaksi->status_bayar == 'pending')
        <a href="{{ route('booking.edit', $transaksi->id) }}" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Upload Bukti Pembayaran</a>
        @endif
    </div>
</div>
@endsection 