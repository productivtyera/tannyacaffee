@extends('layouts.admin')

@section('title', 'Manajemen User & Staf')

@section('content')
<div x-data="{ 
    showModal: false, 
    editMode: false, 
    user: {}, 
    password: '',
    requirements: {
        length: false,
        uppercase: false,
        number: false,
        symbol: false
    },
    checkPassword() {
        this.requirements.length = this.password.length >= 8;
        this.requirements.uppercase = /[A-Z]/.test(this.password);
        this.requirements.number = /[0-9]/.test(this.password);
        this.requirements.symbol = /[^A-Za-z0-9]/.test(this.password);
    }
}">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen User & Staf</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola hak akses dan data seluruh staf Tannya Caffe.</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex justify-between items-center gap-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex-1 max-w-lg relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm" placeholder="Cari nama, username, atau email...">
        </form>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27]">
                <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            <button @click="showModal = true; editMode = false; user = {role: ''}; password = ''; checkPassword()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-[#2D5A27] hover:bg-[#23461e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27]">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User Baru
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1 11a1 1 0 10-2 0v2a1 1 0 102 0v-2zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V10a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
            <div class="ml-3">
                <p class="text-sm text-red-700 font-bold">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#1a2b3c] text-white">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Username</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $u)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-800 font-bold border border-green-200">
                                        {{ strtoupper(substr($u->name ?? $u->username, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $u->name ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $u->username }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $u->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-wide {{ $u->role === 'admin' ? 'bg-green-100 text-green-800 border border-green-200' : ($u->role === 'cashier' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-800 border border-gray-200') }}">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center text-sm font-medium {{ $u->role !== 'customer' ? 'text-green-600' : 'text-gray-400' }}">
                                <span class="h-2.5 w-2.5 rounded-full {{ $u->role !== 'customer' ? 'bg-green-600' : 'bg-gray-400' }} mr-2"></span>
                                {{ $u->role !== 'customer' ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <button @click="showModal = true; editMode = true; user = {{ $u }}; password = ''; checkPassword()" class="text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg transition-colors" title="Edit User">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition-colors" title="Hapus User">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p>Tidak ada user ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Admin</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ str_pad($totalAdmin, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-[#2D5A27]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kasir</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ str_pad($totalCashier, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">User Non-aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1 text-red-500">{{ str_pad($totalInactive, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="h-12 w-12 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal" class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100">
                <form :action="editMode ? '{{ route('admin.users.index') }}/' + user.id : '{{ route('admin.users.store') }}'" method="POST">
                    @csrf
                    <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">
                    
                    <div class="bg-white px-8 pt-8 pb-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900" x-text="editMode ? 'Edit User' : 'Tambah User'"></h3>
                                <p class="text-xs text-gray-500 mt-1">Lengkapi data di bawah untuk mengelola akun user Tannya Caffe.</p>
                            </div>
                            <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name" x-model="user.name" required class="block w-full pl-10 border-gray-200 bg-gray-50 rounded-xl focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm py-3 transition-colors" placeholder="Nama Lengkap">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="username" x-model="user.username" required class="block w-full pl-10 border-gray-200 bg-gray-50 rounded-xl focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm py-3 transition-colors" placeholder="nama_pengguna">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" x-model="user.email" required class="block w-full pl-10 border-gray-200 bg-gray-50 rounded-xl focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm py-3 transition-colors" placeholder="email@tannya.com">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2" x-text="editMode ? 'Password (Kosongkan jika tidak ingin mengubah)' : 'Password'"></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" name="password" x-model="password" @input="checkPassword()" :required="!editMode" class="block w-full pl-10 border-gray-200 bg-gray-50 rounded-xl focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm py-3 transition-colors" placeholder="********">
                                </div>
                                
                                <!-- Password Requirements -->
                                <div class="mt-3 grid grid-cols-2 gap-2" x-show="password.length > 0">
                                    <div class="flex items-center text-xs" :class="requirements.length ? 'text-green-600' : 'text-gray-500'">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="requirements.length">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!requirements.length">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Minimal 8 karakter
                                    </div>
                                    <div class="flex items-center text-xs" :class="requirements.uppercase ? 'text-green-600' : 'text-gray-500'">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="requirements.uppercase">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!requirements.uppercase">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Huruf Besar
                                    </div>
                                    <div class="flex items-center text-xs" :class="requirements.number ? 'text-green-600' : 'text-gray-500'">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="requirements.number">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!requirements.number">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Angka
                                    </div>
                                    <div class="flex items-center text-xs" :class="requirements.symbol ? 'text-green-600' : 'text-gray-500'">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="requirements.symbol">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!requirements.symbol">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Simbol
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Role</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <select name="role" x-model="user.role" required class="block w-full pl-10 border-gray-200 bg-gray-50 rounded-xl focus:ring-[#2D5A27] focus:border-[#2D5A27] sm:text-sm py-3 transition-colors appearance-none">
                                        <option value="" disabled>Pilih Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="cashier">Cashier</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 rounded-xl p-4 flex items-center justify-between border border-green-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Jadikan Admin</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Penuh Sistem</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_admin" class="sr-only peer" x-model="user.is_admin" :checked="user.is_admin">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2D5A27]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white px-8 pb-8 sm:flex sm:flex-row-reverse items-center justify-between gap-4">
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-lg shadow-green-900/20 px-6 py-4 bg-[#00C853] text-sm font-bold text-white hover:bg-[#00b54b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto transition-all transform hover:-translate-y-0.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span x-text="editMode ? 'Simpan Perubahan' : 'Simpan User'"></span>
                        </button>
                        <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border-none px-6 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 focus:outline-none sm:mt-0 sm:w-auto transition-colors">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
