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

                <div class="mt-4 mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                    <div class="flex items-center">
                        <button type="button" id="decreaseBtn" class="px-3 py-1 border border-gray-300 rounded-l bg-gray-100 hover:bg-gray-200">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $jadwal->sisa_kursi }}" class="w-20 text-center border-t border-b border-gray-300 py-1" readonly>
                        <button type="button" id="increaseBtn" class="px-3 py-1 border border-gray-300 rounded-r bg-gray-100 hover:bg-gray-200">+</button>
                    </div>
                </div>

                <div class="mt-4 mb-4 bg-blue-50 p-4 rounded">
                    <div class="text-lg font-semibold">Total Pembayaran</div>
                    <div class="flex justify-between items-center mt-2">
                        <div>
                            <span id="ticketCount">1</span> x Rp {{ number_format($jadwal->harga_tiket,0,',','.') }}
                        </div>
                        <div class="text-xl font-bold text-blue-600">
                            Rp <span id="totalPrice">{{ number_format($jadwal->harga_tiket,0,',','.') }}</span>
                        </div>
                    </div>
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

@if($jadwal)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const decreaseBtn = document.getElementById('decreaseBtn');
        const increaseBtn = document.getElementById('increaseBtn');
        const quantityInput = document.getElementById('quantity');
        const ticketCount = document.getElementById('ticketCount');
        const totalPrice = document.getElementById('totalPrice');
        const ticketPrice = {{ $jadwal->harga_tiket }};
        const maxTickets = {{ $jadwal->sisa_kursi }};
        
        // Format number to Indonesian Rupiah format
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
        
        // Update total price calculation
        function updateTotalPrice() {
            const quantity = parseInt(quantityInput.value);
            const total = quantity * ticketPrice;
            ticketCount.textContent = quantity;
            totalPrice.textContent = formatRupiah(total);
        }
        
        // Decrease button
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateTotalPrice();
            }
        });
        
        // Increase button
        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue < maxTickets) {
                quantityInput.value = currentValue + 1;
                updateTotalPrice();
            }
        });
        
        // Initialize
        updateTotalPrice();
    });
</script>
@endif
@endsection 