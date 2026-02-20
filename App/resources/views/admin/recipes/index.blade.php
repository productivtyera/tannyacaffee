@extends('layouts.admin')

@section('title', 'Manajemen Resep & HPP')

@section('content')
<div class="space-y-8" x-data="recipeManager()">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-[#1a2b3c]">Manajemen Resep & HPP Produk</h2>
            <p class="text-gray-500 mt-1">Kelola komposisi bahan baku dan kalkulasi biaya setiap produk.</p>
        </div>
        <div class="flex items-center gap-4">
            <button @click="showImportModal = true" class="bg-white text-gray-700 border border-gray-200 rounded-[1.25rem] px-6 py-3.5 flex items-center gap-2 text-sm font-bold shadow-sm hover:bg-gray-50 transition-all h-[60px]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                <span>Import Resep</span>
            </button>
            <a href="{{ route('admin.recipes.export') }}" class="bg-white text-gray-700 border border-gray-200 rounded-[1.25rem] px-6 py-3.5 flex items-center gap-2 text-sm font-bold shadow-sm hover:bg-gray-50 transition-all h-[60px]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                <span>Export Resep</span>
            </a>
            <button @click="openModal()" class="bg-[#2D5A27] text-white rounded-[1.25rem] px-6 py-3.5 flex items-center gap-2 text-sm font-bold shadow-lg shadow-[#2D5A27]/20 hover:bg-[#23461e] transition-all h-[60px]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>Tambah Produk Baru</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Sidebar: Product List -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Search -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
                <form action="{{ route('admin.recipes.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu atau kategori..." class="w-full bg-[#f8f9fa] border-none rounded-2xl px-12 py-4 text-sm focus:ring-2 focus:ring-primary/20">
                    <svg class="w-5 h-5 absolute left-4 top-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </form>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-sm font-black text-[#1a2b3c] uppercase tracking-wider">Daftar Menu</h4>
                        <span class="bg-gray-50 text-gray-400 text-[10px] font-black px-3 py-1 rounded-full border border-gray-100 uppercase">{{ $products->count() }} Produk</span>
                    </div>

                    <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($products as $product)
                            <div onclick="window.location='{{ route('admin.recipes.show', $product->id) }}'" 
                               class="flex items-center gap-4 p-4 rounded-3xl transition-all cursor-pointer {{ $selectedProduct && $selectedProduct->id === $product->id ? 'bg-[#f0f9f4] border-2 border-[#2D5A27]/10' : 'hover:bg-gray-50 border-2 border-transparent' }}">
                                <div class="relative">
                                    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3f4f6&color=a1a1aa' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-14 h-14 rounded-2xl object-cover bg-gray-100">
                                    @if($product->is_available)
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-[#2ecc71] border-2 border-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-[15px] font-bold text-[#1a2b3c] truncate">{{ $product->name }}</h5>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                </div>
                                <div class="text-gray-300" onclick="event.stopPropagation()">
                                    <form action="{{ route('admin.recipes.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content: Recipe Detail -->
        <div class="lg:col-span-8">
            @if($selectedProduct)
                <div class="space-y-8">
                    <!-- Product Header Card -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50 relative overflow-hidden">
                        <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                            <img src="{{ $selectedProduct->image_path ? asset('storage/' . $selectedProduct->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedProduct->name) . '&background=f3f4f6&color=a1a1aa' }}" 
                                 alt="{{ $selectedProduct->name }}" 
                                 class="w-32 h-32 rounded-[2rem] object-cover bg-gray-50 shadow-inner">
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-3xl font-black text-[#1a2b3c]">{{ $selectedProduct->name }}</h3>
                                    <span class="bg-[#f0f9f4] text-[#2ecc71] text-[10px] font-black px-3 py-1 rounded-full border border-[#2ecc71]/10 uppercase">AKTIF</span>
                                </div>
                                <p class="text-gray-400 font-medium">Kategori: <span class="text-[#1a2b3c] font-bold">{{ $selectedProduct->category->name ?? 'Uncategorized' }}</span> • Cold/Hot Beverage</p>
                            @if($selectedProduct->description)
                                <p class="text-gray-500 text-sm mt-2">{{ $selectedProduct->description }}</p>
                            @endif
                            </div>

                            <div class="flex gap-3">
                                <button class="p-3 text-gray-400 hover:text-gray-600 border border-gray-100 rounded-2xl transition-all" title="Export Resep">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    <span class="sr-only">Export Resep</span>
                                </button>
                                <button @click="openModal({{ json_encode($selectedProduct) }}, {{ json_encode($selectedProduct->recipes->map(function($r) { return ['stock_id' => $r->stock_id, 'amount_needed' => $r->amount_needed, 'stock' => $r->stock]; })) }})" class="bg-[#2D5A27] text-white rounded-2xl px-6 py-3 flex items-center gap-2 text-sm font-bold shadow-lg shadow-[#2D5A27]/10 hover:bg-[#23461e] transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    <span>Edit Resep</span>
                                </button>
                            </div>
                        </div>

                        <!-- Recipe Table -->
                        <div class="mt-12 overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                        <th class="pb-6">Nama Bahan</th>
                                        <th class="pb-6 text-center">Jumlah Dibutuhkan</th>
                                        <th class="pb-6 text-center">Satuan</th>
                                        <th class="pb-6 text-right">Biaya HPP (Satuan)</th>
                                        <th class="pb-6 text-right">Subtotal HPP</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($selectedProduct->recipes as $recipe)
                                        <tr class="group hover:bg-gray-50/50 transition-colors">
                                            <td class="py-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                                    </div>
                                                    <span class="text-[15px] font-bold text-[#1a2b3c]">{{ $recipe->stock->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-6 text-center text-[15px] font-black text-[#1a2b3c]">
                                                {{ (float)$recipe->amount_needed == (int)$recipe->amount_needed ? number_format($recipe->amount_needed, 0, ',', '.') : rtrim(rtrim(number_format($recipe->amount_needed, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                            <td class="py-6 text-center">
                                                <span class="bg-gray-50 text-gray-400 text-[10px] font-black px-3 py-1 rounded-md border border-gray-100 uppercase">{{ $recipe->stock->measure_unit }}</span>
                                            </td>
                                            <td class="py-6 text-right">
                                                <span class="text-xs font-bold text-gray-300 mr-1">Rp</span>
                                                <span class="text-[15px] font-bold text-gray-400">{{ number_format($recipe->stock->price_per_unit, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="py-6 text-right">
                                                <span class="text-xs font-bold text-[#1a2b3c] mr-1">Rp</span>
                                                <span class="text-[15px] font-black text-[#1a2b3c]">{{ number_format($recipe->amount_needed * $recipe->stock->price_per_unit, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-gray-400 font-medium">Belum ada resep untuk produk ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Financial Summary Bar -->
                    <div class="bg-[#0f172a] rounded-[2.5rem] p-8 text-white flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl shadow-slate-900/20">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                        
                        <div class="flex flex-col md:flex-row items-center gap-12 relative z-10">
                            <div class="text-center md:text-left">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total HPP Produk</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-bold text-slate-400">Rp</span>
                                    <span class="text-4xl font-black">{{ (float)$selectedProduct->total_hpp == (int)$selectedProduct->total_hpp ? number_format($selectedProduct->total_hpp, 0, ',', '.') : rtrim(rtrim(number_format($selectedProduct->total_hpp, 2, ',', '.'), '0'), ',') }}</span>
                                </div>
                            </div>
                            
                            <div class="hidden md:block w-px h-12 bg-slate-800"></div>
                            
                            <div class="text-center md:text-left">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Jual</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-bold text-slate-400">Rp</span>
                                    <span class="text-4xl font-black">{{ (float)$selectedProduct->base_price == (int)$selectedProduct->base_price ? number_format($selectedProduct->base_price, 0, ',', '.') : rtrim(rtrim(number_format($selectedProduct->base_price, 2, ',', '.'), '0'), ',') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 relative z-10">
                            <div class="bg-[#1e293b] rounded-3xl px-6 py-4 border border-slate-800 flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#2D5A27]/20 rounded-xl flex items-center justify-center text-[#2ecc71]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Margin: {{ number_format($selectedProduct->margin, 1) }}%</p>
                                    <p class="text-xs font-bold text-slate-500 mt-0.5">Gross Profit: Rp {{ (float)$selectedProduct->gross_profit == (int)$selectedProduct->gross_profit ? number_format($selectedProduct->gross_profit, 0, ',', '.') : rtrim(rtrim(number_format($selectedProduct->gross_profit, 2, ',', '.'), '0'), ',') }}</p>
                                </div>
                            </div>

                            <button class="w-14 h-14 bg-[#2D5A27] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#2D5A27]/20 hover:bg-[#23461e] transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-[2.5rem] border-2 border-dashed border-gray-100 p-20 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-200 mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#1a2b3c] mb-2">Pilih Produk</h3>
                    <p class="text-gray-400 max-w-xs">Pilih salah satu produk di samping untuk melihat rincian resep dan kalkulasi HPP.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Import Modal -->
    <div x-show="showImportModal" 
         x-cloak
         class="fixed inset-0 z-[110] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showImportModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showImportModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showImportModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-middle bg-white rounded-[2.5rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form action="{{ route('admin.recipes.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-8 pt-10 pb-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-[#1a2b3c]">Import Resep</h3>
                                <p class="text-sm text-gray-500 mt-1">Pilih file CSV untuk mengimpor data produk dan resep.</p>
                            </div>
                            <button type="button" @click="showImportModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <div class="border-2 border-dashed border-gray-200 rounded-[2rem] p-10 text-center">
                                <input type="file" name="file" id="import_file" class="hidden" accept=".csv" required @change="importFileName = $event.target.files[0].name">
                                <label for="import_file" class="cursor-pointer">
                                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-[#1a2b3c]" x-text="importFileName || 'Klik untuk pilih file CSV'"></p>
                                    <p class="text-xs text-gray-400 mt-1">Format: Product Name, Category, Base Price, Ingredient Name, Amount Needed, Unit</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 pb-10 pt-2 flex gap-4">
                        <button type="button" @click="showImportModal = false" class="flex-1 bg-white border border-gray-100 text-[#1a2b3c] rounded-2xl py-4 text-sm font-black hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-[#2D5A27] text-white rounded-2xl py-4 text-sm font-black shadow-lg shadow-[#2D5A27]/20 hover:bg-[#23461e] transition-all">
                            Mulai Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Recipe Configuration Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-[60] overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
            
            <div class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                
                <div class="p-8 md:p-12">
                    <!-- Step 1: Basic Data -->
                    <div x-show="step === 1">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-[#1a2b3c]">Tambah Produk Baru</h3>
                                <p class="text-gray-400 text-sm mt-1">Lengkapi data dasar sebelum mengatur resep.</p>
                            </div>
                            <button @click="closeModal()" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Image Upload -->
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">FOTO PRODUK (OPSIONAL)</label>
                                <div class="relative group">
                                    <input type="file" @change="handleImageUpload" class="hidden" id="product-image" accept="image/*">
                                    <label for="product-image" class="cursor-pointer block">
                                        <div class="w-full h-48 border-2 border-dashed border-gray-100 rounded-[2rem] flex flex-col items-center justify-center bg-gray-50/50 hover:bg-gray-50 hover:border-[#2D5A27]/20 transition-all overflow-hidden relative">
                                            <template x-if="!productForm.imagePreview">
                                                <div class="text-center">
                                                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-gray-300 mb-4 mx-auto group-hover:text-[#2D5A27] transition-colors">
                                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    </div>
                                                    <p class="text-sm font-bold text-[#1a2b3c]">Unggah foto produk</p>
                                                    <p class="text-[10px] text-gray-400 font-medium mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                                                </div>
                                            </template>
                                            <template x-if="productForm.imagePreview">
                                                <img :src="productForm.imagePreview" class="w-full h-full object-cover">
                                            </template>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">NAMA PRODUK</label>
                                <input type="text" x-model="productForm.name" placeholder="Contoh: Iced Caramel Macchiato" class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-[#2D5A27]/20">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">KATEGORI</label>
                                <div class="relative">
                                    <select x-model="productForm.category_id" class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-[#2D5A27]/20 appearance-none">
                                        <option value="">Pilih Kategori</option>
                                        <template x-for="category in categories" :key="category.id">
                                            <option :value="category.id" x-text="category.name"></option>
                                        </template>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">DESKRIPSI (OPSIONAL)</label>
                                <textarea x-model="productForm.description" placeholder="Contoh: Kopi dengan rasa caramel..." class="w-full bg-[#f8f9fa] border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-[#2D5A27]/20 resize-none h-24"></textarea>
                            </div>

                            <div class="pt-6">
                                <button @click="nextStep()" 
                                        :disabled="loading"
                                        class="w-full bg-[#2D5A27] text-white rounded-[1.5rem] py-5 font-bold flex items-center justify-center gap-2 hover:bg-[#23461e] transition-all shadow-xl shadow-[#2D5A27]/20 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <template x-if="!loading">
                                        <div class="flex items-center gap-2">
                                            <span>Lanjut ke Resep</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </div>
                                    </template>
                                    <template x-if="loading">
                                        <div class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Memproses...</span>
                                        </div>
                                    </template>
                                </button>
                                <p class="text-[9px] text-center text-gray-300 font-black uppercase tracking-widest mt-6">DATA INI DAPAT DIUBAH KEMBALI DI PENGATURAN PRODUK</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Recipe Configuration -->
                    <div x-show="step === 2">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-[#1a2b3c]">Konfigurasi Resep</h3>
                                <p class="text-gray-400 text-sm mt-1">Atur komposisi bahan baku untuk produk ini</p>
                            </div>
                            <button @click="closeModal()" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Selected Product Info -->
                        <div class="bg-[#f0f9f4] rounded-3xl p-5 mb-8 flex items-center gap-4 border border-[#2D5A27]/5">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#2D5A27] shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-[#2D5A27] uppercase tracking-widest">Produk Terpilih</p>
                                <h4 class="text-lg font-bold text-[#1a2b3c]" x-text="selectedProduct?.name || 'Pilih Produk'"></h4>
                            </div>
                        </div>

                        <!-- Add Ingredient Form -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-10">
                            <div class="md:col-span-7 relative">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Bahan Baku</label>
                                <div class="relative">
                                    <input type="text" 
                                           x-model="searchStock" 
                                           @focus="showStockDropdown = true"
                                           @click.away="showStockDropdown = false"
                                           placeholder="Cari stok (e.g. Arabica, Fresh Milk)" 
                                           class="w-full bg-[#f8f9fa] border-none rounded-2xl px-12 py-4 text-sm focus:ring-2 focus:ring-[#2D5A27]/20">
                                    <svg class="w-5 h-5 absolute left-4 top-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                                
                                <!-- Stock Dropdown -->
                                <div x-show="showStockDropdown && filteredStocks.length > 0" 
                                     class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                                    <template x-for="stock in filteredStocks" :key="stock.id">
                                        <button @click="selectStock(stock)" 
                                                class="w-full text-left px-5 py-4 hover:bg-[#f0f9f4] transition-all flex items-center justify-between group border-b border-gray-50 last:border-0">
                                            <div>
                                                <p class="text-sm font-bold text-[#1a2b3c]" x-text="stock.name"></p>
                                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter" x-text="stock.measure_unit"></p>
                                            </div>
                                            <div class="text-[10px] font-black text-[#2D5A27] bg-[#f0f9f4] px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-all">PILIH</div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Jumlah</label>
                                <input type="number" 
                                       x-model="amountToAdd" 
                                       step="any"
                                       class="w-full bg-[#f8f9fa] border-none rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-[#2D5A27]/20 text-center">
                            </div>
                            <div class="md:col-span-2 flex items-end">
                                <button @click="addIngredient()" 
                                        class="w-full h-[52px] bg-[#0f172a] text-white rounded-2xl flex items-center justify-center hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Current Composition -->
                        <div class="mb-10">
                            <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 ml-1">Komposisi Saat Ini</h5>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="(item, index) in currentRecipe" :key="index">
                                    <div class="bg-white border border-gray-100 rounded-3xl p-4 flex items-center gap-4 group hover:border-[#2D5A27]/20 transition-all">
                                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-[#1a2b3c]" x-text="item.stock.name"></p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <input type="number" 
                                                       x-model="item.amount_needed" 
                                                       step="any"
                                                       class="w-16 bg-transparent border-none p-0 text-xs font-black text-[#2D5A27] focus:ring-0"
                                                       @input="calculateSummary()">
                                                <span class="text-[10px] text-gray-300 font-black uppercase tracking-widest" x-text="item.stock.measure_unit"></span>
                                                <span class="text-gray-200">•</span>
                                                <span class="text-[10px] text-gray-300 font-bold" x-text="'Rp ' + formatNumber(item.stock.price_per_unit)"></span>
                                            </div>
                                        </div>
                                        <button @click="removeIngredient(index)" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <div x-show="currentRecipe.length === 0" class="text-center py-10 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100">
                                    <p class="text-sm text-gray-400 font-medium">Belum ada bahan baku ditambahkan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Summary & Actions -->
                        <div class="pt-10 border-t border-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                                <div class="bg-gray-50 rounded-3xl p-6">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total HPP</p>
                                    <h4 class="text-2xl font-black text-[#1a2b3c]" x-text="'Rp ' + formatNumber(estimatedHpp)"></h4>
                                </div>
                                <div class="bg-[#2D5A27]/5 rounded-3xl p-6 border border-[#2D5A27]/10">
                                    <p class="text-[10px] font-black text-[#2D5A27] uppercase tracking-widest mb-1">Harga Jual</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl font-black text-[#2D5A27]">Rp</span>
                                        <input type="number" 
                                               x-model="productForm.base_price" 
                                               @input="calculateSummary()"
                                               class="w-full bg-transparent border-none p-0 text-xl font-black text-[#2D5A27] focus:ring-0 placeholder-gray-300"
                                               placeholder="0">
                                    </div>
                                </div>
                                <div class="rounded-3xl p-6 transition-colors" :class="estimatedMargin >= 0 ? 'bg-green-50' : 'bg-red-50'">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Margin</p>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-2xl font-black" :class="estimatedMargin >= 0 ? 'text-green-600' : 'text-red-600'" 
                                            x-text="'Rp ' + formatNumber(productForm.base_price - estimatedHpp)"></h4>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" 
                                              :class="estimatedMargin >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                              x-text="estimatedMargin.toFixed(1) + '%'"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button @click="step = 1" class="flex-1 bg-white border border-gray-200 text-gray-700 rounded-2xl py-4 font-bold hover:bg-gray-50 transition-all">Kembali</button>
                                <button @click="saveRecipe()" 
                                        :disabled="loading"
                                        class="flex-[2] bg-[#2D5A27] text-white rounded-2xl py-4 px-12 font-bold flex items-center justify-center gap-2 hover:bg-[#23461e] transition-all shadow-xl shadow-[#2D5A27]/20 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <template x-if="!loading">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                                            <span>Simpan Resep & Harga</span>
                                        </div>
                                    </template>
                                    <template x-if="loading">
                                        <div class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Menyimpan...</span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function recipeManager() {
        return {
            showModal: false,
            showImportModal: false,
            importFileName: '',
            step: 1,
            selectedProduct: null,
            currentRecipe: [],
            stocks: @json($stocks),
            categories: @json($categories),
            searchStock: '',
            showStockDropdown: false,
            amountToAdd: 0,
            selectedStock: null,
            estimatedHpp: 0,
            estimatedMargin: 0,
            loading: false,
            
            productForm: {
                name: '',
                category_id: '',
                base_price: 0,
                description: '',
                image: null,
                imagePreview: null
            },

            openModal(product = null, recipe = []) {
                if (product) {
                    this.selectedProduct = product;
                    this.currentRecipe = [...recipe];
                    this.productForm.name = product.name;
                    this.productForm.category_id = product.category_id;
                    this.productForm.base_price = product.base_price;
                    this.productForm.description = product.description || '';
                    this.step = 2; // Go straight to recipe if editing
                } else {
                    this.selectedProduct = null;
                    this.currentRecipe = [];
                    this.step = 1; // Start at basic data if new
                    this.resetProductForm();
                }
                this.showModal = true;
                this.calculateSummary();
            },

            resetProductForm() {
                this.productForm = {
                    name: '',
                    category_id: '',
                    base_price: 0,
                    description: '',
                    image: null,
                    imagePreview: null
                };
            },

            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.productForm.image = file;
                    this.productForm.imagePreview = URL.createObjectURL(file);
                }
            },

            async nextStep() {
                if (this.step === 1) {
                    if (!this.productForm.name || !this.productForm.category_id) {
                        alert('Mohon lengkapi data produk.');
                        return;
                    }

                    this.loading = true;
                    // Save product first
                    const formData = new FormData();
                    formData.append('name', this.productForm.name);
                    formData.append('category_id', this.productForm.category_id);
                    formData.append('description', this.productForm.description);
                    // base_price removed from step 1
                    if (this.productForm.image) {
                        formData.append('image', this.productForm.image);
                    }

                    try {
                        let response;
                        if (this.selectedProduct) {
                            // Update existing product
                            formData.append('_method', 'PUT');
                            response = await axios.post(`/admin/recipes/${this.selectedProduct.id}`, formData, {
                                headers: { 'Content-Type': 'multipart/form-data' }
                            });
                        } else {
                            // Create new product
                            response = await axios.post('/admin/recipes', formData, {
                                headers: { 'Content-Type': 'multipart/form-data' }
                            });
                        }
                        
                        if (response.data.success) {
                            // Update selectedProduct with latest data
                            if (response.data.product) {
                                this.selectedProduct = response.data.product;
                            }
                            this.step = 2;
                        }
                    } catch (error) {
                        console.error('Error creating product:', error);
                        alert('Gagal membuat produk. Pastikan semua data terisi dengan benar.');
                    } finally {
                        this.loading = false;
                    }
                }
            },

            closeModal() {
                this.showModal = false;
                this.searchStock = '';
                this.amountToAdd = 0;
                this.selectedStock = null;
            },

            get filteredStocks() {
                if (this.searchStock === '') return [];
                return this.stocks.filter(stock => 
                    stock.name.toLowerCase().includes(this.searchStock.toLowerCase()) &&
                    !this.currentRecipe.find(r => r.stock_id === stock.id)
                );
            },

            selectStock(stock) {
                this.selectedStock = stock;
                this.searchStock = stock.name;
                this.showStockDropdown = false;
            },

            addIngredient() {
                if (!this.selectedStock || this.amountToAdd <= 0) return;

                this.currentRecipe.push({
                    stock_id: this.selectedStock.id,
                    amount_needed: this.amountToAdd,
                    stock: this.selectedStock
                });

                this.selectedStock = null;
                this.searchStock = '';
                this.amountToAdd = 0;
                this.calculateSummary();
            },

            removeIngredient(index) {
                this.currentRecipe.splice(index, 1);
                this.calculateSummary();
            },

            calculateSummary() {
                this.estimatedHpp = this.currentRecipe.reduce((total, item) => {
                    return total + (item.amount_needed * item.stock.price_per_unit);
                }, 0);

                if (this.productForm.base_price > 0) {
                    this.estimatedMargin = ((this.productForm.base_price - this.estimatedHpp) / this.productForm.base_price) * 100;
                } else {
                    this.estimatedMargin = 0;
                }
            },

            async saveRecipe() {
                if (!this.selectedProduct) return;

                if (this.currentRecipe.length === 0) {
                    alert('Mohon tambahkan setidaknya satu bahan.');
                    return;
                }

                if (!this.productForm.base_price || this.productForm.base_price <= 0) {
                    alert('Mohon masukkan harga jual yang valid.');
                    return;
                }

                this.loading = true;
                try {
                    await axios.put(`/admin/recipes/${this.selectedProduct.id}`, {
                        base_price: this.productForm.base_price,
                        description: this.productForm.description,
                        recipes: this.currentRecipe.map(item => ({
                            stock_id: item.stock_id,
                            amount_needed: item.amount_needed
                        }))
                    });

                    window.location.reload();
                } catch (error) {
                    console.error('Error saving recipe:', error);
                    let message = 'Gagal menyimpan resep. Silakan coba lagi.';
                    if (error.response && error.response.data && error.response.data.message) {
                        message = error.response.data.message;
                    }
                    alert(message);
                } finally {
                    this.loading = false;
                }
            },

            formatNumber(number) {
                if (number === null || number === undefined) return '0';
                return new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 3,
                    minimumFractionDigits: 0
                }).format(number);
            }
        };
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #e2e8f0;
    }
    [x-cloak] { display: none !important; }
</style>
@endsection
