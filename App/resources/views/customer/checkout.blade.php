<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Tannya Caffe</title>
    
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
            background-color: #FDFDF7; /* Cream background */
        }
        .font-instrument {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col" x-data="checkoutSystem()">

    <!-- Header -->
    <header class="px-8 py-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="w-10 h-10 object-cover rounded-full shadow-xl">
            <span class="font-bold text-xl text-[#2D5A27]"><span class="font-normal">Tannya</span>Caffe</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500">Checkout Guest</span>
            <div class="w-2 h-2 rounded-full bg-green-500"></div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 px-8 pb-12 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left Column: Order Summary -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 h-fit">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="font-bold text-xl text-[#2D5A27]">Pesanan Kamu</h2>
                </div>
                <div class="bg-gray-100 px-3 py-1 rounded-full text-xs font-bold text-gray-500 uppercase tracking-wider">
                    {{ count($cart) }} ITEM
                </div>
            </div>

            <!-- Table/Name Display -->
            <div class="mb-6 p-4 bg-[#F5F8F2] rounded-xl border border-[#E8E6E1] flex items-center justify-between">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">
                    {{ $orderType == 'dine_in' ? 'Meja' : 'Atas Nama' }}
                </span>
                <span class="font-instrument font-bold text-xl text-[#2D5A27]">
                    {{ $tableNumber }}
                </span>
            </div>

            <!-- Items List -->
            <div class="space-y-6 mb-8">
                @foreach($cart as $item)
                <div class="flex gap-4">
                    <div class="w-20 h-20 rounded-2xl bg-gray-100 overflow-hidden flex-shrink-0">
                         <img src="{{ isset($item['product']['image_path']) ? '/storage/' . $item['product']['image_path'] : 'https://placehold.co/100x100?text=' . $item['product']['name'] }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $item['product']['name'] }}">
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <h3 class="font-bold text-[#2D5A27] text-lg">{{ $item['product']['name'] }}</h3>
                        <p class="text-gray-400 text-sm">
                            {{-- Details like "Besar • Sedikit Gula" would go here if we had variants --}}
                            {{-- For now, maybe just category or description excerpt --}}
                             {{ \Illuminate\Support\Str::limit($item['product']['description'] ?? '', 30) }}
                        </p>
                        <div class="text-gray-400 text-sm mt-1">x{{ $item['quantity'] }}</div>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold text-[#2D5A27]">
                            Rp {{ number_format($item['product']['base_price'] * $item['quantity'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="border-t border-gray-100 pt-6 space-y-3">
                @php
                    $subtotal = collect($cart)->sum(fn($item) => $item['product']['base_price'] * $item['quantity']);
                    $tax = 0; // "dont add pajak"
                    $total = $subtotal + $tax;
                @endphp

                <div class="flex justify-between text-gray-400 text-sm">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                {{-- 
                <div class="flex justify-between text-gray-400 text-sm">
                    <span>Pajak & Servis (10%)</span>
                    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>
                --}}
                
                <div class="flex justify-between items-center pt-4">
                    <span class="font-bold text-lg text-[#2D5A27]">Total Bayar</span>
                    <span class="font-bold text-2xl text-[#2D5A27]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Method -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 h-fit">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <h2 class="font-bold text-xl text-[#2D5A27]">Pilih Cara Bayar</h2>
            </div>

            <!-- Payment Options -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <button 
                    @click="paymentMethod = 'midtrans_qris'"
                    :class="{'border-[#2D5A27] ring-1 ring-[#2D5A27] bg-[#F5F8F2]': paymentMethod === 'midtrans_qris', 'border-gray-200 hover:bg-gray-50': paymentMethod !== 'midtrans_qris'}"
                    class="p-6 rounded-2xl border transition-all duration-300 flex flex-col items-center gap-3 relative overflow-hidden">
                    <div 
                        :class="{'bg-[#2D5A27] text-white': paymentMethod === 'midtrans_qris', 'bg-gray-200 text-gray-500': paymentMethod !== 'midtrans_qris'}"
                        class="w-12 h-12 rounded-full flex items-center justify-center mb-1 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <div 
                            :class="{'text-[#2D5A27]': paymentMethod === 'midtrans_qris', 'text-gray-600': paymentMethod !== 'midtrans_qris'}"
                            class="font-bold">QRIS</div>
                        <div 
                            x-text="paymentMethod === 'midtrans_qris' ? 'TERPILIH' : 'NON-TUNAI'"
                            :class="{'text-[#2D5A27]': paymentMethod === 'midtrans_qris', 'text-gray-400': paymentMethod !== 'midtrans_qris'}"
                            class="text-[10px] font-bold uppercase tracking-widest"></div>
                    </div>
                </button>

                <button 
                    @click="paymentMethod = 'cash'"
                    :class="{'border-[#2D5A27] ring-1 ring-[#2D5A27] bg-[#F5F8F2]': paymentMethod === 'cash', 'border-gray-200 hover:bg-gray-50': paymentMethod !== 'cash'}"
                    class="p-6 rounded-2xl border transition-all duration-300 flex flex-col items-center gap-3 relative">
                    <div 
                        :class="{'bg-[#2D5A27] text-white': paymentMethod === 'cash', 'bg-gray-200 text-gray-500': paymentMethod !== 'cash'}"
                        class="w-12 h-12 rounded-full flex items-center justify-center mb-1 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <div 
                            :class="{'text-[#2D5A27]': paymentMethod === 'cash', 'text-gray-600': paymentMethod !== 'cash'}"
                            class="font-bold">Tunai</div>
                        <div 
                            x-text="paymentMethod === 'cash' ? 'TERPILIH' : 'DI KASIR'"
                            :class="{'text-[#2D5A27]': paymentMethod === 'cash', 'text-gray-400': paymentMethod !== 'cash'}"
                            class="text-[10px] font-bold uppercase tracking-widest"></div>
                    </div>
                </button>
            </div>

            <!-- QRIS Display -->
            <div x-show="paymentMethod === 'midtrans_qris'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-[#FAFAFA] rounded-3xl p-8 mb-8 border border-dashed border-gray-300 text-center">
                <p class="text-sm text-gray-500 mb-6">Scan kode QR di bawah pakai aplikasi bank atau e-wallet favoritmu.</p>
                
                <div class="w-48 h-48 mx-auto bg-white p-2 rounded-xl shadow-sm mb-6 relative">
                    <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center">
                        <!-- Placeholder QR -->
                         <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div class="absolute -top-3 -right-3 bg-[#00C853] text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                        QR DINAMIS
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-xs font-bold text-gray-400 italic">MENUNGGU PEMBAYARAN</span>
                </div>
            </div>

             <!-- Cash Display -->
             <div x-show="paymentMethod === 'cash'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-[#F5F5F5] rounded-[2rem] p-12 mb-8 text-center flex flex-col items-center justify-center">
                 
                 <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                     <svg class="w-12 h-12 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                     </svg>
                 </div>
                 
                <h3 class="text-lg font-bold text-[#1a3e2a] mb-2">Silakan lakukan pembayaran di kasir.</h3>
                <p class="text-sm text-gray-500 max-w-xs mx-auto mb-8 leading-relaxed">
                    Sebutkan nomor pesananmu atau tunjukkan layar ini ke tim kami.
                </p>

                <div class="bg-white px-8 py-4 rounded-xl shadow-sm border border-gray-100 inline-block">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-2">Nomor Pesanan:</span>
                    <span class="font-instrument font-bold text-2xl text-[#1a3e2a] tracking-tight">{{ $orderRef }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <form action="{{ route('customer.checkout.store') }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="payment_method" :value="paymentMethod">
                <button 
                    type="submit"
                    class="w-full py-4 bg-[#C62828] text-white rounded-xl font-bold hover:bg-[#B71C1C] transition shadow-lg shadow-red-900/20 active:scale-95 transform mb-4 flex items-center justify-center gap-2 group">
                    <span>Konfirmasi Pesanan</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </form>

            <a href="{{ route('customer.order') }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 transition">
                Batal & Kembali ke Menu
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center">
        <p class="text-xs text-[#2D5A27]/40">© 2024 Tannya Caffe. Hak cipta dilindungi undang-undang.</p>
        <div class="flex justify-center gap-4 mt-2 text-[#2D5A27]/40">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 14H9v-2h6v2zm0-3H9v-2h6v2zm0-3H9V8h6v2z"/></svg>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
        </div>
    </footer>

    <script>
        function checkoutSystem() {
            return {
                paymentMethod: 'midtrans_qris',
                
                init() {
                    // Init logic
                }
            }
        }
    </script>
</body>
</html>