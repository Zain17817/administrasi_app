@extends('layouts.app')

@section('title', 'Cek Status Surat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full shadow-md mb-3">
                <i class="fas fa-search text-3xl text-green-600"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Cek Status Pengajuan</h1>
            <p class="text-gray-600 mt-2 text-lg">Masukkan nomor pengajuan untuk mengetahui status terbaru</p>
            <div class="w-24 h-1 bg-green-500 mx-auto mt-3 rounded-full"></div>
        </div>

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

        {{-- Card Form --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl">
            <div class="bg-gradient-to-r from-green-800 to-green-600 py-4 px-6">
                <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> 
                    Lacak Pengajuan
                </h2>
                <p class="text-green-100 text-sm mt-1">Status akan dikirim juga ke WhatsApp Anda</p>
            </div>

            <div class="p-6 md:p-8">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-sm flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mt-0.5"></i>
                        <div class="flex-1">{{ session('error') }}</div>
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <form action="{{ route('pengajuan.cek-status.proses') }}" method="POST" id="cekStatusForm" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="block font-semibold text-gray-700">
                            <i class="fas fa-qrcode text-blue-500 mr-2"></i>Nomor Pengajuan
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="nomor_pengajuan" 
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-12 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" 
                                placeholder="Contoh: SRT-20250315123045-Ab12" required>
                            <i class="fas fa-hashtag absolute left-3 top-3.5 text-gray-400 text-lg"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Nomor pengajuan dikirim ke email/WA setelah pengajuan berhasil
                        </p>
                    </div>

                    <button type="submit" id="submitBtn" 
                        class="w-full bg-gradient-to-r from-green-700 to-green-600 hover:from-green-800 hover:to-green-700 text-white font-bold py-3 rounded-xl transition duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Cek Status Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('pengajuan.form') }}" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-900 transition font-medium">
                        <i class="fas fa-arrow-left"></i> Kembali ke Form Pengajuan
                    </a>
                </div>
            </div>

            {{-- Footer informasi --}}
            <div class="bg-gray-50 py-4 px-6 text-center text-sm text-gray-600 border-t">
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="inline-flex items-center gap-1"><i class="fas fa-clock text-green-600"></i> Update status realtime</span>
                    <span class="inline-flex items-center gap-1"><i class="fab fa-whatsapp text-green-500"></i> Notifikasi via WhatsApp</span>
                    <span class="inline-flex items-center gap-1"><i class="fas fa-envelope text-blue-500"></i> Email konfirmasi</span>
                </div>
            </div>
        </div>

        {{-- Informasi bantuan --}}
        <div class="mt-6 text-center text-xs text-gray-500">
            <p><i class="fas fa-question-circle"></i> Jika lupa nomor pengajuan, hubungi admin desa di nomor 0812-3456-7890</p>
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
    document.getElementById('cekStatusForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang mencari...';
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        }
    });
</script>
@endsection