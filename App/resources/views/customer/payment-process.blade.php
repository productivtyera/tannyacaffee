<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Process - Tannya Caffe</title>
    
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
            background-color: #FDFDF7; /* Cream background to match checkout */
        }
        .font-instrument {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden" x-data="paymentProcess()">

    <!-- Background Elements -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <!-- Add subtle background pattern or gradient if needed -->
    </div>

    <!-- Main Card -->
    @if($order->payment_status == 'paid')
    <div class="bg-white rounded-[2.5rem] p-12 w-full max-w-md shadow-2xl relative z-10 text-center border border-gray-100">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h2>
        <p class="text-gray-500 mb-8">Pesananmu sedang disiapkan.</p>
        <a href="{{ route('customer.index') }}" class="inline-block px-8 py-3 bg-[#2D5A27] text-white font-bold rounded-xl shadow-lg shadow-green-900/20">
            Kembali ke Menu
        </a>
    </div>
    @elseif($order->payment_method == 'midtrans_qris')
    <div class="bg-white rounded-[2.5rem] p-12 w-full max-w-md shadow-2xl relative z-10 text-center border border-gray-100">
        
        <!-- Header Badge -->
        <div class="inline-block bg-[#F5F8F2] px-4 py-2 rounded-full mb-6">
            <span class="text-[#2D5A27] font-bold text-xs uppercase tracking-widest">Pembayaran QRIS</span>
        </div>

        <!-- Total Amount -->
        <div class="mb-2 text-gray-500 text-sm font-medium">Total Bayar</div>
        <div class="text-4xl font-instrument font-bold text-[#2D5A27] mb-8">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </div>

        <!-- Timer -->
        <div class="inline-flex items-center gap-2 bg-[#FEF2F2] px-4 py-2 rounded-full mb-8 text-[#991B1B] font-bold text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="formatTime(timeLeft)">Berlaku selama 5:00</span>
        </div>

        <!-- QR Code Container -->
        <div class="bg-white p-4 rounded-3xl border-2 border-[#2D5A27]/10 shadow-inner mb-8 w-64 h-64 mx-auto flex items-center justify-center relative">
            <!-- QR Pattern Placeholder -->
            <div class="w-full h-full bg-[#2D5A27] opacity-10 absolute inset-0 rounded-2xl"></div>
            
            <!-- Actual QR (Placeholder SVG) -->
            <svg class="w-48 h-48 text-[#2D5A27]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 11h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v3h-3v-3zm-3 3h3v3h-3v-3zm3 3h3v3h-3v-3zm-6-3h3v3h-3v-3zm-3 3h3v3h-3v-3zM3 19h6v2H3v-2zm2 0v-2h-2v2h2zm2-2v-2h-2v2h2zm2 2v-2h-2v2h2zm-2-2h2v-2H7v2zm8 2h6v-2h-6v2zm2-2v-2h-2v2h2zm-2-2h2v-2h-2v2zm2 0v-2h-2v2h2zm-2-2h2v-2h-2v2z"/>
            </svg>
            
            <!-- Logo Overlay -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-white p-2 rounded-lg shadow-sm">
                    <span class="font-bold text-[#2D5A27] text-xs">QRIS</span>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <p class="text-gray-500 text-sm mb-8">Scan pakai aplikasi bank atau e-wallet favoritmu</p>

        <!-- Payment Icons -->
        <div class="flex justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all">
            <!-- Bank/Wallet Icons Placeholders -->
            <div class="w-8 h-8 bg-gray-200 rounded"></div>
            <div class="w-8 h-8 bg-gray-200 rounded"></div>
            <div class="w-8 h-8 bg-gray-200 rounded"></div>
        </div>

    </div>
    @elseif($order->payment_method == 'cash')
    <div class="bg-[#FDFDF7] w-full min-h-screen flex flex-col items-center justify-center text-center p-8 relative">
        
        <!-- Header Logo -->
        <div class="absolute top-8 left-8 flex items-center gap-2">
            <div class="w-8 h-8 bg-[#2D5A27] rounded-full flex items-center justify-center text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>
            <span class="font-bold text-[#2D5A27] tracking-tight">TANNYA CAFFE</span>
        </div>

        <!-- Main Content -->
        <div class="max-w-2xl mx-auto relative">
            
            <!-- Icon -->
            <div class="mb-12 relative inline-block">
                <div class="w-48 h-48 bg-white rounded-[3rem] shadow-xl flex items-center justify-center relative z-10 mx-auto">
                    <svg class="w-24 h-24 text-[#2D5A27]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 3H4v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5h-2V5h2v3zM4 19h16v2H4z"/>
                    </svg>
                </div>
                <!-- Badge -->
                <div class="absolute -top-4 -right-4 bg-[#00C853] w-12 h-12 rounded-full flex items-center justify-center border-4 border-[#FDFDF7] z-20 shadow-lg animate-bounce">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <!-- Status Pill -->
                <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-white px-4 py-2 rounded-full shadow-lg border border-gray-100 flex items-center gap-2 z-20 whitespace-nowrap">
                    <div class="w-2 h-2 bg-[#00C853] rounded-full animate-pulse"></div>
                    <span class="text-xs font-bold text-gray-500">Memproses...</span>
                </div>
            </div>

            <!-- Text -->
            <h1 class="text-4xl md:text-5xl font-bold text-[#2D5A27] mb-6 leading-tight">
                Tunggu bentar ya, kasir lagi cek pembayaranmu...
            </h1>
            <p class="text-gray-500 text-lg mb-12 max-w-lg mx-auto leading-relaxed">
                Yuk langsung ke kasir buat bayar pesananmu. Kopi kamu bakal mulai dibuat setelah dikonfirmasi.
            </p>

            <!-- Order Number Card -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 max-w-md mx-auto mb-12">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor Pesanan</div>
                <div class="text-3xl font-instrument font-bold text-[#1a3e2a] tracking-tight">
                    {{ $order->order_number }}
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-12 flex justify-center gap-8 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Estimasi Tunggu: 2-3 mnt
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#00C853]" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    Checkout Aman
                </div>
            </div>

        </div>
    </div>
    @endif

    <!-- Shared Back Button for QRIS (positioned absolutely at bottom) -->
    @if($order->payment_method == 'midtrans_qris')
    <div class="absolute bottom-8 w-full text-center">
        <a href="{{ route('customer.order') }}" class="inline-flex items-center text-gray-400 hover:text-gray-600 font-medium text-sm transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Batal & Kembali
        </a>
        <div class="mt-4 text-[10px] text-gray-400 uppercase tracking-widest">
            Terhubung Langsung Dengan Sistem Kasir
        </div>
    </div>
    @endif

    <script>
        function paymentProcess() {
            return {
                timeLeft: 300, // 5 minutes in seconds
                
                init() {
                    if ('{{ $order->payment_method }}' === 'midtrans_qris') {
                        this.startTimer();
                    }
                    this.pollStatus();
                },

                pollStatus() {
                    // Check status every 3 seconds
                    setInterval(() => {
                        // Only poll if not already paid
                        if ('{{ $order->payment_status }}' !== 'paid') {
                            fetch('{{ route("customer.orders.status", $order) }}')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.payment_status === 'paid') {
                                        window.location.reload();
                                    }
                                })
                                .catch(error => console.error('Error polling status:', error));
                        }
                    }, 3000);
                },

                startTimer() {
                    setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    return `Berlaku selama ${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
                }
            }
        }
    </script>
</body>
</html>