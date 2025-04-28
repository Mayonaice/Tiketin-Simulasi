@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <!-- Hero Section with Carousel -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl">
        <div class="relative">
            <!-- Carousel Images -->
            <div id="default-carousel" class="relative" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover h-full" alt="Airplane Wing">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://images.unsplash.com/photo-1503221043305-f7498f8b7888?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover h-full" alt="Vacation Destination">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover h-full" alt="Tropical Beach">
                    </div>
                </div>
                
                <!-- Slider controls -->
                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
            
            <!-- Overlay Text -->
            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-t-xl">
                <div class="text-center px-6 md:px-12">
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Selamat Datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-lg md:text-xl text-white/90 mb-8">Temukan pengalaman perjalanan terbaik bersama kami</p>
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Pesan Tiket Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Promo Sections -->
    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Penawaran Spesial
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Promo Card 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all hover:scale-105">
                <div class="h-36 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                    <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">HEMAT 20%</div>
                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="text-white font-bold">Liburan ke Bali</h3>
                        <p class="text-white/80 text-sm">Masa berlaku: 30 Nov 2023</p>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-gray-600 text-sm mb-3">Nikmati diskon spesial untuk penerbangan ke Bali di penghujung tahun.</p>
                    <a href="{{ route('booking.index') }}" class="text-blue-600 font-medium text-sm hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
            
            <!-- Promo Card 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all hover:scale-105">
                <div class="h-36 bg-gradient-to-r from-purple-500 to-pink-600 relative">
                    <div class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">DISKON 15%</div>
                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="text-white font-bold">Jelajah Jakarta</h3>
                        <p class="text-white/80 text-sm">Masa berlaku: 15 Des 2023</p>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-gray-600 text-sm mb-3">Dapatkan harga spesial untuk penerbangan ke Jakarta selama bulan ini.</p>
                    <a href="{{ route('booking.index') }}" class="text-blue-600 font-medium text-sm hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
            
            <!-- Promo Card 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all hover:scale-105">
                <div class="h-36 bg-gradient-to-r from-amber-500 to-orange-600 relative">
                    <div class="absolute top-4 right-4 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full">EKSTRA BAGASI</div>
                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="text-white font-bold">Paket Business Class</h3>
                        <p class="text-white/80 text-sm">Masa berlaku: 31 Des 2023</p>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-gray-600 text-sm mb-3">Ekstra bagasi 10kg untuk setiap pembelian tiket Business Class.</p>
                    <a href="{{ route('booking.index') }}" class="text-blue-600 font-medium text-sm hover:text-blue-800">Lihat Detail →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pesan Tiket -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-600 rounded-xl">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full">Rekomendasi</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pesan Tiket</h3>
                <p class="text-gray-600 mb-4">Temukan dan pesan tiket penerbangan dengan harga terbaik untuk perjalanan Anda</p>
                <a href="{{ route('booking.index') }}" class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800">
                    Pesan Sekarang
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Riwayat Pemesanan -->
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-amber-500 rounded-xl">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Riwayat Pemesanan</h3>
                <p class="text-gray-600 mb-4">Lihat dan kelola semua pemesanan tiket yang telah Anda lakukan sebelumnya</p>
                <a href="{{ route('user.bookings') }}" class="inline-flex items-center font-medium text-amber-600 hover:text-amber-800">
                    Lihat Riwayat
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Profil -->
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-emerald-500 rounded-xl">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Profil Anda</h3>
                <p class="text-gray-600 mb-4">Kelola profil dan informasi pribadi Anda untuk pengalaman pemesanan yang lebih baik</p>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center font-medium text-emerald-600 hover:text-emerald-800">
                    Kelola Profil
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pemesanan Terbaru
            </h3>
        </div>
        <div class="px-6 py-5">
            <div class="flow-root">
                <ul class="-mb-8">
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Belum ada pemesanan tiket terbaru.</p>
                                        <p class="mt-1 text-sm text-blue-600">
                                            <a href="{{ route('booking.index') }}" class="hover:underline">Pesan tiket sekarang!</a>
                                        </p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ now() }}">{{ now()->format('d M Y') }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Carousel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('default-carousel');
    const items = carousel.querySelectorAll('[data-carousel-item]');
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    let currentIndex = 0;
    
    // Show first item
    items[currentIndex].classList.remove('hidden');
    
    function showItem(index) {
        // Hide all items
        items.forEach(item => {
            item.classList.add('hidden');
        });
        // Show current item
        items[index].classList.remove('hidden');
    }
    
    function nextItem() {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    }
    
    function prevItem() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItem(currentIndex);
    }
    
    // Auto slide every 5 seconds
    const interval = setInterval(nextItem, 5000);
    
    // Event listeners for buttons
    nextButton.addEventListener('click', () => {
        clearInterval(interval);
        nextItem();
    });
    
    prevButton.addEventListener('click', () => {
        clearInterval(interval);
        prevItem();
    });
});
</script>
@endsection 