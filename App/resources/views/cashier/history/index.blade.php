@extends('layouts.cashier')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 rounded-t-2xl">
        <div class="flex items-center gap-8">
            <h1 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h1>
        </div>

        <div class="flex items-center gap-6">
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

    <!-- Toolbar -->
    <div class="bg-white px-8 py-4 border-b border-gray-200 flex items-center justify-between">
        <!-- Search -->
        <div class="relative w-96">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <form action="{{ route('cashier.history') }}" method="GET">
                <input type="hidden" name="filter" value="{{ request('filter', 'today') }}">
                <input type="text" name="search" placeholder="Cari ID pesanan atau kasir..." value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all placeholder-gray-400">
            </form>
        </div>

        <!-- Filters -->
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('cashier.history', ['filter' => 'today', 'search' => request('search')]) }}" 
                   class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $filter === 'today' ? 'bg-green-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-200' }}">
                    Hari Ini
                </a>
                <a href="{{ route('cashier.history', ['filter' => 'week', 'search' => request('search')]) }}" 
                   class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $filter === 'week' ? 'bg-green-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-200' }}">
                    Minggu Ini
                </a>
                <a href="{{ route('cashier.history', ['filter' => 'month', 'search' => request('search')]) }}" 
                   class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors {{ $filter === 'month' ? 'bg-green-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-200' }}">
                    Bulan Ini
                </a>
            </div>

            <button class="flex items-center gap-2 px-4 py-2 bg-[#1A2F2B] text-white rounded-xl text-sm font-medium hover:bg-[#233B36] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-[#F8FAFC]">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#1A2F2B] text-white text-xs uppercase tracking-wider font-medium">
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">No. Pesanan</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Total Bayar</th>
                        <th class="px-6 py-4">Metode</th>
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800">{{ $order->created_at->format('H:i') }}</div>
                            <div class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-green-600">#{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if($order->order_type == 'dine_in')
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-sm text-gray-600">Dine-in (Meja {{ $order->table_number }})</span>
                                @else
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span class="text-sm text-gray-600">Takeaway</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $order->payment_method == 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                @if($order->payment_method == 'qris')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    QRIS
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    CASH
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $order->cashier->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('cashier.orders.receipt', $order) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-200 shadow-sm text-xs font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data transaksi ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Menampilkan <span class="font-bold">{{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }}</span> dari <span class="font-bold">{{ $orders->total() }}</span> transaksi
                </div>
                <div>
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <!-- Footer Stats -->
        <div class="mt-8 grid grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center gap-6">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalTransactions }} Pesanan</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center gap-6">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Total Omzet</p>
                    <h3 class="text-2xl font-bold text-green-600">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end text-xs text-gray-400 italic">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Terakhir diperbarui: {{ now()->format('H:i:s') }}
        </div>
    </div>
</div>
@endsection
