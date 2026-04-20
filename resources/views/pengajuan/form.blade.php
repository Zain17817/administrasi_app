@extends('layouts.app')

@section('title', 'Pengajuan Surat Online')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-4 px-4">
    <div class="max-w-6xl mx-auto">
        {{-- Header dengan animasi --}}
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full shadow-md mb-3">
                <i class="fas fa-building text-4xl text-blue-700"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Desa Sejahtera</h1>
            <p class="text-gray-600 mt-1 text-lg">Layanan Surat Online | Cepat, Mudah & Transparan</p>
            <div class="w-24 h-1 bg-blue-500 mx-auto mt-3 rounded-full"></div>
        </div>

        {{-- Card Form --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl">
            <div class="bg-gradient-to-r from-blue-800 to-blue-600 py-4 px-6">
                <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-file-alt"></i> 
                    Form Pengajuan Surat
                </h2>
                <p class="text-blue-100 text-sm mt-1">Isi data dengan benar untuk memproses surat Anda</p>
            </div>

            <div class="p-6 md:p-8">
                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
                        <div class="flex-1">{!! session('success') !!}</div>
                        <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-sm flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mt-0.5"></i>
                        <div class="flex-1">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="pengajuanForm" class="space-y-6">
                    @csrf

                    {{-- Grid 2 kolom untuk Nama & No HP --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="nama" value="{{ old('nama') }}" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama') border-red-500 @enderror" 
                                    placeholder="Masukkan Nama Lengkap" required>
                                <i class="fas fa-user absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                            @error('nama') <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>Nomor HP (WhatsApp) 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3 text-gray-500 font-medium select-none">+62</span>
                                <input type="tel" name="no_hp" id="no_hp" 
                                    value="{{ old('no_hp') ? (Str::startsWith(old('no_hp'), '+62') ? substr(old('no_hp'), 3) : old('no_hp')) : '' }}"
                                    class="w-full border border-gray-300 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('no_hp') border-red-500 @enderror" 
                                    placeholder="8123456789" 
                                    inputmode="numeric"
                                    autocomplete="off" required>
                            </div>
                            @error('no_hp') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                            @else
                                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> Contoh: 8123456789 (tanpa 0 di depan)</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="space-y-1">
                        <label class="block font-semibold text-gray-700">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>Alamat Lengkap 
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea name="alamat" rows="2" 
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('alamat') border-red-500 @enderror" 
                                placeholder="RT/RW, Dusun, Desa Sejahtera..." required>{{ old('alamat') }}</textarea>
                            <i class="fas fa-map-marker-alt absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                        @error('alamat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Surat & Keperluan (grid) --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-envelope-open-text text-purple-500 mr-2"></i>Jenis Surat 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="jenis_surat" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 appearance-none bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('jenis_surat') border-red-500 @enderror" 
                                    required>
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="Domisili" {{ old('jenis_surat') == 'Domisili' ? 'selected' : '' }}>📄 Surat Domisili</option>
                                    <option value="Usaha" {{ old('jenis_surat') == 'Usaha' ? 'selected' : '' }}>🏪 Surat Usaha</option>
                                    <option value="Tidak Mampu" {{ old('jenis_surat') == 'Tidak Mampu' ? 'selected' : '' }}>📑 Surat KeteranganTidak Mampu</option>
                                    <option value="Keterangan Lain" {{ old('jenis_surat') == 'Keterangan Lain' ? 'selected' : '' }}>📝 Surat Keterangan Lain</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                <i class="fas fa-tag absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                            @error('jenis_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-pencil-alt text-yellow-600 mr-2"></i>Keperluan 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="keperluan" rows="2" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('keperluan') border-red-500 @enderror" 
                                    placeholder="Contoh: Untuk melamar pekerjaan, keperluan usaha, dll." required>{{ old('keperluan') }}</textarea>
                                <i class="fas fa-info-circle absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                            @error('keperluan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Upload file dengan grid 3 kolom --}}
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-id-card text-blue-600 mr-2"></i>Upload KTP (foto/scan) 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="ktp" accept="image/*,application/pdf" 
                                    class="w-full border border-gray-300 rounded-xl py-3 px-4 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer @error('ktp') border-red-500 @enderror" 
                                    required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> Maks 2MB, format JPG, PNG, PDF</p>
                            @error('ktp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-users text-green-600 mr-2"></i>Upload KK (foto/scan) 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="kk" accept="image/*,application/pdf" 
                                    class="w-full border border-gray-300 rounded-xl py-3 px-4 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer @error('kk') border-red-500 @enderror" 
                                    required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> Maks 2MB, format JPG, PNG, PDF</p>
                            @error('kk') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Surat Rekomendasi RT -- WAJIB --}}
                        <div class="space-y-1">
                            <label class="block font-semibold text-gray-700">
                                <i class="fas fa-hand-peace text-orange-500 mr-2"></i>Surat Rekomendasi RT 
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="surat_rt" accept="image/*,application/pdf" 
                                    class="w-full border border-gray-300 rounded-xl py-3 px-4 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer @error('surat_rt') border-red-500 @enderror" 
                                    required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> <strong>Wajib diunggah!</strong> Maks 2MB, JPG/PNG/PDF</p>
                            @error('surat_rt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Informasi Tambahan Persyaratan --}}
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-500 text-xl mt-0.5"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">📋 Persyaratan yang harus dilengkapi:</p>
                                <ul class="list-disc list-inside space-y-0.5 text-blue-700">
                                    <li>KTP (Kartu Tanda Penduduk)</li>
                                    <li>KK (Kartu Keluarga)</li>
                                    <li>Surat Rekomendasi dari Ketua RT setempat</li>
                                </ul>
                                <p class="mt-2 text-xs">*Semua file maksimal 2MB dan format JPG, PNG, atau PDF</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit dengan efek loading --}}
                    <button type="submit" id="submitBtn" 
                        class="w-full bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 text-white font-bold py-3 rounded-xl transition duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                </form>
            </div>

            {{-- Footer dengan link --}}
            <div class="bg-gray-50 py-4 px-6 text-center text-sm text-gray-600 border-t flex flex-wrap justify-center gap-4">
                <a href="{{ route('pengajuan.cek-status') }}" class="inline-flex items-center gap-1 text-blue-700 hover:text-blue-900 transition">
                    <i class="fas fa-search"></i> Cek Status Pengajuan
                </a>
                <span class="text-gray-300 hidden md:inline">|</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-gray-500 hover:text-gray-700 transition">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                <span class="text-gray-300 hidden md:inline">|</span>
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1 text-blue-700 hover:text-blue-900 transition">
                    <i class="fas fa-user-shield"></i> Login Admin
                </a>
                <span class="text-gray-300 hidden md:inline">|</span>
                <span class="inline-flex items-center gap-1 text-gray-500">
                    <i class="fas fa-headset"></i> Bantuan: 0812-3456-7890
                </span>
            </div>
        </div>

        {{-- Informasi tambahan --}}
        <div class="mt-6 text-center text-xs text-gray-500">
            <p><i class="fas fa-clock"></i> Proses surat maksimal 2x24 jam setelah berkas lengkap.</p>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
    .hover\:shadow-3xl:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<script>
    // Loading state saat submit
    document.getElementById('pengajuanForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang memproses...';
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        }
    });

    // Format nomor telepon otomatis menjadi +62
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputNoHp = document.getElementById('no_hp');

        if (form && inputNoHp) {
            // Validasi input nomor HP hanya angka
            inputNoHp.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            form.addEventListener('submit', function(e) {
                let rawValue = inputNoHp.value.trim();
                let digits = rawValue.replace(/\D/g, '');
                if (digits === '') return;
                if (digits.startsWith('0')) {
                    digits = digits.substring(1);
                }
                const formatted = '+62' + digits;
                inputNoHp.value = formatted;
            });
        }
    });
</script>
@endsection