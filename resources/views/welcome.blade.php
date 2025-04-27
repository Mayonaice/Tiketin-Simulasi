<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketin - Pemesanan Tiket Pesawat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e1f5fe 100%);
        }
        .hero {
            background-image: url('https://images.unsplash.com/photo-1569154941061-e231b4725ef1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8) 0%, rgba(37, 99, 235, 0.7) 100%);
        }
        .cloud {
            position: absolute;
            background: white;
            border-radius: 50%;
            filter: blur(5px);
            opacity: 0.8;
            animation: float 15s infinite ease-in-out;
        }
        .cloud:nth-child(1) {
            width: 150px;
            height: 60px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .cloud:nth-child(2) {
            width: 100px;
            height: 40px;
            top: 45%;
            left: 70%;
            animation-delay: 2s;
        }
        .cloud:nth-child(3) {
            width: 200px;
            height: 70px;
            top: 65%;
            left: 30%;
            animation-delay: 5s;
        }
        .plane {
            position: relative;
            animation: fly 20s infinite linear;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(20px);
            }
        }
        @keyframes fly {
            0% {
                transform: translateX(-100px) translateY(0);
            }
            25% {
                transform: translateX(calc(50vw - 100px)) translateY(-50px);
            }
            50% {
                transform: translateX(calc(100vw + 100px)) translateY(0);
            }
            75% {
                transform: translateX(calc(50vw - 100px)) translateY(50px);
            }
            100% {
                transform: translateX(-100px) translateY(0);
            }
        }
        .btn-hover {
            transition: all 0.3s ease;
            background-size: 200% auto;
            background-image: linear-gradient(to right, #4F46E5 0%, #3B82F6 50%, #4F46E5 100%);
        }
        .btn-hover:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="antialiased">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <span class="ml-2 text-2xl font-bold text-blue-600">Tiketin</span>
            </div>
            
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">Dashboard</a>
                        @else
                            <div class="flex space-x-3">
                                <a href="{{ route('login') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-full hover:bg-blue-50 transition-colors font-medium">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors font-medium">Daftar</a>
                                @endif
                            </div>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero min-h-screen flex items-center justify-center relative overflow-hidden">
            <!-- Clouds -->
            <div class="cloud"></div>
            <div class="cloud"></div>
            <div class="cloud"></div>
            
            <!-- Plane Animation -->
            <div class="plane absolute">
                <svg class="w-32 h-32 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M22 16.21v-1.895L14 8V4a2 2 0 0 0-4 0v4.105L2 14.42v1.789l8-2.81V18l-3 2v1l4.5-1L16 21v-1l-3-2v-5l8 2.5z"/>
                </svg>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 text-center px-4 max-w-5xl">
                <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">Jelajahi Dunia dengan Tiketin</h1>
                <p class="text-xl text-white opacity-90 mb-10 max-w-2xl mx-auto">Temukan kemudahan dalam pemesanan tiket pesawat dengan harga terbaik dan layanan terpercaya. Nikmati perjalanan nyaman ke berbagai destinasi impian Anda.</p>
                
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('login') }}" class="btn-hover px-8 py-4 rounded-full text-white font-bold text-lg shadow-lg">
                        Pesan Tiket Sekarang
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white bg-opacity-20 border border-white border-opacity-40 rounded-full text-white font-bold text-lg hover:bg-opacity-30 transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Mengapa Memilih Kami?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="feature-card bg-blue-50 rounded-xl p-8 text-center shadow-md">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Harga Terbaik</h3>
                        <p class="text-gray-600">Dapatkan harga tiket pesawat terbaik dan berbagai penawaran menarik untuk menghemat biaya perjalanan Anda.</p>
                    </div>
                    
                    <div class="feature-card bg-blue-50 rounded-xl p-8 text-center shadow-md">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Proses Cepat</h3>
                        <p class="text-gray-600">Pemesanan dan pembayaran yang cepat dan mudah, hanya dalam hitungan menit tiket Anda siap digunakan.</p>
                    </div>
                    
                    <div class="feature-card bg-blue-50 rounded-xl p-8 text-center shadow-md">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Aman & Terpercaya</h3>
                        <p class="text-gray-600">Transaksi aman dan terjamin dengan konfirmasi instan dan dukungan pelanggan 24/7.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Destinations Section -->
        <section class="py-20 bg-gradient-to-b from-blue-50 to-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Destinasi Populer</h2>
                <p class="text-center text-gray-600 mb-16 max-w-3xl mx-auto">Temukan berbagai destinasi menarik untuk liburan, perjalanan bisnis, atau kunjungan keluarga Anda.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Jakarta -->
                    <div class="rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="h-48 bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1546015018-bacd6c632472?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80')"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Jakarta</h3>
                            <p class="text-gray-600 mb-4">Jelajahi ibu kota Indonesia dengan berbagai atraksi dan kuliner khas.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Mulai Rp 500.000</span>
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm hover:bg-blue-700 transition-colors">Pesan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bali -->
                    <div class="rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="h-48 bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1536152470836-b943b246224c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80')"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Bali</h3>
                            <p class="text-gray-600 mb-4">Nikmati keindahan pantai dan budaya di pulau dewata yang menakjubkan.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Mulai Rp 750.000</span>
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm hover:bg-blue-700 transition-colors">Pesan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Yogyakarta -->
                    <div class="rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="h-48 bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1584810359583-96fc9e5afbba?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80')"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Yogyakarta</h3>
                            <p class="text-gray-600 mb-4">Rasakan pesona sejarah dan budaya Jawa di kota pelajar yang istimewa.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Mulai Rp 600.000</span>
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm hover:bg-blue-700 transition-colors">Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-20 bg-blue-600">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold text-white mb-6">Siap Untuk Perjalanan Berikutnya?</h2>
                <p class="text-xl text-white opacity-90 mb-10 max-w-2xl mx-auto">Daftar sekarang dan mulai menjelajahi dunia dengan berbagai penawaran menarik dari Tiketin.</p>
                
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white rounded-full text-blue-600 font-bold text-lg shadow-lg hover:bg-blue-50 transition-colors">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-transparent border-2 border-white rounded-full text-white font-bold text-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        Masuk
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span class="ml-2 text-2xl font-bold text-blue-400">Tiketin</span>
                    </div>
                    <p class="text-gray-400">Tiketin membantu Anda menemukan tiket pesawat terbaik untuk perjalanan Anda ke berbagai destinasi di Indonesia dan luar negeri.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Tiket Pesawat</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Promo Spesial</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Program Loyalitas</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Pemesanan Grup</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Tentang Kami</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Profil Perusahaan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-400">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-400">info@tiketin.id</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-400">Jl. Merdeka No. 123, Jakarta</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-gray-800 mb-8">
            
            <div class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Tiketin. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>
</body>
</html>
