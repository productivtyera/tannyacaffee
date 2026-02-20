<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order - Tannya Caffe</title>
    
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
            background-color: #FDFDF7;
        }
        .font-instrument {
            font-family: 'Instrument Sans', sans-serif;
        }
        /* Hide scrollbar for category list */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="antialiased h-screen overflow-hidden flex flex-col" 
      x-data="orderSystem({{ Js::from($products) }}, {{ Js::from($categories) }})">

    <!-- Top Navigation / Header -->
    <header class="flex-none px-6 py-4 bg-[#FDFDF7] border-b border-[#E8E6E1] flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('customer.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-[#2D5A27] hover:bg-gray-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <a href="{{ route('customer.index') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="w-10 h-10 object-cover rounded-full shadow-xl">
                <div class="flex flex-col">
                    <span class="font-bold text-lg text-[#2D5A27] leading-none group-hover:text-[#1e3d1a] transition-colors">Tannya Caffe</span>
                    <span class="text-[10px] tracking-widest uppercase text-[#2D5A27]/60 font-bold mt-0.5">Curiosity in every cup</span>
                </div>
            </a>
        </div>

        <div class="flex-1 max-w-xl mx-8">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-[#2D5A27] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    x-model="search"
                    class="w-full pl-11 pr-4 py-3 rounded-full border border-gray-200 bg-white focus:border-[#2D5A27] focus:ring-1 focus:ring-[#2D5A27] outline-none transition shadow-sm text-sm" 
                    placeholder="Cari menu...">
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-sm">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs font-bold text-[#2D5A27]">Guest Mode</span>
            </div>
            
            <div class="flex items-center gap-2">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-gray-500">Kasir</p>
                    <p class="text-sm font-bold text-[#2D5A27]">{{ Auth::user()->name }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#2D5A27] text-white flex items-center justify-center font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex overflow-hidden">
        <!-- Left Side: Menu Selection -->
        <div class="flex-1 flex flex-col h-full overflow-hidden bg-[#FDFDF7]">
            
            <!-- Order Type Selector -->
            <div class="px-6 pt-6 pb-2">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Pilih Tipe Pesanan</h2>
                <div class="grid grid-cols-2 gap-4 bg-white p-1.5 rounded-2xl border border-gray-200 shadow-sm">
                    <button 
                        @click="orderType = 'takeaway'"
                        :class="{'bg-[#2D5A27] text-white shadow-md': orderType === 'takeaway', 'text-gray-500 hover:bg-gray-50': orderType !== 'takeaway'}"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl font-bold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Bungkus
                    </button>
                    <button 
                        @click="orderType = 'dine_in'"
                        :class="{'bg-[#2D5A27] text-white shadow-md': orderType === 'dine_in', 'text-gray-500 hover:bg-gray-50': orderType !== 'dine_in'}"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl font-bold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Makan di Sini
                    </button>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="px-6 py-4 overflow-x-auto no-scrollbar">
                <div class="flex gap-3">
                    <button 
                        @click="selectedCategory = null"
                        :class="{'bg-[#2D5A27] text-white border-[#2D5A27]': selectedCategory === null, 'bg-white text-[#2D5A27] border-gray-200 hover:border-[#2D5A27]': selectedCategory !== null}"
                        class="px-5 py-2 rounded-full border text-sm font-bold whitespace-nowrap transition-colors shadow-sm">
                        Semua Menu
                    </button>
                    <template x-for="category in categories" :key="category.id">
                        <button 
                            @click="selectedCategory = category.id"
                            :class="{'bg-[#2D5A27] text-white border-[#2D5A27]': selectedCategory === category.id, 'bg-white text-[#2D5A27] border-gray-200 hover:border-[#2D5A27]': selectedCategory !== category.id}"
                            class="px-5 py-2 rounded-full border text-sm font-bold whitespace-nowrap transition-colors shadow-sm"
                            x-text="category.name">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto px-6 pb-24">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full group">
                            <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 bg-gray-100">
                                <img :src="product.image_path ? '/storage/' + product.image_path : 'https://placehold.co/400x400?text=' + product.name" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                     :alt="product.name">
                            </div>
                            
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-[#2D5A27] text-lg leading-tight" x-text="product.name"></h3>
                                <div class="text-[#2D5A27] font-bold text-sm whitespace-nowrap" x-text="formatRupiah(product.base_price)"></div>
                            </div>
                            
                            <p class="text-gray-500 text-xs mb-4 line-clamp-2 flex-1" x-text="product.description || 'Nikmati rasa otentik yang tak terlupakan.'"></p>
                            
                            <button 
                                @click="addToCart(product)"
                                class="w-full py-2.5 bg-[#D32F2F] text-white rounded-xl font-bold hover:bg-red-700 transition flex items-center justify-center gap-2 shadow-lg shadow-red-500/20 active:scale-95 transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </template>
                    
                    <!-- Empty State -->
                    <div x-show="filteredProducts.length === 0" class="col-span-full py-12 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-lg font-medium">Menu tidak ditemukan</p>
                        <p class="text-sm">Coba cari dengan kata kunci lain</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Cart -->
        <div class="w-[400px] bg-white border-l border-[#E8E6E1] flex flex-col h-full shadow-xl relative z-10">
            <!-- Cart Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col gap-3 mb-1">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h2 class="font-bold text-sm text-[#2D5A27]">Pesanan Saya</h2>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span 
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                            :class="orderType === 'dine_in' ? 'bg-[#2D5A27] text-white' : 'bg-gray-100 text-gray-500'"
                            x-text="orderType === 'dine_in' ? 'DINE-IN' : 'TAKEAWAY'">
                        </span>
                        <div class="flex items-center gap-2 bg-[#FDFDF7] border rounded-lg px-3 py-1.5 transition-colors"
                             :class="showTableError ? 'border-red-500 ring-1 ring-red-500 bg-red-50' : 'border-[#E8E6E1]'">
                            <span class="text-[10px] font-bold uppercase tracking-wider" 
                                  :class="showTableError ? 'text-red-600' : 'text-[#2D5A27]'"
                                  x-text="orderType === 'dine_in' ? 'Meja #' : 'Nama'"></span>
                            <input type="text" 
                                   x-ref="tableInput"
                                   x-model="tableNumber" 
                                   @input="showTableError = false; if(orderType === 'dine_in') tableNumber = tableNumber.replace(/[^0-9]/g, '')"
                                   :placeholder="orderType === 'dine_in' ? '00' : 'Nama'"
                                   class="w-24 bg-transparent border-none p-0 text-sm font-bold focus:ring-0 text-right placeholder-gray-300"
                                   :class="showTableError ? 'text-red-700' : 'text-[#2D5A27]'">
                        </div>
                    </div>
                </div>
                <p class="text-xs italic transition-colors"
                   :class="showTableError ? 'text-red-500 font-bold' : 'text-gray-400'"
                   x-text="showTableError ? 'Mohon isi ' + (orderType === 'dine_in' ? 'nomor meja' : 'nama pemesan') : 'Guest Checkout • Cepat & Aman'">
                </p>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                            <img :src="item.product.image_path ? '/storage/' + item.product.image_path : 'https://placehold.co/100x100?text=' + item.product.name" 
                                 class="w-full h-full object-cover" 
                                 :alt="item.product.name">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-bold text-[#2D5A27] text-sm leading-tight" x-text="item.product.name"></h4>
                                <span class="font-bold text-[#2D5A27] text-sm" x-text="formatRupiah(item.product.base_price * item.quantity)"></span>
                            </div>
                            
                            <div class="flex justify-between items-end mt-2">
                                <div class="flex items-center bg-[#FDFDF7] rounded-lg border border-[#E8E6E1] p-1">
                                    <button @click="updateQuantity(index, -1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-[#D32F2F] hover:bg-red-50 rounded transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center text-xs font-bold text-[#2D5A27]" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(index, 1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-green-600 hover:bg-green-50 rounded transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <button @click="removeFromCart(index)" class="text-gray-300 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-full text-center py-10 opacity-50">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-gray-400 font-medium">Keranjang masih kosong</p>
                    <p class="text-xs text-gray-300">Pilih menu di samping untuk memesan</p>
                </div>
            </div>

            <!-- Cart Summary & Checkout -->
            <div class="p-6 bg-[#FDFDF7] border-t border-[#E8E6E1]">
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Subtotal</span>
                        <span class="font-medium" x-text="formatRupiah(subtotal)"></span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Biaya Layanan (10%)</span>
                        <span class="font-medium" x-text="formatRupiah(serviceCharge)"></span>
                    </div>
                    <div class="flex justify-between items-end pt-3 border-t border-gray-200">
                        <span class="font-bold text-lg text-[#2D5A27]">Total</span>
                        <span class="font-bold text-lg text-[#2D5A27]" x-text="formatRupiah(total)"></span>
                    </div>
                </div>

                <button 
                    @click="if(!tableNumber) { $refs.tableInput.focus(); showTableError = true; return; } showConfirmationModal = true;"
                    :disabled="cart.length === 0"
                    class="w-full py-4 bg-[#2D5A27] disabled:bg-gray-300 disabled:cursor-not-allowed text-white rounded-xl font-bold hover:bg-[#1e3d1a] transition flex items-center justify-center gap-2 shadow-lg shadow-green-900/20 active:scale-95 transform">
                    <span>Bayar Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
                
                <div class="mt-4 text-center">
                    <p class="text-[10px] text-gray-400 opacity-60">Made with love by Productivtyera</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div 
        x-show="showConfirmationModal" 
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div 
            class="bg-white rounded-[2rem] p-8 w-full max-w-sm text-center shadow-2xl relative overflow-hidden"
            @click.outside="showConfirmationModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-4">
            
            <!-- Icon -->
            <div class="w-16 h-16 bg-[#F5F8F2] rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>

            <!-- Title -->
            <h3 class="font-instrument font-bold text-xl text-[#1a1a1a] mb-2">
                Apa kamu yakin memesan ini?
            </h3>
            
            <!-- Description -->
            <p class="text-sm text-gray-500 mb-8 leading-relaxed px-4">
                Pastikan semua pesananmu sudah benar sebelum lanjut ke pembayaran.
            </p>

            <!-- Total Box -->
            <div class="bg-[#F5F8F2] rounded-2xl p-4 mb-8 border border-[#E8E6E1]">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">TOTAL PEMBAYARAN</p>
                <p class="font-instrument font-bold text-2xl text-[#2D5A27]" x-text="formatRupiah(total)"></p>
            </div>

            <!-- Buttons -->
            <div class="space-y-3">
                <button 
                    @click="processOrder()"
                    class="w-full py-3.5 bg-[#C62828] text-white rounded-xl font-bold hover:bg-[#B71C1C] transition shadow-lg shadow-red-900/20 active:scale-95 transform">
                    Ya, Pesan Sekarang!
                </button>
                
                <button 
                    @click="showConfirmationModal = false"
                    class="w-full py-3.5 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold hover:bg-gray-50 transition active:scale-95 transform">
                    Cek Lagi
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderSystem', (products, categories) => ({
                products: products,
                categories: categories,
                search: '',
                selectedCategory: null,
                cart: [],
                orderType: 'dine_in', // dine_in, takeaway
                tableNumber: '',
                showTableError: false,
                showConfirmationModal: false,

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const addProductId = urlParams.get('add_product_id');
                    
                    if (addProductId) {
                        const product = this.products.find(p => p.id == addProductId);
                        if (product) {
                            this.addToCart(product);
                            
                            // Clean up URL without reloading
                            const newUrl = window.location.pathname;
                            window.history.replaceState({}, document.title, newUrl);
                        }
                    }
                },

                get filteredProducts() {
                    return this.products.filter(product => {
                        const matchesSearch = product.name.toLowerCase().includes(this.search.toLowerCase());
                        const matchesCategory = this.selectedCategory === null || product.category_id === this.selectedCategory;
                        return matchesSearch && matchesCategory;
                    });
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.product.base_price * item.quantity), 0);
                },

                get total() {
                    return this.subtotal;
                },

                addToCart(product) {
                    const existingItem = this.cart.find(item => item.product.id === product.id);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.cart.push({
                            product: product,
                            quantity: 1
                        });
                    }
                },

                updateQuantity(index, change) {
                    if (this.cart[index].quantity + change > 0) {
                        this.cart[index].quantity += change;
                    } else {
                        this.removeFromCart(index);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                processOrder() {
                    fetch('{{ route('customer.pre-checkout') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart: this.cart,
                            orderType: this.orderType,
                            tableNumber: this.tableNumber
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(number);
                }
            }));
        });
    </script>
</body>
</html>
