@extends('layouts.admin')

@section('title', 'Manajemen Inventori')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-[#1a2b3c]">Manajemen Stok</h2>
            <p class="text-gray-500 mt-1">Kelola ketersediaan bahan baku dan pantau penggunaan harian.</p>
        </div>
        <div class="flex items-center gap-4">
            <!-- Total Bahan -->
            <div class="bg-white px-6 py-4 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-[#f0f9f4] rounded-2xl flex items-center justify-center text-[#2ecc71]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-none">Total Bahan</p>
                    <h3 class="text-xl font-black text-dark mt-1">{{ $totalItems }} Items</h3>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="bg-[#fff5f5] px-6 py-4 rounded-[1.5rem] shadow-sm border border-[#fee2e2] flex items-center gap-4">
                <div class="w-12 h-12 bg-[#fee2e2] rounded-2xl flex items-center justify-center text-[#e74c3c]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-[#e74c3c] uppercase tracking-wider leading-none">Stok Menipis</p>
                    <h3 class="text-xl font-black text-[#e74c3c] mt-1">{{ $lowStockCount }} Bahan</h3>
                </div>
            </div>

            <!-- Tambah Bahan -->
            <button onclick="toggleModal(true)" class="bg-[#2ecc71] text-white rounded-[1.5rem] px-8 py-4 flex items-center gap-2 text-sm font-black shadow-lg shadow-[#2ecc71]/20 hover:bg-[#27ae60] transition-all h-[72px]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>Tambah Bahan</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Inventory List -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Search & Filters -->
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <form action="{{ route('admin.inventory') }}" method="GET" class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama bahan baku..." class="w-full bg-[#f8f9fa] border-none rounded-xl px-12 py-3.5 text-sm focus:ring-2 focus:ring-primary/20">
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    @if(request('search'))
                        <a href="{{ route('admin.inventory') }}" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <th class="px-8 py-6">Nama Bahan</th>
                                <th class="py-6 text-center">Unit</th>
                                <th class="py-6 text-center">Stok Saat Ini</th>
                                <th class="py-6 text-center">Batas Min.</th>
                                <th class="py-6 text-center">Harga / Unit</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($stocks as $stock)
                            @php
                                $isLow = $stock->current_stock <= $stock->min_stock_alert;
                                $isCritical = $stock->current_stock <= ($stock->min_stock_alert / 2);
                            @endphp
                            <tr class="group {{ $isLow ? 'bg-[#fff5f5]' : 'hover:bg-gray-50/50' }} transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 {{ $isLow ? 'bg-red-100 text-secondary' : 'bg-[#fef4e9] text-[#f39c12]' }} rounded-2xl flex items-center justify-center">
                                            @if(Str::contains(strtolower($stock->name), ['kopi', 'coffee', 'arabika', 'robusta']))
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                            @elseif(Str::contains(strtolower($stock->name), ['milk', 'susu', 'creamer', 'oat']))
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-[15px] font-extrabold text-[#1a2b3c] leading-tight">{{ $stock->name }}</p>
                                            @if($isCritical)
                                                <span class="text-[10px] font-black text-secondary uppercase tracking-tighter">KRITIS</span>
                                            @elseif($isLow)
                                                <span class="text-[10px] font-black text-secondary uppercase tracking-tighter">PERLU RESTOCK</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 text-sm font-medium text-gray-400 text-center">
                                    {{ $stock->measure_unit }}
                                </td>
                                <td class="py-5 text-[15px] font-black {{ $isLow ? 'text-secondary' : 'text-[#1a2b3c]' }} text-center">
                                    {{ (float)$stock->current_stock == (int)$stock->current_stock ? number_format($stock->current_stock, 0, ',', '.') : rtrim(rtrim(number_format($stock->current_stock, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td class="py-5 text-[15px] font-bold text-gray-300 text-center">
                                    {{ (float)$stock->min_stock_alert == (int)$stock->min_stock_alert ? number_format($stock->min_stock_alert, 0, ',', '.') : rtrim(rtrim(number_format($stock->min_stock_alert, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td class="py-5 text-center">
                                    <div class="text-[13px] font-bold text-gray-400">Rp</div>
                                    <div class="text-[15px] font-black {{ $isLow ? 'text-secondary' : 'text-[#1a2b3c]' }}">{{ number_format($stock->price_per_unit, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- Edit Button -->
                                        <button onclick="editStock('{{ $stock->id }}')" class="text-gray-400 hover:text-primary transition-colors p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <!-- Adjustment Button -->
                                        <button onclick="openAdjustModal('{{ $stock->id }}')" class="w-12 h-12 rounded-[1.25rem] bg-[#f0f9f4] flex items-center justify-center text-[#2ecc71] hover:bg-[#e2f4ea] transition-all group">
                                            <div class="w-6 h-6 border-2 border-[#2ecc71] rounded-md flex items-center justify-center relative overflow-hidden">
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <div class="w-full h-[1px] bg-[#2ecc71] rotate-[-45deg]"></div>
                                                </div>
                                                <span class="absolute top-0 left-0.5 text-[8px] font-bold leading-none">-</span>
                                                <span class="absolute bottom-0 right-0.5 text-[8px] font-bold leading-none">+</span>
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-[#fcfcfc] border-t border-gray-50 flex justify-between items-center">
                    <p class="text-[13px] font-bold text-gray-400">Menampilkan {{ $stocks->firstItem() }}-{{ $stocks->lastItem() }} dari {{ $stocks->total() }} bahan</p>
                    <div class="flex gap-2">
                        @if($stocks->onFirstPage())
                            <span class="w-9 h-9 rounded-xl border border-gray-100 flex items-center justify-center text-gray-200 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></span>
                        @else
                            <a href="{{ $stocks->previousPageUrl() }}" class="w-9 h-9 rounded-xl border border-gray-100 flex items-center justify-center text-gray-400 hover:bg-gray-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></a>
                        @endif

                        @foreach($stocks->getUrlRange(1, $stocks->lastPage()) as $page => $url)
                            @if($page == $stocks->currentPage())
                                <span class="w-9 h-9 rounded-xl bg-[#2ecc71] text-white flex items-center justify-center text-[13px] font-black shadow-lg shadow-[#2ecc71]/20">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="w-9 h-9 rounded-xl border border-gray-100 flex items-center justify-center text-[13px] font-bold text-gray-400 hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($stocks->hasMorePages())
                            <a href="{{ $stocks->nextPageUrl() }}" class="w-9 h-9 rounded-xl border border-gray-100 flex items-center justify-center text-gray-400 hover:bg-gray-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a>
                        @else
                            <span class="w-9 h-9 rounded-xl border border-gray-100 flex items-center justify-center text-gray-200 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Panel -->
        <div class="space-y-8">
            <!-- Recent Activity -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="text-xl font-black text-[#1a2b3c]">Aktivitas Stok Terbaru</h4>
                    <button class="text-gray-300 hover:text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </button>
                </div>

                <div class="space-y-8">
                    @forelse($recentActivities as $activity)
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center 
                            {{ $activity->type == 'created' ? 'bg-[#f0f9f4] text-[#2ecc71]' : ($activity->type == 'adjustment' ? 'bg-orange-50 text-orange-500' : 'bg-blue-50 text-blue-600') }}">
                            @if($activity->type == 'created')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            @elseif($activity->type == 'adjustment')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h5 class="text-sm font-black text-[#1a2b3c] truncate">
                                    {{ $activity->type == 'created' ? 'Bahan Baru' : ($activity->type == 'adjustment' ? 'Penyesuaian Stok' : 'Pembaruan Bahan') }}
                                </h5>
                                <span class="text-[10px] font-bold text-gray-300 uppercase whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                                <span class="font-bold text-[#1a2b3c]">{{ $activity->stock->name }}</span> 
                                @if($activity->type == 'created')
                                    telah ditambahkan ke sistem
                                @elseif($activity->type == 'adjustment')
                                    @php
                                        $adjType = $activity->changes['type'] ?? '';
                                        $adjLabel = $adjType === 'in' ? 'ditambah' : 'dikurangi';
                                        $adjColor = $adjType === 'in' ? 'text-[#2ecc71]' : 'text-secondary';
                                    @endphp
                                    {{ $adjLabel }} 
                                    <span class="font-black {{ $adjColor }}">
                                        {{ $adjType === 'in' ? '+' : '-' }}{{ (float)($activity->changes['amount'] ?? 0) == (int)($activity->changes['amount'] ?? 0) ? number_format($activity->changes['amount'] ?? 0, 0, ',', '.') : rtrim(rtrim(number_format($activity->changes['amount'] ?? 0, 3, ',', '.'), '0'), ',') }}{{ $activity->stock->measure_unit }}
                                    </span>
                                @else
                                    telah diperbarui
                                    @if($activity->changes)
                                        <span class="block text-[10px] text-gray-300 mt-1">
                                            Perubahan: {{ implode(', ', array_keys($activity->changes)) }}
                                        </span>
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-400">Belum ada aktivitas stok.</p>
                    </div>
                    @endforelse
                </div>

                <button class="w-full mt-10 bg-white border border-gray-100 text-[#1a2b3c] rounded-2xl py-4 text-sm font-black shadow-sm hover:bg-gray-50 transition-all">
                    Lihat Semua Riwayat
                </button>
            </div>

            <!-- Inventory Value Card -->
            <div class="bg-[#2ecc71] p-8 rounded-[2.5rem] shadow-xl shadow-[#2ecc71]/20 text-white relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 13v-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2v2a2 2 0 002 2h4a2 2 0 002-2v-2z" /></svg>
                        </div>
                        <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-wider">Estimasi</span>
                    </div>
                    
                    <p class="text-sm font-bold text-white/80">Nilai Total Aset Bahan</p>
                    <h3 class="text-3xl font-black mt-1">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
                    
                    <div class="mt-8 pt-8 border-t border-white/10 flex justify-between items-center">
                        <p class="text-[11px] font-bold text-white/60">Diperbarui {{ now()->format('H:i') }} WIB</p>
                        <div class="flex items-center gap-1 text-[11px] font-black">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            <span>2.4% MoM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Bahan -->
<div id="stockModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="toggleModal(false)"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="stockForm" action="{{ route('admin.inventory.store') }}" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    <div class="bg-white px-8 pb-8 pt-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 id="modalTitle" class="text-2xl font-black text-[#1a2b3c]">Tambah Bahan Baru</h3>
                                <p id="modalDescription" class="text-sm text-gray-500 mt-1">Masukkan detail bahan baku baru untuk inventaris.</p>
                            </div>
                            <button type="button" onclick="toggleModal(false)" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label for="name" class="block text-sm font-bold text-[#1a2b3c] mb-2">Nama Bahan</label>
                                <input type="text" name="name" id="name" placeholder="Contoh: Powder Matcha Premium" required
                                    class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 transition-all">
                            </div>

                            <div>
                                <label for="measure_unit" class="block text-sm font-bold text-[#1a2b3c] mb-2">Satuan Unit</label>
                                <div class="relative">
                                    <select name="measure_unit" id="measure_unit" required
                                         class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 appearance-none transition-all">
                                         <option value="g">Gram (g)</option>
                                         <option value="ml">Mililiter (ml)</option>
                                         <option value="pcs">Pcs</option>
                                         <option value="btl">Btl</option>
                                         <option value="kg">Kg</option>
                                         <option value="litter">Litter</option>
                                     </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-6 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="price_per_unit" class="block text-sm font-bold text-[#1a2b3c] mb-2">Harga per Unit</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-4 text-sm font-bold text-gray-400">Rp</span>
                                    <input type="number" name="price_per_unit" id="price_per_unit" placeholder="0" required min="0"
                                        class="w-full bg-[#f8f9fa] border-none rounded-2xl pl-14 pr-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 transition-all font-bold">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label id="stockLabel" for="current_stock" class="block text-sm font-bold text-[#1a2b3c] mb-2">Stok Awal</label>
                                    <input type="number" name="current_stock" id="current_stock" placeholder="0" required min="0" step="any"
                                        class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 transition-all font-bold text-center">
                                </div>
                                <div>
                                    <label for="min_stock_alert" class="block text-sm font-bold text-[#1a2b3c] mb-2">Batas Minimum</label>
                                    <input type="number" name="min_stock_alert" id="min_stock_alert" placeholder="0" required min="0" step="any"
                                        class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 transition-all font-bold text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 pb-10 pt-2 flex gap-4">
                        <button type="button" onclick="toggleModal(false)"
                            class="flex-1 bg-white border border-gray-100 text-[#1a2b3c] rounded-2xl py-4 text-sm font-black hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 bg-[#144521] text-white rounded-2xl py-4 text-sm font-black shadow-lg shadow-[#144521]/20 hover:bg-[#0d2e16] transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                            <span id="submitButtonText">Simpan Bahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penyesuaian Stok -->
<div id="adjustModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="toggleAdjustModal(false)"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <form id="adjustForm" method="POST">
                    @csrf
                    <div class="bg-white px-8 pb-8 pt-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-[#1a2b3c]">Penyesuaian Stok</h3>
                                <p class="text-sm text-gray-500 mt-1">Update inventaris Tannya Caffe</p>
                            </div>
                            <button type="button" onclick="toggleAdjustModal(false)" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Pilih Barang -->
                            <div>
                                <label class="block text-sm font-bold text-[#1a2b3c] mb-2">Pilih Barang</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <input type="text" id="adjust_item_name" readonly
                                        class="w-full bg-[#f8f9fa] border-none rounded-2xl pl-10 pr-4 py-4 text-sm font-bold text-[#1a2b3c] cursor-default focus:ring-0">
                                </div>
                            </div>

                            <!-- Tipe Penyesuaian -->
                            <div>
                                <label class="block text-sm font-bold text-[#1a2b3c] mb-2">Tipe Penyesuaian</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="type" value="in" class="peer sr-only" checked>
                                        <div class="flex flex-col items-center justify-center p-4 bg-[#f8f9fa] rounded-2xl border-2 border-transparent peer-checked:border-[#2ecc71] peer-checked:bg-[#f0f9f4] transition-all group">
                                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mb-2 shadow-sm text-[#2ecc71]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                            </div>
                                            <span class="text-[10px] font-black text-gray-500 group-peer-checked:text-[#2ecc71] uppercase tracking-tighter">Stok Masuk</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="type" value="out" class="peer sr-only">
                                        <div class="flex flex-col items-center justify-center p-4 bg-[#f8f9fa] rounded-2xl border-2 border-transparent peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all group">
                                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mb-2 shadow-sm text-orange-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                            </div>
                                            <span class="text-[10px] font-black text-gray-500 group-peer-checked:text-orange-500 uppercase tracking-tighter">Stok Keluar</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="type" value="waste" class="peer sr-only">
                                        <div class="flex flex-col items-center justify-center p-4 bg-[#f8f9fa] rounded-2xl border-2 border-transparent peer-checked:border-secondary peer-checked:bg-red-50 transition-all group">
                                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mb-2 shadow-sm text-secondary">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </div>
                                            <span class="text-[10px] font-black text-gray-500 group-peer-checked:text-secondary uppercase tracking-tighter">Waste</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Jumlah -->
                                <div>
                                    <label class="block text-sm font-bold text-[#1a2b3c] mb-2">Jumlah</label>
                                    <div class="flex items-center bg-[#f8f9fa] rounded-2xl p-1">
                                        <button type="button" onclick="adjustValue(-1)" class="w-12 h-12 flex items-center justify-center text-[#2ecc71] hover:bg-white rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                        </button>
                                        <input type="number" name="amount" id="adjust_amount" value="1" min="0.01" step="0.01" required
                                            class="flex-1 bg-transparent border-none text-center font-black text-lg focus:ring-0">
                                        <button type="button" onclick="adjustValue(1)" class="w-12 h-12 flex items-center justify-center text-[#2ecc71] hover:bg-white rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Satuan -->
                                <div>
                                    <label class="block text-sm font-bold text-[#1a2b3c] mb-2">Satuan</label>
                                    <div class="w-full bg-[#f0f9f4] border-2 border-[#2ecc71]/10 rounded-2xl px-4 py-4 text-sm font-bold text-[#2ecc71] text-center">
                                        <span id="adjust_unit_display">Pcs / Unit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <label class="block text-sm font-bold text-[#1a2b3c] mb-2">Keterangan / Alasan</label>
                                <textarea name="reason" rows="3" placeholder="Contoh: Barista menumpahkan susu saat steaming, atau Restock mingguan..."
                                    class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-[#2ecc71]/20 transition-all resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 pb-10 pt-2 flex gap-4">
                        <button type="button" onclick="toggleAdjustModal(false)"
                            class="flex-1 bg-white border border-gray-100 text-[#1a2b3c] rounded-2xl py-4 text-sm font-black hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 bg-[#2ecc71] text-white rounded-2xl py-4 text-sm font-black shadow-lg shadow-[#2ecc71]/20 hover:bg-[#27ae60] transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleModal(show, mode = 'create') {
    const modal = document.getElementById('stockModal');
    const form = document.getElementById('stockForm');
    const methodField = document.getElementById('methodField');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const submitButtonText = document.getElementById('submitButtonText');
    const stockLabel = document.getElementById('stockLabel');

    if (show) {
        if (mode === 'create') {
            form.action = "{{ route('admin.inventory.store') }}";
            methodField.innerHTML = '';
            modalTitle.innerText = 'Tambah Bahan Baru';
            modalDescription.innerText = 'Masukkan detail bahan baku baru untuk inventaris.';
            submitButtonText.innerText = 'Simpan Bahan';
            stockLabel.innerText = 'Stok Awal';
            form.reset();
        } else {
            modalTitle.innerText = 'Edit Bahan';
            modalDescription.innerText = 'Perbarui detail bahan baku inventaris.';
            submitButtonText.innerText = 'Perbarui Bahan';
            stockLabel.innerText = 'Stok Saat Ini';
        }
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

async function editStock(id) {
    toggleModal(true, 'edit');
    const form = document.getElementById('stockForm');
    const methodField = document.getElementById('methodField');
    
    // Set form action and method
    form.action = `/admin/inventory/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

    try {
        const response = await fetch(`/admin/inventory/${id}`);
        const data = await response.json();

        // Fill form fields
        document.getElementById('name').value = data.name;
        document.getElementById('measure_unit').value = data.measure_unit;
        document.getElementById('price_per_unit').value = data.price_per_unit;
        document.getElementById('current_stock').value = data.current_stock;
        document.getElementById('min_stock_alert').value = data.min_stock_alert;
    } catch (error) {
        console.error('Error fetching stock data:', error);
        alert('Gagal mengambil data bahan.');
        toggleModal(false);
    }
}

function toggleAdjustModal(show) {
    const modal = document.getElementById('adjustModal');
    if (show) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('adjustForm').reset();
    }
}

async function openAdjustModal(id) {
    toggleAdjustModal(true);
    const form = document.getElementById('adjustForm');
    form.action = `/admin/inventory/${id}/adjust`;

    try {
        const response = await fetch(`/admin/inventory/${id}`);
        const data = await response.json();

        document.getElementById('adjust_item_name').value = data.name;
        document.getElementById('adjust_unit_display').innerText = data.measure_unit;
        document.getElementById('adjust_amount').value = 1;
    } catch (error) {
        console.error('Error fetching stock data:', error);
        alert('Gagal mengambil data bahan.');
        toggleAdjustModal(false);
    }
}

function adjustValue(delta) {
    const input = document.getElementById('adjust_amount');
    let val = parseFloat(input.value) || 0;
    val = Math.max(0.01, val + delta);
    input.value = val;
}
</script>
@endsection
