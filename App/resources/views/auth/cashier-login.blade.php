<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tannya Caffe Cashier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="bg-white rounded-[32px] shadow-xl w-full max-w-[1200px] h-[700px] flex overflow-hidden">
        
        <!-- Left Section -->
        <div class="w-1/2 bg-[#2D5A27] text-white p-12 flex flex-col justify-between relative hidden lg:flex">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-full p-2 w-10 h-10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-xl leading-none">Tannya</h1>
                    <p class="text-[10px] tracking-widest text-[#8BA888] font-bold">CAFFE CASHIER</p>
                </div>
            </div>

            <!-- Illustration -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
                <div class="relative flex justify-center items-center">
                    <img src="{{ asset('logo.png') }}" alt="Tannya Caffe Logo" class="w-64 h-64 object-cover rounded-full shadow-xl">
                </div>
            </div>

            <!-- Footer Text -->
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-2">Layanan Ramah, Hari Cerah</h2>
                <p class="text-[#8BA888] text-sm px-8">Pastikan setiap pesanan pelanggan tersaji dengan penuh kebahagiaan.</p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="w-full lg:w-1/2 bg-white p-12 lg:p-16 flex flex-col justify-center relative">
            <div class="max-w-md mx-auto w-full">
                <h2 class="text-3xl font-bold text-[#2B1B17] mb-2">Selamat Bekerja, Kasir Tannya!</h2>
                <p class="text-gray-400 text-sm mb-10">Silakan masuk untuk mengelola pesanan hari ini.</p>

                <form action="{{ route('cashier.login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Login Field -->
                    <div>
                        <label for="login" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">ID Pegawai / Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="text" name="login" id="login" value="{{ old('login') }}" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-[#F9FAFB] border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] transition-all placeholder-gray-400" 
                                placeholder="Masukkan ID atau Email" required>
                        </div>
                        @error('login')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Password</label>
                            <a href="#" class="text-[10px] font-bold text-[#2D5A27] hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" 
                                class="block w-full pl-11 pr-10 py-3.5 bg-[#F9FAFB] border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] transition-all placeholder-gray-400" 
                                placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer" onclick="togglePassword()">
                                <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.577-2.9M7.757 7.757A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.577 2.9M9.172 9.172a3 3 0 004.242 4.242M9.172 9.172L14.828 14.828" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-[#2D5A27] focus:ring-[#2D5A27] border-gray-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="group w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#2D5A27] hover:bg-[#1e3d1a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27] transition-all transform hover:scale-[1.02]">
                        Masuk ke Dashboard
                        <svg class="ml-2 -mr-1 h-5 w-5 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center text-xs font-bold text-gray-400">
                    <a href="https://wa.me/6287893448848?text=Halo%20Support%20Tannya%20Caffe%2C%0A%0ASaya%20butuh%20bantuan%20terkait%20Login%20Kasir.%0AMohon%20bantuannya.%0A%0ATerima%20kasih." class="flex items-center hover:text-gray-600 transition-colors" target="_blank">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Butuh Bantuan?
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Ganti Role
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">Versi Aplikasi 2.4.0</p>
                    <p class="text-[10px] text-gray-300 mt-1 opacity-60">Made with love by Productivtyera</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
