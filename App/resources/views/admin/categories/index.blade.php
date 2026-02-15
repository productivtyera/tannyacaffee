@extends('layouts.admin')

@section('title', 'Manajer Kategori')

@section('content')
<div class="max-w-4xl mx-auto space-y-12">
    <!-- Page Header -->
    <div class="text-center space-y-2">
        <h2 class="text-4xl font-black text-[#1a2b3c]">Manajer Kategori</h2>
        <p class="text-gray-500 font-medium">Atur kategori produk untuk pengorganisasian menu yang lebih baik.</p>
    </div>

    <!-- Add Category Form -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
        <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Tambah Kategori Baru</h4>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex items-center gap-4">
            @csrf
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-300 group-focus-within:text-[#2D5A27] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </div>
                <input type="text" name="name" required placeholder="Masukkan nama kategori baru (misal: Seasonal Drinks)" 
                    class="w-full bg-[#f8f9fa] border-none rounded-2xl pl-16 pr-6 py-4 text-sm font-medium focus:ring-2 focus:ring-[#2D5A27]/20 transition-all placeholder:text-gray-400">
            </div>
            <button type="submit" class="bg-[#2D5A27] text-white rounded-2xl px-8 py-4 flex items-center justify-center gap-3 text-sm font-black shadow-lg shadow-[#2D5A27]/20 hover:bg-[#23461e] transition-all transform hover:-translate-y-0.5 active:translate-y-0 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah</span>
            </button>
        </form>
        @error('name')
            <p class="mt-3 text-sm text-red-500 font-bold ml-6">{{ $message }}</p>
        @enderror
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
        <div class="px-8 py-8 border-b border-gray-50 flex justify-between items-center bg-white">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-[#f8f9fa] rounded-xl flex items-center justify-center text-[#1a2b3c]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-[#1a2b3c]">Daftar Kategori</h3>
            </div>
            <div class="flex items-center gap-4">
                <span class="bg-[#f0f9f4] text-[#2D5A27] text-[10px] font-black px-4 py-2 rounded-full border border-[#2D5A27]/10 uppercase tracking-wider">
                    Total {{ $categories->count() }} Kategori
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">
                        <th class="px-8 py-6">Nama Kategori</th>
                        <th class="py-6 text-center">Jumlah Produk</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <span class="text-[16px] font-bold text-[#1a2b3c]">{{ $category->name }}</span>
                        </td>
                        <td class="py-6 text-center">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#f8f9fa] text-gray-500 text-xs font-bold border border-gray-100">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Hapus Kategori">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-10 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-200">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-medium">Belum ada kategori yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
        class="fixed bottom-10 right-10 bg-[#2D5A27] text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-[100]"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-10"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
        class="fixed bottom-10 right-10 bg-red-600 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-[100]"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-10"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
@endif
@endsection
