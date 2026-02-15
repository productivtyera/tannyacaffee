@extends('layouts.admin')

@section('title', 'Laporan Bisnis')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark">Laporan Bisnis</h1>
            <p class="text-gray-500 mt-1">Rekapitulasi performa finansial dan operasional outlet Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white border border-gray-200 rounded-2xl px-4 py-2.5 flex items-center gap-3 shadow-sm cursor-pointer hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-semibold text-dark">Januari - Maret 2024</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button class="bg-primary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Export Data
            </button>
        </div>
    </div>

    <!-- Top Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Laporan Laba Rugi -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-bold text-dark">Laporan Laba Rugi</h2>
                    <p class="text-sm text-gray-400 font-medium">Perbandingan bulanan Q1 2024</p>
                </div>
                <div class="flex gap-2">
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-xl text-xs font-bold text-dark hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        PDF
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-xl text-xs font-bold text-dark hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Excel
                    </button>
                </div>
            </div>

            <!-- Bar Chart Visualization -->
            <div class="h-64 mt-12 relative flex items-end justify-around border-b border-gray-100 pb-2">
                <!-- Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between -z-0">
                    <div class="border-b border-gray-50 w-full h-0"></div>
                    <div class="border-b border-gray-50 w-full h-0"></div>
                    <div class="border-b border-gray-50 w-full h-0"></div>
                </div>

                <!-- Januari -->
                <div class="relative flex flex-col items-center gap-4 w-24">
                    <div class="flex gap-2 items-end">
                        <div class="w-8 bg-[#D1E2CF] rounded-t-xl" style="height: 120px;"></div>
                        <div class="w-8 bg-primary rounded-t-xl relative group" style="height: 80px;">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-100 transition-opacity">
                                <span class="text-[10px] font-bold text-dark bg-white px-2 py-1 rounded shadow-sm border border-gray-50">62M</span>
                            </div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Januari</span>
                </div>

                <!-- Februari -->
                <div class="relative flex flex-col items-center gap-4 w-24">
                    <div class="flex gap-2 items-end">
                        <div class="w-8 bg-[#D1E2CF] rounded-t-xl" style="height: 150px;"></div>
                        <div class="w-8 bg-primary rounded-t-xl relative group" style="height: 110px;">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-100 transition-opacity">
                                <span class="text-[10px] font-bold text-dark bg-white px-2 py-1 rounded shadow-sm border border-gray-50">78M</span>
                            </div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Februari</span>
                </div>

                <!-- Maret -->
                <div class="relative flex flex-col items-center gap-4 w-24">
                    <div class="flex gap-2 items-end">
                        <div class="w-8 bg-[#D1E2CF] rounded-t-xl" style="height: 180px;"></div>
                        <div class="w-8 bg-primary rounded-t-xl relative group" style="height: 140px;">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-100 transition-opacity">
                                <span class="text-[10px] font-bold text-dark bg-white px-2 py-1 rounded shadow-sm border border-gray-50">92M</span>
                            </div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Maret</span>
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-8 flex justify-center gap-8">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#D1E2CF]"></div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pendapatan Kotor</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-primary"></div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Laba Bersih</span>
                </div>
            </div>
        </div>

        <!-- Analisis Produk -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 flex flex-col">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-bold text-dark">Analisis Produk</h2>
                <button class="p-2 hover:bg-gray-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-400 font-medium mb-8">Distribusi Penjualan</p>

            <!-- Donut Chart -->
            <div class="relative w-48 h-48 mx-auto mb-8">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <!-- Background Circle -->
                    <circle cx="50" cy="50" r="40" stroke="#F1F5F9" stroke-width="12" fill="none" />
                    <!-- Progress Circle (Green - Coffee Based 55%) -->
                    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="12" fill="none" 
                        class="text-primary"
                        stroke-dasharray="251.2" 
                        stroke-dashoffset="113.04" />
                    <!-- Progress Circle (Red - Non-Coffee 30%) -->
                    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="12" fill="none" 
                        class="text-secondary"
                        stroke-dasharray="251.2" 
                        stroke-dashoffset="175.84"
                        transform="rotate(198, 50, 50)" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-dark leading-none">1.2K</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total SKU</span>
                </div>
            </div>

            <!-- Donut Legend -->
            <div class="space-y-4 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                        <span class="text-sm font-bold text-dark">Coffee Based</span>
                    </div>
                    <span class="text-sm font-bold text-dark">55%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-secondary"></div>
                        <span class="text-sm font-bold text-dark">Non-Coffee</span>
                    </div>
                    <span class="text-sm font-bold text-dark">30%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#E2E8F0]"></div>
                        <span class="text-sm font-bold text-dark">Pastry & Food</span>
                    </div>
                    <span class="text-sm font-bold text-dark">15%</span>
                </div>
            </div>

            <button class="mt-auto w-full py-4 bg-dark text-white rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-opacity-90 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Unduh PDF/Excel
            </button>
        </div>
    </div>

    <!-- Bottom Section: Laporan Bahan Baku & HPP -->
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-2xl font-bold text-dark">Laporan Bahan Baku & HPP</h2>
                <p class="text-gray-400 font-medium">Monitoring Harga Pokok Penjualan vs Pendapatan</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <div class="bg-[#F2F8F1] px-6 py-4 rounded-3xl border border-[#E1EFE0]">
                    <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">Total Revenue</p>
                    <p class="text-xl font-black text-primary">Rp 482.500.000</p>
                </div>
                <div class="bg-[#FEF2F2] px-6 py-4 rounded-3xl border border-[#FEE2E2]">
                    <p class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">Total HPP</p>
                    <p class="text-xl font-black text-secondary">Rp 194.200.000</p>
                </div>
                <button class="flex items-center gap-2 px-6 py-4 bg-gray-50 rounded-3xl text-sm font-bold text-dark hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Unduh PDF/Excel
                </button>
            </div>
        </div>

        <!-- Material Detail Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Biji Kopi Arabica -->
            <div class="bg-[#F8FAFC] rounded-[2rem] p-6 border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L4 5v11c0 5.25 4.5 9.1 8 11 3.5-1.9 8-5.75 8-11V5l-8-3z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-dark">Biji Kopi Arabica</h3>
                </div>
                <div class="flex justify-between items-end mb-4">
                    <span class="text-xs font-bold text-gray-400">HPP Terpakai</span>
                    <span class="text-lg font-black text-dark">Rp 12.500.000</span>
                </div>
                <div class="relative h-2.5 bg-gray-200 rounded-full overflow-hidden mb-4">
                    <div class="absolute top-0 left-0 h-full bg-primary rounded-full" style="width: 88%;"></div>
                </div>
                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest">
                    <span class="text-gray-400">Target HPP: 25%</span>
                    <span class="text-primary">Actual: 22%</span>
                </div>
            </div>

            <!-- Susu & Dairy -->
            <div class="bg-[#F8FAFC] rounded-[2rem] p-6 border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-dark">Susu & Dairy</h3>
                </div>
                <div class="flex justify-between items-end mb-4">
                    <span class="text-xs font-bold text-gray-400">HPP Terpakai</span>
                    <span class="text-lg font-black text-dark">Rp 24.800.000</span>
                </div>
                <div class="relative h-2.5 bg-gray-200 rounded-full overflow-hidden mb-4">
                    <div class="absolute top-0 left-0 h-full bg-secondary rounded-full" style="width: 121%;"></div>
                </div>
                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest">
                    <span class="text-gray-400">Target HPP: 15%</span>
                    <span class="text-secondary">Actual: 18.2%</span>
                </div>
            </div>

            <!-- Bahan Pastry -->
            <div class="bg-[#F8FAFC] rounded-[2rem] p-6 border border-gray-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-dark">Bahan Pastry</h3>
                </div>
                <div class="flex justify-between items-end mb-4">
                    <span class="text-xs font-bold text-gray-400">HPP Terpakai</span>
                    <span class="text-lg font-black text-dark">Rp 15.200.000</span>
                </div>
                <div class="relative h-2.5 bg-gray-200 rounded-full overflow-hidden mb-4">
                    <div class="absolute top-0 left-0 h-full bg-primary rounded-full" style="width: 80%;"></div>
                </div>
                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest">
                    <span class="text-gray-400">Target HPP: 30%</span>
                    <span class="text-primary">Actual: 24%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="flex flex-col md:flex-row items-center justify-between pt-12 pb-6 border-t border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
        <p>© 2024 Tannya Caffe. All Rights Reserved.</p>
        <div class="flex gap-8">
            <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
            <a href="#" class="hover:text-primary transition-colors">Help Center</a>
        </div>
    </div>
</div>
@endsection
