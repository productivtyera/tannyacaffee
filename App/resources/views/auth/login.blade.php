<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tannya Caffe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #D1D5DB; /* Matching the gray background in image */
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen">
    <div class="w-full max-w-[440px] px-6">
        <div class="bg-white rounded-[32px] shadow-xl overflow-hidden p-10 flex flex-col items-center">
            <!-- Logo -->
            <div class="relative mb-6">
                <div class="w-24 h-24 rounded-full bg-[#F5F5DC] flex items-center justify-center p-4">
                    <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="w-full h-auto opacity-80">
                </div>
                <div class="absolute -top-1 -right-1 w-6 h-6 bg-primary rounded-full border-4 border-white flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-dark mb-1">Halo, Tim Tannya!</h2>
            <p class="text-gray-400 text-sm mb-8">Silahkan masuk untuk memulai shift.</p>

            <form action="{{ route('login') }}" method="POST" class="w-full">
                @csrf
                <div class="mb-5">
                    <label for="login" class="block text-xs font-bold text-gray-700 mb-2">Username atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" class="block w-full pl-11 pr-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Masukkan username atau email" required>
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-gray-700">Kata Sandi</label>
                        <a href="#" class="text-[10px] font-bold text-primary hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-11 pr-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Masukkan kata sandi" required>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Coffee Icon -->
            <div class="mt-10 mb-6">
                <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                </svg>
            </div>

            <p class="text-[10px] font-bold text-gray-300 tracking-widest uppercase">Tannya Caffe v2.4.0</p>
        </div>

        <div class="mt-8 flex justify-center gap-6 text-xs text-gray-500 font-medium">
            <span>&copy; 2024 Tannya Caffe.</span>
            <a href="#" class="hover:text-primary transition-colors">Butuh bantuan?</a>
        </div>
    </div>
</body>
</html>
