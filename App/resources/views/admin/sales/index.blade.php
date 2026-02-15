@extends('layouts.admin')

@section('title', 'Detail Penjualan')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-dark">Detail Penjualan</h2>
            <p class="text-gray-500 mt-1">Monitoring transaksi harian dan performa finansial.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-dark hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Struk
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity shadow-sm shadow-primary/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Ekspor CSV
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Gross Sales -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-green-50 text-primary text-[10px] font-bold rounded-lg">+14.2%</span>
                    </div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Gross Sales</p>
                    <h3 class="text-xl font-extrabold text-dark mt-1">Rp {{ number_format($totalGrossSales, 0, ',', '.') }}</h3>
                </div>

                <!-- Average Order Value -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-lg">+5.3%</span>
                    </div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Average Order Value</p>
                    <h3 class="text-xl font-extrabold text-dark mt-1">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                </div>

                <!-- Total Net Profit -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-red-50 text-secondary text-[10px] font-bold rounded-lg">+12.1%</span>
                    </div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Net Profit</p>
                    <h3 class="text-xl font-extrabold text-secondary mt-1">Rp {{ number_format($totalNetProfit, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Rentang Tanggal</label>
                    <div class="relative">
                        <input type="text" value="01 Okt 2023 - 07 Okt 2023" readonly class="w-full bg-gray-50 border-none rounded-xl py-2.5 pl-10 pr-4 text-sm font-medium text-dark focus:ring-2 focus:ring-primary/20 cursor-default">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="w-48">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Metode Bayar</label>
                    <select class="w-full bg-gray-50 border-none rounded-xl py-2.5 px-4 text-sm font-medium text-dark focus:ring-2 focus:ring-primary/20">
                        <option>Semua Metode</option>
                    </select>
                </div>
                <div class="w-48">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Kategori Produk</label>
                    <select class="w-full bg-gray-50 border-none rounded-xl py-2.5 px-4 text-sm font-medium text-dark focus:ring-2 focus:ring-primary/20">
                        <option>Semua Kategori</option>
                    </select>
                </div>
                <button class="p-2.5 bg-dark text-white rounded-xl hover:bg-opacity-90 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-dark">Riwayat Transaksi</h3>
                    <div class="relative w-64">
                        <input type="text" placeholder="Cari ID Pesanan..." class="w-full bg-gray-50 border-none rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Metode Bayar</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Total Bayar</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-dark">{{ $order->created_at->format('d Okt Y') }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium">{{ $order->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-primary font-mono">#{{ $order->order_number ?? 'TRX-' . substr($order->id, 0, 4) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-[10px] font-bold text-gray-600 rounded-md uppercase">{{ $order->order_type ?? 'Dine-in' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($order->payment_method == 'QRIS')
                                            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 0h2v3h-2v-3zm3 3h3v2h-3v-2zm-3 2h2v3h-2v-3zm3 3h3v2h-3v-2zm-3 0h2v3h-2v-3zm3-3h3v2h-3v-2zm-6-6h2v2h-2V7zm2 2h2v2h-2V9zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2z"/></svg>
                                        @elseif($order->payment_method == 'Tunai')
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                        @endif
                                        <span class="text-sm font-medium text-dark">{{ $order->payment_method ?? 'QRIS' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-extrabold text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $order->status == 'completed' || $order->status == 'SELESAI' ? 'bg-primary' : 'bg-red-500' }}"></div>
                                        <span class="text-[10px] font-extrabold {{ $order->status == 'completed' || $order->status == 'SELESAI' ? 'text-primary' : 'text-red-500' }} uppercase">{{ $order->status ?? 'SELESAI' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="p-1.5 text-gray-300 hover:text-dark transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <!-- Sample data if empty for demonstration as per image -->
                            @php
                                $samples = [
                                    ['date' => '07 Okt 2023', 'time' => '14:20', 'id' => 'TRX-9824', 'type' => 'Dine-in', 'method' => 'QRIS', 'total' => 124000, 'status' => 'SELESAI'],
                                    ['date' => '07 Okt 2023', 'time' => '14:05', 'id' => 'TRX-9823', 'type' => 'Takeaway', 'method' => 'Tunai', 'total' => 45000, 'status' => 'SELESAI'],
                                    ['date' => '07 Okt 2023', 'time' => '13:58', 'id' => 'TRX-9822', 'type' => 'Dine-in', 'method' => 'Debit', 'total' => 215500, 'status' => 'PENDING'],
                                    ['date' => '07 Okt 2023', 'time' => '13:45', 'id' => 'TRX-9821', 'type' => 'Dine-in', 'method' => 'QRIS', 'total' => 68000, 'status' => 'SELESAI'],
                                ];
                            @endphp
                            @foreach($samples as $sample)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-dark">{{ $sample['date'] }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium">{{ $sample['time'] }} WIB</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-primary font-mono">#{{ $sample['id'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 {{ $sample['type'] == 'Takeaway' ? 'bg-orange-50 text-orange-600' : 'bg-gray-100 text-gray-600' }} text-[10px] font-bold rounded-md uppercase">{{ $sample['type'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($sample['method'] == 'QRIS')
                                            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 0h2v3h-2v-3zm3 3h3v2h-3v-2zm-3 2h2v3h-2v-3zm3 3h3v2h-3v-2zm-3 0h2v3h-2v-3zm3-3h3v2h-3v-2zm-6-6h2v2h-2V7zm2 2h2v2h-2V9zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2z"/></svg>
                                        @elseif($sample['method'] == 'Tunai')
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                        @endif
                                        <span class="text-sm font-medium text-dark">{{ $sample['method'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-extrabold text-dark">Rp {{ number_format($sample['total'], 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $sample['status'] == 'SELESAI' ? 'bg-primary' : 'bg-red-500' }}"></div>
                                        <span class="text-[10px] font-extrabold {{ $sample['status'] == 'SELESAI' ? 'text-primary' : 'text-red-500' }} uppercase">{{ $sample['status'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="p-1.5 text-gray-300 hover:text-dark transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
                    <p class="text-xs font-medium text-gray-500">
                        Menampilkan <span class="text-dark font-bold">{{ $orders->count() ?: 4 }}</span> dari <span class="text-dark font-bold">{{ $orders->total() ?: '1.248' }}</span> transaksi
                    </p>
                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-dark hover:bg-gray-50 transition-colors disabled:opacity-50" {{ $orders->onFirstPage() ? 'disabled' : '' }}>Sebelumnya</button>
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-dark hover:bg-gray-50 transition-colors disabled:opacity-50" {{ !$orders->hasMorePages() ? 'disabled' : '' }}>Berikutnya</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Live Sales Feed -->
            <div class="bg-dark rounded-[32px] p-6 text-white relative overflow-hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold">Live Sales Feed</h3>
                    <div class="flex gap-1">
                        <div class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></div>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse($liveSalesFeed as $feed)
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/5">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-white/50 font-mono">#{{ $feed->order_number ?? 'TRX-' . substr($feed->id, 0, 4) }}</span>
                            <span class="text-[10px] font-bold text-primary">{{ $feed->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-sm font-bold truncate">
                            @foreach($feed->items as $item)
                                {{ $item->product->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </h4>
                        <p class="text-lg font-extrabold mt-1">Rp {{ number_format($feed->total_price, 0, ',', '.') }}</p>
                    </div>
                    @empty
                    <!-- Sample Feed -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/5">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-white/50 font-mono">#TRX-9824</span>
                            <span class="text-[10px] font-bold text-primary italic">Baru Saja</span>
                        </div>
                        <h4 class="text-sm font-bold truncate">Aren Latte, Donut...</h4>
                        <p class="text-lg font-extrabold mt-1">Rp 74.000</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/5">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-white/50 font-mono">#TRX-9823</span>
                            <span class="text-[10px] font-bold text-white/30">3m lalu</span>
                        </div>
                        <h4 class="text-sm font-bold truncate">Americano Hot</h4>
                        <p class="text-lg font-extrabold mt-1">Rp 22.000</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/5">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-white/50 font-mono">#TRX-9822</span>
                            <span class="text-[10px] font-bold text-white/30">12m lalu</span>
                        </div>
                        <h4 class="text-sm font-bold truncate">Matcha, Brownies</h4>
                        <p class="text-lg font-extrabold mt-1">Rp 165.000</p>
                    </div>
                    @endforelse
                </div>
                <button class="w-full mt-6 py-3 bg-white text-dark text-xs font-extrabold rounded-xl hover:bg-gray-100 transition-colors uppercase tracking-widest">
                    Buka Kasir POS
                </button>
            </div>

            <!-- Popular Products -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-tight">Paling Populer<br>(Mingguan)</h3>
                    <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center text-white shadow-lg shadow-secondary/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.25 2.25c-.75.75-.19 2 1.06 2H18.75m-12 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM18.75 15a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-6">
                    @forelse($popularProducts as $product)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8c0-3.31-2.69-6-6-6S6 4.69 6 8c0 3 2 3.5 3 5.5.5 1 .5 2.5.5 2.5h5s0-1.5.5-2.5c1-2 3-2.5 3-5.5Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm font-bold text-dark">{{ $product->name }}</h4>
                                <span class="text-xs font-bold text-gray-400">{{ $product->total_qty }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Sample Popular -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl">☕</div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm font-bold text-dark">Aren Latte</h4>
                                <span class="text-xs font-bold text-gray-400">458</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl">🍦</div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm font-bold text-dark">Matcha Ice</h4>
                                <span class="text-xs font-bold text-gray-400">312</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Insight Card -->
            <div class="bg-secondary rounded-[32px] p-6 text-white shadow-lg shadow-secondary/20">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold uppercase tracking-wider">Insight Keuntungan</h3>
                </div>
                <p class="text-xs leading-relaxed text-white/90">
                    Margin profit rata-rata naik <span class="font-bold">2.5%</span> sejak penggunaan bahan baku lokal minggu ini. Teruskan efisiensi operasional!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
