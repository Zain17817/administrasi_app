@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
            <!-- Header dengan aksen gradasi -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-5">
                <div class="flex items-center justify-center space-x-3">
                    <i class="fas fa-user-shield text-3xl text-white drop-shadow-md"></i>
                    <h2 class="text-2xl font-bold text-white tracking-wide">Admin Access</h2>
                </div>
                <p class="text-blue-100 text-center text-sm mt-2">Masuk ke panel administrasi</p>
            </div>

            <!-- Body Form -->
            <div class="px-6 py-8 sm:px-8">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm flex items-start space-x-3" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Username Field -->
                    <div class="space-y-1">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-user text-gray-400 mr-2"></i>Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" name="username" id="username" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Masukkan username admin">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400 text-sm"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="••••••••">
                        </div>
                    </div>

                                        <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full flex justify-center items-center space-x-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login Sekarang</span>
                    </button>
                </form>

                <!-- Link tambahan -->
                <div class="mt-6 text-center">
                    <a href="{{ url('/pengajuan') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer kecil -->
        <p class="text-center text-xs text-gray-500 mt-4">
            &copy; {{ date('Y') }} Panel Admin. Hak akses terbatas.
        </p>
    </div>
</div>
@endsection