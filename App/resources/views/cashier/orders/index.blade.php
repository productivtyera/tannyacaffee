@extends('layouts.cashier')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="flex flex-col h-full" x-data="ordersManager">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 rounded-t-2xl">
        <div class="flex items-center gap-8">
            <h1 class="text-xl font-bold text-gray-800">Daftar Pesanan</h1>
            
            <div class="flex bg-gray-100 rounded-lg p-1">
                <a href="{{ route('cashier.orders.index', ['tab' => 'active']) }}" 
                   class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $status !== 'completed' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Aktif
                </a>
                <a href="{{ route('cashier.orders.index', ['tab' => 'completed']) }}" 
                   class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $status === 'completed' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Selesai
                </a>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <form action="{{ route('cashier.orders.index') }}" method="GET">
                    <input type="hidden" name="tab" value="{{ $status }}">
                    <input type="text" name="search" placeholder="Cari pesanan..." value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 bg-gray-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-green-500 w-64 placeholder-gray-400">
                </form>
            </div>

            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-600 font-bold tracking-wider">SHIFT PAGI</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold border-2 border-green-500">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto p-8 space-y-6 bg-[#F8FAFC]">
        @forelse($orders as $order)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex">
                <!-- Left Side: Order Details & Items -->
                <div class="flex-1 p-6 border-r border-gray-100">
                    <!-- Order Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0
                                @if($order->payment_status == 'unpaid') bg-red-100 text-red-500
                                @elseif($order->status == 'pending') bg-green-100 text-green-500
                                @elseif($order->status == 'processing') bg-orange-100 text-orange-500
                                @elseif($order->status == 'ready') bg-blue-100 text-blue-500
                                @elseif($order->status == 'completed') bg-green-100 text-green-500
                                @else bg-gray-100 text-gray-500
                                @endif">
                                
                                @if($order->payment_status == 'unpaid')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($order->status == 'pending')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                @elseif($order->status == 'processing')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($order->status == 'ready')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                @elseif($order->status == 'completed')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div>
                                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1 block">
                                    ORDER {{ $order->order_number }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-800 leading-none">
                                    {{ $order->order_type == 'dine_in' ? 'Meja ' . $order->table_number : ($order->order_type == 'takeaway' ? 'Order ' . $order->table_number : "") }}
                                </h3>
                                <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                    @if($order->payment_status == 'unpaid')
                                        <span class="text-red-500 font-bold flex items-center gap-1">
                                            ! {{ $order->created_at->diffForHumans() }} (Belum Dibayar)
                                        </span>
                                    @else
                                        <span class="text-gray-500 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $order->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Price & Order Status Badge -->
                        <div class="text-right">
                             @if($order->payment_status == 'unpaid')
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-lg mb-2">
                                    MENUNGGU BAYAR
                                </span>
                            @elseif($order->status == 'processing')
                                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-lg mb-2">
                                    SEDANG DIMASAK
                                </span>
                            @elseif($order->status == 'ready')
                                 <span class="inline-block px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-lg mb-2">
                                    SIAP DIAMBIL
                                </span>
                            @elseif($order->status == 'completed')
                                 <span class="inline-block px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-lg mb-2">
                                    SELESAI
                                </span>
                            @else
                                 <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg mb-2">
                                    {{ strtoupper($order->status) }}
                                </span>
                            @endif
                            <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <table class="w-full">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider text-left">
                                    <th class="pb-3 w-16 pl-2">Qty</th>
                                    <th class="pb-3">Menu Item</th>
                                    <th class="pb-3">Catatan Khusus</th>
                                    <th class="pb-3 text-right pr-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <tr class="text-sm group hover:bg-white transition-colors">
                                        <td class="py-3 font-bold text-gray-600 pl-2">{{ $item->qty }}x</td>
                                        <td class="py-3 font-medium text-gray-900">{{ $item->product->name }}</td>
                                        <td class="py-3 text-red-400 italic">{{ $item->notes ?? '-' }}</td>
                                        <td class="py-3 text-right pr-2">
                                            <button 
                                                @click="openItemModal({{ json_encode([
                                                    'id' => $item->id,
                                                    'name' => $item->product->name,
                                                    'order_number' => $order->order_number,
                                                    'table_number' => $order->table_number ? 'Meja ' . $order->table_number : 'Takeaway',
                                                    'status' => $item->status
                                                ]) }})"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors
                                                @if($item->status == 'pending') bg-gray-200 text-gray-600 hover:bg-gray-300
                                                @elseif($item->status == 'processing') bg-orange-100 text-orange-600 hover:bg-orange-200
                                                @elseif($item->status == 'completed') bg-green-100 text-green-600 hover:bg-green-200
                                                @elseif($item->status == 'cancelled') bg-red-100 text-red-600 hover:bg-red-200
                                                @endif">
                                                
                                                @if($item->status == 'pending') Antrean
                                                @elseif($item->status == 'processing') Diproses
                                                @elseif($item->status == 'completed') Selesai
                                                @elseif($item->status == 'cancelled') Dibatalkan
                                                @endif
                                                
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Side: Actions -->
                <div class="w-64 bg-white p-6 flex flex-col gap-3 justify-center">
                    @if($order->status == 'pending')
                        @if($order->payment_status == 'unpaid')
                            @if($order->payment_method == 'cash')
                                <button type="button" @click="openPaymentModal({{ json_encode($order) }})" class="w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Konfirmasi Pembayaran
                                </button>
                            @else
                                <form action="{{ route('cashier.orders.confirm-payment', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-500/30">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Konfirmasi Pembayaran
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('cashier.orders.process', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-[#1A2F2B] hover:bg-[#233B36] text-white rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-[#1A2F2B]/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Proses Pesanan
                                </button>
                            </form>
                        @endif
                    @elseif($order->status == 'processing')
                        <form action="{{ route('cashier.orders.ready', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-orange-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Tandai Selesai
                            </button>
                        </form>
                    @elseif($order->status == 'ready')
                        <form action="{{ route('cashier.orders.complete', $order) }}" method="POST" onsubmit="return confirm('Selesaikan pesanan?')">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Selesaikan
                            </button>
                        </form>
                    @else
                         <button class="w-full px-4 py-3 bg-gray-100 text-gray-400 rounded-full font-semibold text-sm flex items-center justify-center gap-2 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Selesai
                        </button>
                    @endif

                    <a href="{{ route('cashier.orders.receipt', $order) }}" target="_blank" class="w-full px-4 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-full font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Struk
                    </a>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-96 text-gray-400">
                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-lg font-medium">Belum ada pesanan {{ $status == 'active' ? 'aktif' : 'selesai' }}</p>
            </div>
        @endforelse
    </div>

    <!-- Footer Stats -->
    <div class="bg-white border-t border-gray-200 px-8 py-4 flex items-center justify-between sticky bottom-0 z-20 rounded-b-2xl">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-sm font-medium text-gray-600">
                    <span class="font-bold text-gray-900">{{ $completedCount }}</span> Pesanan Selesai
                </span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                <span class="text-sm font-medium text-gray-600">
                    <span class="font-bold text-gray-900">{{ $activeCount }}</span> Sedang Aktif
                </span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <span class="text-sm font-medium text-gray-600">
                    <span class="font-bold text-gray-900">{{ $pendingPaymentCount }}</span> Menunggu Bayar
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-600">Total Penjualan:</span>
            <span class="text-lg font-bold text-green-600">Rp{{ number_format($totalSales, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Item Status Modal -->
    <div x-show="itemModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity backdrop-blur-sm" @click="closeItemModal"></div>

        <!-- Modal Panel -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Update Status Item</h3>
                            <div class="flex items-center gap-2 text-sm mt-1">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 font-bold rounded text-xs">ORDER #<span x-text="selectedItem?.order_number"></span></span>
                                <span class="text-gray-400">•</span>
                                <span class="font-medium text-gray-600" x-text="selectedItem?.table_number"></span>
                            </div>
                            <div class="mt-2 text-green-600 font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span x-text="selectedItem?.name"></span>
                            </div>
                        </div>
                        <button @click="closeItemModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">PILIH STATUS BARU</p>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Pending -->
                            <button @click="selectedStatus = 'pending'" 
                                    class="p-4 rounded-xl border-2 flex flex-col items-center gap-3 transition-all relative"
                                    :class="selectedStatus === 'pending' ? 'border-blue-100 bg-blue-50 ring-2 ring-blue-500 ring-offset-2' : 'border-gray-100 hover:border-gray-200'">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-gray-900">Pending</p>
                                    <p class="text-xs text-gray-500">Menunggu</p>
                                </div>
                                <div x-show="selectedStatus === 'pending'" class="absolute top-2 right-2 w-5 h-5 bg-blue-500 rounded-full text-white flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </button>

                            <!-- Processing -->
                            <button @click="selectedStatus = 'processing'"
                                    class="p-4 rounded-xl border-2 flex flex-col items-center gap-3 transition-all relative"
                                    :class="selectedStatus === 'processing' ? 'border-orange-100 bg-orange-50 ring-2 ring-orange-500 ring-offset-2' : 'border-gray-100 hover:border-gray-200'">
                                <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-gray-900">Processing</p>
                                    <p class="text-xs text-gray-500">Diproses</p>
                                </div>
                                <div x-show="selectedStatus === 'processing'" class="absolute top-2 right-2 w-5 h-5 bg-orange-500 rounded-full text-white flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </button>

                            <!-- Completed -->
                            <button @click="selectedStatus = 'completed'"
                                    class="p-4 rounded-xl border-2 flex flex-col items-center gap-3 transition-all relative"
                                    :class="selectedStatus === 'completed' ? 'border-green-100 bg-green-50 ring-2 ring-green-500 ring-offset-2' : 'border-gray-100 hover:border-gray-200'">
                                <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-gray-900">Completed</p>
                                    <p class="text-xs text-gray-500">Selesai</p>
                                </div>
                                <div x-show="selectedStatus === 'completed'" class="absolute top-2 right-2 w-5 h-5 bg-green-500 rounded-full text-white flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </button>

                            <!-- Cancelled -->
                            <button @click="selectedStatus = 'cancelled'"
                                    class="p-4 rounded-xl border-2 flex flex-col items-center gap-3 transition-all relative"
                                    :class="selectedStatus === 'cancelled' ? 'border-red-100 bg-red-50 ring-2 ring-red-500 ring-offset-2' : 'border-gray-100 hover:border-gray-200'">
                                <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-gray-900">Cancelled</p>
                                    <p class="text-xs text-gray-500">Dibatalkan</p>
                                </div>
                                <div x-show="selectedStatus === 'cancelled'" class="absolute top-2 right-2 w-5 h-5 bg-red-500 rounded-full text-white flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <form method="POST" :action="'{{ route('cashier.order-items.update-status', 'ITEM_ID') }}'.replace('ITEM_ID', selectedItem?.id)" class="w-full sm:w-auto">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" :value="selectedStatus">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-[#1A2F2B] text-base font-bold text-white hover:bg-[#233B36] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1A2F2B] sm:text-sm">
                            Simpan Perubahan
                        </button>
                    </form>
                    <button type="button" @click="closeItemModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-2.5 bg-gray-100 text-base font-bold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
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
document.addEventListener('alpine:init', () => {
    Alpine.data('ordersManager', () => ({
        timestamp: {{ time() }},
        itemModalOpen: false,
        selectedItem: null,
        selectedStatus: '',
        
        // Payment Modal State
        paymentModalOpen: false,
        paymentOrder: null,
        cashReceived: '',
        change: 0,
        quickAmounts: [],
        
        init() {
            // Poll for updates every 5 seconds
            setInterval(() => {
                this.checkUpdates();
            }, 5000);
        },
        
        async checkUpdates() {
            try {
                const response = await fetch(`{{ route('cashier.orders.check-new') }}?timestamp=${this.timestamp}`);
                const data = await response.json();
                
                if (data.should_update) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Polling error:', error);
            }
        },

        openItemModal(item) {
            this.selectedItem = item;
            this.selectedStatus = item.status;
            this.itemModalOpen = true;
        },

        closeItemModal() {
            this.itemModalOpen = false;
            setTimeout(() => {
                this.selectedItem = null;
                this.selectedStatus = '';
            }, 300);
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
