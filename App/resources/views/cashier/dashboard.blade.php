@extends('layouts.cashier')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
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
        
        <div class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($incomingOrders as $order)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
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
                    <button class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Konfirmasi Pembayaran
                    </button>
                    @else
                    <button class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform active:scale-95">
                        Proses Pesanan
                    </button>
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

        <div class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($processingOrders as $order)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
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

                <button class="w-full py-3 bg-white border-2 border-green-500 text-green-600 hover:bg-green-50 font-bold rounded-xl transition-all flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tandai Selesai
                </button>
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

        <div class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
            @forelse($readyOrders as $order)
            <div class="bg-green-50/50 p-5 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-shadow">
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

                <button class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all transform active:scale-95">
                    Selesaikan Pesanan
                </button>
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
</div>
@endsection
