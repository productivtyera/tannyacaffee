@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-dark">Analitik & Performa Toko</h2>
            <p class="text-gray-500 mt-1">Pantau pertumbuhan bisnis dan operasional secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white border border-gray-200 rounded-xl px-4 py-2 flex items-center gap-2 text-sm font-medium text-gray-600 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span>7 Hari Terakhir</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
            <button class="bg-primary text-white rounded-xl px-5 py-2 flex items-center gap-2 text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                <span>Unduh Laporan</span>
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Penjualan -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50 relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                </div>
                <span class="bg-green-100 text-primary text-[10px] font-bold px-2 py-1 rounded-lg">+12.5%</span>
            </div>
            <p class="text-sm font-medium text-gray-400">Total Penjualan</p>
            <h3 class="text-2xl font-extrabold text-dark mt-1">Rp 48.250.000</h3>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded-lg">+8.2%</span>
            </div>
            <p class="text-sm font-medium text-gray-400">Total Pesanan</p>
            <h3 class="text-2xl font-extrabold text-dark mt-1">1,248 Pcs</h3>
        </div>

        <!-- Stok Bahan Rendah -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-secondary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <span class="bg-red-100 text-secondary text-[10px] font-bold px-2 py-1 rounded-lg">Kritis</span>
            </div>
            <p class="text-sm font-medium text-gray-400">Stok Bahan Rendah</p>
            <h3 class="text-2xl font-extrabold text-secondary mt-1">5 Bahan</h3>
        </div>

        <!-- Pelanggan Baru -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <span class="bg-orange-100 text-orange-500 text-[10px] font-bold px-2 py-1 rounded-lg">+4%</span>
            </div>
            <p class="text-sm font-medium text-gray-400">Pelanggan Baru</p>
            <h3 class="text-2xl font-extrabold text-dark mt-1">342 Orang</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Weekly Sales Chart -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h4 class="text-lg font-bold text-dark">Tren Penjualan Mingguan</h4>
                        <p class="text-xs text-gray-400 font-medium">Performansi pendapatan vs minggu lalu</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Minggu Ini</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-blue-100"></div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Minggu Lalu</span>
                        </div>
                    </div>
                </div>
                
                <!-- Dummy Chart Visualization -->
                <div class="h-64 flex items-end justify-between gap-4 px-2">
                    @foreach(['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'] as $day)
                        <div class="flex-1 flex flex-col items-center gap-4 group">
                            <div class="w-full flex items-end justify-center gap-1 h-48">
                                <div class="w-3 bg-blue-50 rounded-t-full" style="height: {{ rand(30, 70) }}%"></div>
                                <div class="w-3 bg-primary rounded-t-full transition-all group-hover:bg-primary/80" style="height: {{ rand(40, 95) }}%"></div>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
                
                <!-- Chart Bottom Labels -->
                <div class="mt-4 flex border-t border-gray-50 pt-4">
                    @foreach(['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'] as $index => $day)
                        <div class="flex-1 h-1.5 {{ $index < 5 ? 'bg-primary/20' : 'bg-secondary/20' }} mx-0.5 first:rounded-l-full last:rounded-r-full overflow-hidden">
                            <div class="h-full {{ $index < 5 ? 'bg-primary' : 'bg-secondary' }}" style="width: {{ rand(60, 100) }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Best Selling Products -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="text-lg font-bold text-dark">Produk Terlaris</h4>
                    <a href="#" class="text-primary text-xs font-bold hover:underline">Lihat Detail</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4 font-bold">Produk</th>
                                <th class="pb-4 font-bold">Kategori</th>
                                <th class="pb-4 font-bold text-center">Terjual</th>
                                <th class="pb-4 font-bold">Pendapatan</th>
                                <th class="pb-4 font-bold">Status Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach([
                                ['name' => 'Aren Latte Signature', 'cat' => 'Coffee Based', 'sold' => 458, 'rev' => '11.450.000', 'status' => 'Aman', 'color' => 'primary'],
                                ['name' => 'Oatmilk Matcha Ice', 'cat' => 'Non-Coffee', 'sold' => 312, 'rev' => '9.360.000', 'status' => 'Menipis', 'color' => 'secondary'],
                                ['name' => 'Croissant Almond', 'cat' => 'Pastry', 'sold' => 285, 'rev' => '7.125.000', 'status' => 'Aman', 'color' => 'primary']
                            ] as $product)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </div>
                                        <span class="text-sm font-bold text-dark">{{ $product['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-5 text-sm font-medium text-gray-500">{{ $product['cat'] }}</td>
                                <td class="py-5 text-sm font-bold text-dark text-center">{{ $product['sold'] }}</td>
                                <td class="py-5 text-sm font-bold text-dark">Rp {{ $product['rev'] }}</td>
                                <td class="py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-{{ $product['color'] }}"></div>
                                        <span class="text-xs font-bold text-{{ $product['color'] }}">{{ $product['status'] }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Panel -->
        <div class="space-y-8">
            <!-- Live Transactions -->
            <div class="bg-primary p-8 rounded-[2.5rem] shadow-xl shadow-primary/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <h4 class="text-lg font-bold">Live Transactions</h4>
                        <span class="bg-white/20 backdrop-blur-md text-[10px] font-bold px-2 py-1 rounded-lg uppercase">Hari Ini</span>
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            ['id' => '#TRX-9824', 'items' => '2x Aren Latte, 1x Donut', 'price' => '74.000', 'time' => 'Baru Saja'],
                            ['id' => '#TRX-9823', 'items' => '1x Americano Hot', 'price' => '22.000', 'time' => '3 Menit Lalu'],
                            ['id' => '#TRX-9822', 'items' => '3x Matcha Ice, 2x Brownies', 'price' => '165.000', 'time' => '12 Menit Lalu']
                        ] as $index => $trx)
                        <div class="bg-white/10 backdrop-blur-sm p-5 rounded-2xl border border-white/10 hover:bg-white/20 transition-all cursor-pointer">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-[10px] font-bold text-white/60">{{ $trx['id'] }}</span>
                                <span class="text-[10px] font-medium text-white/60">{{ $trx['time'] }}</span>
                            </div>
                            <p class="text-sm font-bold mb-2">{{ $trx['items'] }}</p>
                            <p class="text-lg font-extrabold text-white">Rp {{ $trx['price'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    <button class="w-full mt-8 bg-white text-primary rounded-2xl py-4 text-sm font-extrabold shadow-lg hover:bg-gray-50 transition-all">
                        Buka POS System
                    </button>
                </div>
                
                <!-- Decorative Circle -->
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
            </div>

            <!-- Operational Status -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h4 class="text-lg font-bold text-dark">Status Operasional</h4>
                </div>

                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-xs font-bold text-gray-400">Kapasitas Penyimpanan</span>
                            <span class="text-xs font-extrabold text-primary">82%</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: 82%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-xs font-bold text-gray-400">Stok Bahan Baku Pokok</span>
                            <span class="text-xs font-extrabold text-secondary">45%</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-secondary" style="width: 45%"></div>
                        </div>
                        <p class="mt-3 text-[10px] font-bold text-secondary flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                            Kopi & Susu perlu restock dalam 2 hari.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Admin Recommendation -->
            <div class="bg-dark p-8 rounded-[2.5rem] shadow-xl text-white">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-yellow-400/20 rounded-xl flex items-center justify-center text-yellow-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.95a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM15 10a5 5 0 11-10 0 5 5 0 0110 0z" /></svg>
                    </div>
                    <h4 class="text-lg font-bold">Rekomendasi Admin</h4>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed">
                    Berdasarkan tren sabtu lalu, tingkatkan stok <span class="text-white font-bold">Oatmilk</span> sebesar 20% untuk mengantisipasi lonjakan akhir pekan.
                </p>
                <button class="mt-8 flex items-center gap-2 text-xs font-bold text-white hover:text-gray-300 transition-colors">
                    Buat Purchase Order Otomatis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button (Optional) -->
<div class="fixed bottom-8 right-8">
    <button class="w-14 h-14 bg-secondary text-white rounded-full flex items-center justify-center shadow-2xl shadow-secondary/40 hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
    </button>
</div>
@endsection
