<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Desa Sejahtera')</title>
    
    <!-- Tailwind CSS + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Custom styles */
        .hero-pattern {
            background-image: radial-gradient(circle at 10% 20%, rgba(245, 158, 11, 0.05) 0%, rgba(16, 185, 129, 0.05) 90%);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .transition-custom {
            transition: all 0.3s ease;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-amber-50 via-white to-emerald-50 font-sans antialiased">
    
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-amber-100">
        <div class="container mx-auto px-4 py-3 flex flex-wrap justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Coat_of_arms_of_Pekalongan_Regency.svg/960px-Coat_of_arms_of_Pekalongan_Regency.svg.png" 
                     alt="Logo" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold bg-gradient-to-r from-amber-700 to-emerald-700 bg-clip-text text-transparent">
                    Desa Sejahtera
                </span>
            </a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('pengajuan.form') }}" class="hidden md:inline-flex items-center gap-1 text-amber-700 hover:text-amber-900 font-medium">
                    <i class="fas fa-file-alt"></i> Ajukan Surat
                </a>
                <a href="{{ route('pengajuan.cek-status') }}" class="hidden md:inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-medium">
                    <i class="fas fa-search"></i> Cek Status
                </a>
                <a href="{{ route('pengajuan.form') }}" class="bg-gradient-to-r from-amber-600 to-emerald-600 hover:from-amber-700 hover:to-emerald-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-md transition-custom">
                    <i class="fas fa-paper-plane mr-1"></i> Ajukan
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="animate-fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Coat_of_arms_of_Pekalongan_Regency.svg/960px-Coat_of_arms_of_Pekalongan_Regency.svg.png" 
                             alt="Logo" class="h-8 w-8">
                        <span class="font-bold text-lg">Desa Sejahtera</span>
                    </div>
                    <p class="text-gray-400 text-sm">Layanan surat online yang cepat, mudah, dan transparan untuk warga desa.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-3 text-amber-400">Layanan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('pengajuan.form') }}" class="hover:text-amber-400 transition">Ajukan Surat</a></li>
                        <li><a href="{{ route('pengajuan.cek-status') }}" class="hover:text-amber-400 transition">Cek Status</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Informasi Desa</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-3 text-emerald-400">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone-alt mr-2"></i> 0812-3456-7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> desa@sejahtera.id</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Kecamatan Sejahtera, Kab. Pekalongan</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Desa Sejahtera. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>