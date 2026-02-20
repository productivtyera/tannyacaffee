@extends('layouts.cashier')

@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full" x-data="dashboardPolling('{{ $stateHash }}')">
    <!-- Column 1: Pesanan Masuk -->
    <div class="flex flex-col h-full bg-gray-50 rounded-2xl border border-gray-100/50">
        <div class="p-4 bg-[#1A2F2B] text-white rounded-t-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="font-bold text-lg tracking-wide">Pesanan Masuk</h2>
            </div>
            <span class="bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg shadow-green-500/20">{{ $incomingOrders->count() }}</span>
        </div>
        
        <div id="incoming-list" data-status="pending" class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($incomingOrders as $order)
            <div data-id="{{ $order->id }}" data-payment-status="{{ $order->payment_status }}" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group {{ $order->payment_status == 'unpaid' ? 'unpaid-order cursor-not-allowed opacity-80' : 'cursor-grab active:cursor-grabbing' }}">
                @if($loop->first)
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 rounded-l-2xl"></div>
                @endif
                
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">ORDER #{{ $order->order_number }}</p>
                        <h3 class="font-bold text-xl text-gray-800">{{ $order->order_type == 'dine_in' ? 'Meja ' . ($order->table_number ?? '00') : 'Takeaway' }}</h3>
                    </div>
                    @if($order->payment_status == 'unpaid')
                    <span class="px-3 py-1 bg-orange-100 text-orange-600 text-[10px] font-bold rounded-full uppercase tracking-wide border border-orange-200">Menunggu Bayar</span>
                    @elseif($order->payment_status == 'paid')
                    <span class="px-3 py-1 bg-green-100 text-green-600 text-[10px] font-bold rounded-full uppercase tracking-wide border border-green-200">Lunas ({{ $order->payment_method }})</span>
                    @endif
                </div>

                <div class="space-y-3 mb-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-400">{{ $item->qty }}x</span>
                            <span class="text-gray-600 font-medium">{{ $item->product->name }}</span>
                        </div>
                        <span class="font-bold text-gray-800">Rp{{ number_format($item->qty * $item->unit_price, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-dashed border-gray-200">
                    @if($order->payment_method)
                    <div class="flex items-center gap-2 mb-4 text-xs font-medium text-gray-500 bg-gray-50 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Pembayaran: {{ ucfirst($order->payment_method) }}
                    </div>
                    @endif

                    @if($order->payment_status == 'unpaid')
                        @if($order->payment_method == 'cash')
                        <button type="button" @click="openPaymentModal({{ json_encode($order) }})" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Konfirmasi Pembayaran
                        </button>
                        @else
                        <form action="{{ route('cashier.orders.confirm-payment', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Konfirmasi Pembayaran
                            </button>
                        </form>
                        @endif
                    @else
                    <form action="{{ route('cashier.orders.process', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform active:scale-95">
                            Proses Pesanan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p>Tidak ada pesanan masuk</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Column 2: Sedang Diproses -->
    <div class="flex flex-col h-full bg-gray-50 rounded-2xl border border-gray-100/50">
        <div class="p-4 bg-[#1A2F2B] text-white rounded-t-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="font-bold text-lg tracking-wide">Sedang Diproses</h2>
            </div>
            <span class="bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg shadow-yellow-500/20">{{ $processingOrders->count() }}</span>
        </div>

        <div id="processing-list" data-status="processing" class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($processingOrders as $order)
            <div data-id="{{ $order->id }}" data-payment-status="{{ $order->payment_status }}" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-grab active:cursor-grabbing">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">ORDER #{{ $order->order_number }}</p>
                        <h3 class="font-bold text-xl text-gray-800">{{ $order->order_type == 'dine_in' ? 'Meja ' . ($order->table_number ?? '00') : 'Takeaway' }}</h3>
                    </div>
                    <span class="flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-bold rounded-full uppercase tracking-wide border border-yellow-100">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                        Memasak...
                    </span>
                </div>

                <div class="space-y-3 mb-6">
                    @foreach($order->items as $item)
                    <div class="flex items-start gap-3">
                        <span class="flex items-center justify-center w-5 h-5 rounded bg-green-100 text-green-600 text-xs font-bold">{{ $loop->iteration }}</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $item->product->name }}</p>
                            @if($item->notes)
                            <p class="text-xs text-gray-400 italic">{{ $item->notes }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <form action="{{ route('cashier.orders.ready', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-white border-2 border-green-500 text-green-600 hover:bg-green-50 font-bold rounded-xl transition-all flex items-center justify-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Tandai Selesai
                    </button>
                </form>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                <p>Tidak ada pesanan diproses</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Column 3: Siap Diambil -->
    <div class="flex flex-col h-full bg-gray-50 rounded-2xl border border-gray-100/50">
        <div class="p-4 bg-[#1A2F2B] text-white rounded-t-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h2 class="font-bold text-lg tracking-wide">Siap Diambil</h2>
            </div>
            <span class="bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg shadow-blue-500/20">{{ $readyOrders->count() }}</span>
        </div>

        <div id="ready-list" data-status="ready" class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($readyOrders as $order)
            <div data-id="{{ $order->id }}" data-payment-status="{{ $order->payment_status }}" class="bg-green-50/50 p-5 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-shadow cursor-grab active:cursor-grabbing">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-green-600/60 uppercase tracking-wider mb-1">ORDER #{{ $order->order_number }}</p>
                        <h3 class="font-bold text-xl text-gray-800">{{ $order->order_type == 'dine_in' ? 'Meja ' . ($order->table_number ?? '00') : 'Takeaway' }}</h3>
                    </div>
                    <div class="relative">
                        <span class="absolute -inset-1 bg-green-500 rounded-full opacity-20 animate-ping"></span>
                        <span class="relative px-3 py-1 bg-green-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wide shadow-lg shadow-green-500/30">
                            READY
                        </span>
                    </div>
                </div>

                <div class="space-y-2 mb-6 opacity-60">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800">{{ $item->qty }}x</span>
                            <span class="text-gray-600">{{ $item->product->name }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <form action="{{ route('cashier.orders.complete', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all transform active:scale-95">
                        Selesaikan Pesanan
                    </button>
                </form>
            </div>
            @empty
             <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                <p>Tidak ada pesanan siap</p>
            </div>
            @endforelse
            
            <!-- Empty State Illustration Placeholder if needed -->
            <div class="hidden border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-sm text-gray-400 font-medium">Tidak ada pesanan lain</p>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div x-show="paymentModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-white/30 backdrop-blur-md transition-opacity" @click="closePaymentModal"></div>

        <!-- Modal Panel -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <!-- Header -->
                <div class="bg-white px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Pembayaran Tunai
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Order #<span x-text="paymentOrder?.order_number"></span> • 
                            <span x-text="paymentOrder?.order_type == 'dine_in' ? 'Meja ' + paymentOrder?.table_number : 'Takeaway'"></span>
                        </p>
                    </div>
                    <button @click="closePaymentModal" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bg-gray-50 px-4 py-6 sm:p-6">
                    <!-- Total -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm mb-6">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL YANG HARUS DIBAYAR</p>
                        <div class="flex justify-between items-end">
                            <p class="text-3xl font-bold text-gray-900" x-text="formatCurrency(paymentOrder?.total_price || 0)"></p>
                            <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-lg" x-text="(paymentOrder?.items?.length || 0) + ' items'"></span>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Uang Dibayar
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                            <input type="text" 
                                   x-model="cashReceived" 
                                   @input="updateChange"
                                   class="w-full pl-10 pr-4 py-4 bg-white border-2 border-gray-200 rounded-xl text-2xl font-bold text-gray-900 focus:border-green-500 focus:ring-0 transition-colors"
                                   placeholder="0">
                        </div>

                        <!-- Quick Amounts -->
                        <div class="flex gap-2 mt-3 overflow-x-auto pb-2 custom-scrollbar">
                            <template x-for="amount in quickAmounts" :key="amount">
                                <button @click="setCashAmount(amount)" 
                                        class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors whitespace-nowrap"
                                        x-text="formatCurrency(amount)">
                                </button>
                            </template>
                             <button @click="setCashAmount(paymentOrder?.total_price)" 
                                    class="px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg text-sm font-bold text-green-600 hover:bg-green-100 transition-colors whitespace-nowrap">
                                Uang Pas
                            </button>
                        </div>
                    </div>

                    <!-- Change -->
                    <div class="bg-[#1A2F2B] rounded-xl p-5 text-white mb-6 relative overflow-hidden">
                        <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-[#233B36] to-transparent opacity-50"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">KEMBALIAN</p>
                            <p class="text-3xl font-bold" x-text="formatCurrency(change)"></p>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>

                    <!-- Actions -->
                    <form method="POST" :action="'{{ route('cashier.orders.confirm-payment', 'ORDER_ID') }}'.replace('ORDER_ID', paymentOrder?.id)">
                        @csrf
                        <input type="hidden" name="amount_paid" :value="cashReceived">
                        <button type="submit" 
                                :disabled="change < 0"
                                class="w-full py-4 bg-[#1A2F2B] hover:bg-[#233B36] disabled:bg-gray-300 disabled:cursor-not-allowed text-white rounded-xl font-bold text-lg shadow-lg shadow-[#1A2F2B]/30 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            KONFIRMASI & CETAK STRUK
                        </button>
                    </form>
                    <p class="text-xs text-center text-gray-400 mt-4">Pastikan uang yang diterima sudah sesuai sebelum konfirmasi.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('print_receipt_url'))
<script>
    window.open("{{ session('print_receipt_url') }}", "_blank");
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const containers = [
            document.getElementById('incoming-list'),
            document.getElementById('processing-list'),
            document.getElementById('ready-list')
        ];

        const statusHierarchy = {
            'pending': 1,
            'processing': 2,
            'ready': 3,
            'completed': 4
        };

        containers.forEach(container => {
            if (!container) return;
            
            new Sortable(container, {
                group: 'orders',
                animation: 150,
                filter: '.unpaid-order', // Filter unpaid orders
                preventOnFilter: false,
                draggable: '> div', // Only drag direct children divs (the cards)
                onEnd: function (evt) {
                    const item = evt.item;
                    const fromContainer = evt.from;
                    const toContainer = evt.to;
                    
                    if (fromContainer === toContainer) return;

                    const orderId = item.dataset.id;
                    const newStatus = toContainer.dataset.status;
                    const oldStatus = fromContainer.dataset.status;
                    const paymentStatus = item.dataset.paymentStatus;

                    // Double check payment status (although filter should handle it)
                    if (paymentStatus === 'unpaid') {
                        fromContainer.insertBefore(item, fromContainer.children[evt.oldIndex]);
                        alert('Pesanan belum dibayar tidak dapat dipindahkan.');
                        return;
                    }
                    
                    // Check hierarchy
                    if (statusHierarchy[newStatus] <= statusHierarchy[oldStatus]) {
                        // Revert
                        if (fromContainer.children[evt.oldIndex]) {
                            fromContainer.insertBefore(item, fromContainer.children[evt.oldIndex]);
                        } else {
                            fromContainer.appendChild(item);
                        }
                        alert('Tidak dapat memindahkan ke status sebelumnya.');
                        return;
                    }

                    // Send update request
                    fetch(`/cashier/orders/${orderId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Terjadi kesalahan');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Status updated:', data.message);
                        // Optional: show success toast or notification
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message);
                        // Revert on error
                        if (fromContainer.children[evt.oldIndex]) {
                            fromContainer.insertBefore(item, fromContainer.children[evt.oldIndex]);
                        } else {
                            fromContainer.appendChild(item);
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardPolling', (initialHash) => ({
            currentHash: initialHash,
            interval: null,
            
            // Payment Modal State
            paymentModalOpen: false,
            paymentOrder: null,
            cashReceived: '',
            change: 0,
            quickAmounts: [],

            init() {
                // Poll every 5 seconds
                this.interval = setInterval(() => {
                    this.checkUpdates();
                }, 5000);
            },

            destroy() {
                if (this.interval) {
                    clearInterval(this.interval);
                }
            },

            async checkUpdates() {
                try {
                    const response = await fetch('{{ route("cashier.orders.check-updates") }}?current_hash=' + this.currentHash);
                    const data = await response.json();
                    
                    if (data.should_reload) {
                        // Optional: Add a subtle loading indicator or toast before reload
                        console.log('New updates found, reloading...');
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Polling error:', error);
                }
            },

            // Payment Modal Logic
            openPaymentModal(order) {
                this.paymentOrder = order;
                this.cashReceived = '';
                this.change = -order.total_price;
                this.generateQuickAmounts(order.total_price);
                this.paymentModalOpen = true;
            },

            closePaymentModal() {
                this.paymentModalOpen = false;
                setTimeout(() => {
                    this.paymentOrder = null;
                    this.cashReceived = '';
                    this.change = 0;
                }, 300);
            },

            generateQuickAmounts(total) {
                const amounts = [
                    Math.ceil(total / 10000) * 10000,
                    Math.ceil(total / 20000) * 20000,
                    Math.ceil(total / 50000) * 50000,
                    Math.ceil(total / 100000) * 100000,
                ];
                
                // Filter unique and greater or equal to total
                this.quickAmounts = [...new Set(amounts)].filter(a => a >= total).sort((a, b) => a - b).slice(0, 3);
            },

            setCashAmount(amount) {
                this.cashReceived = amount;
                this.updateChange();
            },

            updateChange() {
                const total = this.paymentOrder ? this.paymentOrder.total_price : 0;
                const cashString = String(this.cashReceived).replace(/\D/g, '');
                const cash = parseInt(cashString) || 0;
                
                this.cashReceived = cashString ? parseInt(cashString) : '';
                this.change = cash - total;
            },

            formatCurrency(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
            }
        }));
    });
</script>
@endsection
