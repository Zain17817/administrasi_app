@extends('layouts.beranda')

@section('title', 'Desa Sejahtera - Layanan Surat Online')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-amber-50 via-white to-emerald-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-900/10 to-emerald-900/10">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="flex flex-col items-center text-center">
                <div class="mb-6">
                    <img src="{{ asset('https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Coat_of_arms_of_Pekalongan_Regency.svg/960px-Coat_of_arms_of_Pekalongan_Regency.svg.png') }}" alt="Logo Kabupaten Pekalongan" class="h-24 w-24 md:h-32 md:w-32 object-contain">
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">
                    Layanan Surat Online
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-emerald-600">Desa Sejahtera</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mb-8">
                    Urus surat keterangan dari rumah. Proses cepat, mudah, dan transparan.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('pengajuan.form') }}" class="bg-gradient-to-r from-amber-600 to-emerald-600 hover:from-amber-700 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Ajukan Surat
                    </a>
                    <a href="{{ route('pengajuan.cek-status') }}" class="bg-white text-emerald-600 border border-emerald-600 hover:bg-emerald-50 font-semibold px-6 py-3 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cek Status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Jenis Surat yang Tersedia</h2>
            <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card Layanan -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-2xl text-amber-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Surat Domisili</h3>
                <p class="text-gray-600">Untuk keperluan pindah penduduk, KTP, atau administrasi lainnya.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store text-2xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Surat Usaha</h3>
                <p class="text-gray-600">Untuk keperluan izin usaha, pinjaman bank, atau administrasi lainnya.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-heart text-2xl text-amber-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Surat Tidak Mampu</h3>
                <p class="text-gray-600">Untuk keperluan bantuan sosial, beasiswa, atau pengobatan.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-2xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Keterangan Lain</h3>
                <p class="text-gray-600">Surat keterangan lainnya sesuai keperluan.</p>
            </div>
        </div>
    </div>

    <!-- Statistik Section -->
    <div class="bg-gradient-to-r from-amber-800 to-emerald-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-sm uppercase tracking-wide">Pengajuan Diproses</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <div class="text-sm uppercase tracking-wide">Kepuasan Warga</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">24 Jam</div>
                    <div class="text-sm uppercase tracking-wide">Proses Cepat</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cara Kerja Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Bagaimana Cara Kerjanya?</h2>
            <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                    <i class="fas fa-file-upload text-2xl text-amber-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Ajukan Surat</h3>
                <p class="text-gray-600">Isi formulir online dan upload dokumen yang diperlukan.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                    <i class="fas fa-clock text-2xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Proses Verifikasi</h3>
                <p class="text-gray-600">Admin akan memproses dan memverifikasi pengajuan Anda.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                    <i class="fas fa-check-circle text-2xl text-amber-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Selesai & Terbit</h3>
                <p class="text-gray-600">Surat selesai dan dapat diambil atau dikirim via email/WA.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-amber-100 to-emerald-100 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Siap Mengajukan Surat?</h2>
            <p class="text-xl text-gray-600 mb-8">Nikmati kemudahan layanan administrasi desa secara online.</p>
            <a href="{{ route('pengajuan.form') }}" class="bg-gradient-to-r from-amber-600 to-emerald-600 hover:from-amber-700 hover:to-emerald-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition inline-flex items-center gap-2">
                <i class="fas fa-paper-plane"></i> Ajukan Sekarang
            </a>
        </div>
    </div>
</div>
@endsection