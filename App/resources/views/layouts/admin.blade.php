<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - Tannya Caffe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
        .font-rounded {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center gap-3">
                            <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="h-10 w-auto">
                            <div>
                                <h1 class="text-xl font-bold text-dark leading-none">Tannya Caffe</h1>
                                <p class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">Admin Insights</p>
                            </div>
                        </div>
                        <div class="hidden sm:ml-12 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} text-sm">Analitik</a>
                            <a href="{{ route('admin.inventory') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.inventory') ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} text-sm">Inventory</a>
                            <a href="{{ route('admin.sales') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.sales') ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} text-sm">Sales</a>
                            <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.reports') ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} text-sm">Reports</a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-bold text-dark">Admin Tannya</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Super Admin</p>
                            </div>
                            <img class="h-10 w-10 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name=Admin+Tannya&background=2D5A27&color=fff" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
