<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Mode - Tannya Caffe</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDFDF7; /* Light beige/cream background */
        }
        .font-instrument {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased selection:bg-green-500 selection:text-white overflow-x-hidden" x-data="{ showExitModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <!-- Full Screen Warning Overlay (Hidden by default) -->
    <div id="fullscreen-overlay" class="fixed inset-0 bg-black/90 z-[100] hidden flex items-center justify-center text-white text-center p-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Mode Customer Terhenti</h2>
            <p class="mb-6">Silakan kembali ke mode layar penuh untuk melanjutkan.</p>
            <button onclick="enableFullScreen()" class="px-6 py-3 bg-green-500 rounded-full font-bold hover:bg-green-600 transition">
                Kembali ke Mode Layar Penuh
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 px-8 py-6 flex justify-between items-center bg-[#FDFDF7]/90 backdrop-blur-sm">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#1A2F2B] rounded-lg flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="font-bold text-xl text-[#1A2F2B]">Tannya Caffe</span>
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
            <a href="#" class="hover:text-[#1A2F2B] transition">Menu</a>
            <a href="#" class="hover:text-[#1A2F2B] transition">Tentang Kami</a>
            <a href="#" class="hover:text-[#1A2F2B] transition">Lokasi</a>
        </div>

        <button class="bg-[#1A2F2B] text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-green-800 transition shadow-lg shadow-green-900/20 flex items-center gap-2">
            Pesan Sekarang
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-8 max-w-7xl mx-auto min-h-[80vh] flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold tracking-wider uppercase">
                    <span>PENGALAMAN BARU</span>
                    <span>•</span>
                    <span>TANPA DAFTAR</span>
                </div>
                
                <h1 class="text-6xl lg:text-7xl font-bold text-[#1A2F2B] leading-tight font-instrument">
                    Mau ngopi <br>
                    <span class="text-[#D32F2F] italic">apa</span> hari ini?
                </h1>
                
                <p class="text-lg text-gray-600 max-w-md leading-relaxed">
                    Tempat buat kamu yang penasaran. Masuk, pesan, dan nikmatin kopi spesial pilihanmu tanpa ribet.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <button class="bg-[#D32F2F] text-white px-8 py-4 rounded-full font-bold hover:bg-red-700 transition shadow-lg shadow-red-500/30 flex items-center gap-2">
                        Pesan Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                    <button class="bg-white text-[#1A2F2B] border border-gray-200 px-8 py-4 rounded-full font-bold hover:bg-gray-50 transition">
                        Lihat Menu
                    </button>
                </div>

                <div class="flex items-center gap-3 text-sm text-gray-500 pt-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Nikmati kemudahan pesan tanpa ribet bikin akun
                </div>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="relative w-80 h-80 lg:w-96 lg:h-96 flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="w-full h-full object-cover rounded-full shadow-xl">
                </div>
                <!-- Floating Elements -->
                <div class="absolute bottom-0 right-10 bg-[#1A2F2B] p-4 rounded-2xl text-white shadow-xl transform rotate-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Spesial Section -->
    <section class="py-20 px-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-[#1A2F2B] mb-2 font-instrument">Menu Spesial Pekan Ini</h2>
                <p class="text-gray-500">Siap dipesan langsung. Gak perlu login.</p>
            </div>
            <div class="flex gap-2">
                <button class="p-3 rounded-full border border-gray-200 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="p-3 rounded-full border border-gray-200 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
            <div class="group bg-white p-4 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative h-64 bg-gray-100 rounded-2xl overflow-hidden mb-6">
                    @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-[#1A2F2B] shadow-sm">
                        Rp {{ number_format($product->base_price, 0, ',', '.') }}
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-[#1A2F2B] mb-2">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $product->description ?? 'Nikmati rasa otentik yang tak terlupakan.' }}</p>
                
                <button class="w-full py-3 bg-[#1A2F2B] text-white rounded-xl font-bold hover:bg-green-800 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>
            @empty
            <!-- Fallback Static Cards if no products -->
            <div class="group bg-white p-4 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative h-64 bg-gray-100 rounded-2xl overflow-hidden mb-6">
                    <div class="w-full h-full bg-[#E8E6E1]"></div>
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-[#1A2F2B]">Rp 35.000</div>
                </div>
                <h3 class="text-xl font-bold text-[#1A2F2B] mb-2">Mystic Lavender Latte</h3>
                <p class="text-gray-500 text-sm mb-4">Espresso signature dengan sentuhan bunga lavender.</p>
                <button class="w-full py-3 bg-[#1A2F2B] text-white rounded-xl font-bold hover:bg-green-800 transition">Tambah</button>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Kenapa Tannya Section -->
    <section class="bg-[#2C4A3B] text-white py-24 mt-12 rounded-t-[3rem] relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="flex justify-center mb-16">
                <div class="inline-block px-4 py-1 border border-white/30 rounded-full text-xs font-bold tracking-widest uppercase">
                    JADI KAMI
                </div>
            </div>

            <h2 class="text-4xl md:text-5xl font-bold text-center mb-20 font-instrument">Kenapa Tannya?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <div class="space-y-4">
                    <div class="w-12 h-12 mx-auto text-yellow-400">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Gak Pake Ribet</h3>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Lupain formulir pendaftaran yang panjang. Kami hargai waktumu sama seperti kami hargai kopimu. Pesan dan langsung nikmati.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="w-12 h-12 mx-auto text-green-400">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Asik Diajak Ngobrol</h3>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Kami gak cuma sekadar nyajiin kopi, tapi juga buka obrolan seru. Setiap cangkir adalah awal dari cerita baru.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="w-12 h-12 mx-auto text-blue-400">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Selalu Penasaran</h3>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Menu musiman kami adalah teka-teki rasa yang terus berubah, bikin kamu selalu penasaran sama kejutan berikutnya.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1F352B] text-white/50 py-12 px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="font-bold text-lg">Tannya Caffe</span>
            </div>

            <div class="flex gap-8 text-sm">
                <a href="#" class="hover:text-white transition">Instagram</a>
                <a href="#" class="hover:text-white transition">Twitter</a>
                <a href="#" class="hover:text-white transition">Tiktok</a>
            </div>

            <div class="text-xs">
                © 2024 Tannya Caffe. All rights reserved.
            </div>
            
            <!-- TUTUP APLIKASI Button -->
            <button type="button" @click="showExitModal = true" class="bg-white text-[#1A2F2B] px-6 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                TUTUP APLIKASI
            </button>
        </div>
    </footer>

    <!-- Exit Confirmation Modal -->
    <div x-show="showExitModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center px-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showExitModal = false"></div>

        <!-- Modal Card -->
        <div class="bg-white rounded-[2rem] p-8 w-full max-w-sm relative z-10 text-center shadow-2xl transform transition-all" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="w-12 h-12 text-[#D32F2F] mx-auto mb-4">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-[#1A2F2B] mb-2 font-instrument">Konfirmasi Tutup Aplikasi</h3>
            <p class="text-gray-500 text-sm mb-6">Masukkan password kasir untuk menutup aplikasi ini.</p>

            <form method="POST" action="{{ route('customer.exit') }}">
                @csrf
                <div class="relative mb-6">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 11.293l-3.071 3.071a1.5 1.5 0 00-2.122 0l-.353-.353a1.5 1.5 0 000-2.122l3.071-3.071a6 6 0 018.743-1.5z" />
                        </svg>
                    </span>
                    <input type="password" name="password" required autofocus class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#1A2F2B] focus:ring-1 focus:ring-[#1A2F2B] outline-none transition text-sm" placeholder="Password Kasir">
                </div>

                @if ($errors->has('password'))
                <p class="text-red-500 text-xs mb-4 text-left -mt-4">{{ $errors->first('password') }}</p>
                @endif

                <div class="space-y-3">
                    <button type="submit" class="w-full py-3 bg-[#D32F2F] hover:bg-red-700 text-white rounded-xl font-bold transition shadow-lg shadow-red-500/20">
                        Tutup Sekarang
                    </button>
                    <button type="button" @click="showExitModal = false" class="w-full py-3 text-gray-500 font-bold hover:text-[#1A2F2B] transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function enableFullScreen() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }

        // Auto-enable fullscreen on first interaction
        document.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                enableFullScreen();
            }
        }, { once: true });

        // Prevent leaving the page easily
        window.onbeforeunload = function() {
            return "Apakah Anda yakin ingin keluar dari Mode Customer?";
        };
    </script>
</body>
</html>
