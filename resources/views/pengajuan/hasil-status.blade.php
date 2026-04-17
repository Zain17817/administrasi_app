@extends('layouts.app')

@section('title', 'Hasil Cek Status')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 
                @if($pengajuan->status == 'Pending') bg-yellow-100
                @elseif($pengajuan->status == 'Diproses') bg-blue-100
                @elseif($pengajuan->status == 'Selesai') bg-green-100
                @else bg-red-100 @endif
                rounded-full shadow-md mb-3">
                <i class="fas 
                    @if($pengajuan->status == 'Pending') fa-clock text-yellow-600
                    @elseif($pengajuan->status == 'Diproses') fa-spinner fa-pulse text-blue-600
                    @elseif($pengajuan->status == 'Selesai') fa-check-circle text-green-600
                    @else fa-times-circle text-red-600 @endif
                    text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Detail Pengajuan</h1>
            <p class="text-gray-600 mt-2 text-lg">Informasi lengkap status surat Anda</p>
            <div class="w-24 h-1 
                @if($pengajuan->status == 'Pending') bg-yellow-500
                @elseif($pengajuan->status == 'Diproses') bg-blue-500
                @elseif($pengajuan->status == 'Selesai') bg-green-500
                @else bg-red-500 @endif
                mx-auto mt-3 rounded-full"></div>
        </div>

        {{-- Card Detail --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl">
            <div class="bg-gradient-to-r 
                @if($pengajuan->status == 'Pending') from-yellow-700 to-yellow-600
                @elseif($pengajuan->status == 'Diproses') from-blue-800 to-blue-600
                @elseif($pengajuan->status == 'Selesai') from-green-800 to-green-600
                @else from-red-800 to-red-600 @endif
                py-4 px-6">
                <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-file-alt"></i> 
                    Status: {{ $pengajuan->status }}
                </h2>
                <p class="text-white/80 text-sm mt-1">
                    <i class="fas fa-calendar-alt mr-1"></i> 
                    Terakhir diperbarui: {{ $pengajuan->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="p-6 md:p-8">
                {{-- Status Timeline (Visual) --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between relative">
                        <div class="absolute left-0 right-0 top-1/2 h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
                        
                        <div class="relative z-10 flex flex-col items-center bg-white px-2">
                            <div class="w-10 h-10 rounded-full bg-yellow-500 text-white flex items-center justify-center border-4 border-white shadow">
                                <i class="fas fa-clock text-sm"></i>
                            </div>
                            <span class="text-xs font-semibold mt-2 text-gray-700">Pending</span>
                        </div>
                        
                        <div class="relative z-10 flex flex-col items-center bg-white px-2">
                            <div class="w-10 h-10 rounded-full 
                                @if(in_array($pengajuan->status, ['Diproses','Selesai'])) bg-blue-500 
                                @else bg-gray-300 @endif
                                text-white flex items-center justify-center border-4 border-white shadow">
                                <i class="fas fa-spinner text-sm"></i>
                            </div>
                            <span class="text-xs font-semibold mt-2 text-gray-700">Diproses</span>
                        </div>
                        
                        <div class="relative z-10 flex flex-col items-center bg-white px-2">
                            <div class="w-10 h-10 rounded-full 
                                @if($pengajuan->status == 'Selesai') bg-green-500 
                                @else bg-gray-300 @endif
                                text-white flex items-center justify-center border-4 border-white shadow">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="text-xs font-semibold mt-2 text-gray-700">Selesai</span>
                        </div>
                    </div>
                </div>

                {{-- Informasi Detail dalam Grid --}}
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-hashtag text-blue-500 text-xl mt-0.5"></i>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Nomor Pengajuan</p>
                                <p class="font-mono font-bold text-gray-800 break-all">{{ $pengajuan->nomor_pengajuan }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-user text-blue-500 text-xl mt-0.5"></i>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Nama Lengkap</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->nama }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope-open-text text-purple-500 text-xl mt-0.5"></i>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Jenis Surat</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->jenis_surat }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-day text-green-600 text-xl mt-0.5"></i>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Pengajuan</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->created_at->translatedFormat('l, d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keperluan --}}
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-pencil-alt text-blue-600 text-xl mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-xs text-blue-600 uppercase tracking-wide font-semibold">Keperluan</p>
                            <p class="text-gray-700">{{ $pengajuan->keperluan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Alamat (opsional ditampilkan) --}}
                @if(isset($pengajuan->alamat))
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-red-500 text-xl mt-0.5"></i>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Alamat</p>
                            <p class="text-gray-700">{{ $pengajuan->alamat }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap gap-3 justify-center mt-8">
                    <!-- @if($pengajuan->status == 'Selesai')
                        <a href="#" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-xl transition shadow-md">
                            <i class="fas fa-download"></i> Download Surat
                        </a> -->
                    @endif
                    <a href="{{ route('pengajuan.cek-status') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-xl transition shadow-md">
                        <i class="fas fa-search"></i> Cek Nomor Lain
                    </a>
                    <a href="{{ route('pengajuan.form') }}" class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2.5 px-6 rounded-xl transition shadow-md">
                        <i class="fas fa-plus"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>

            {{-- Footer Informasi --}}
            <div class="bg-gray-50 py-4 px-6 text-center text-sm text-gray-600 border-t">
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="inline-flex items-center gap-1"><i class="fab fa-whatsapp text-green-500"></i> Notifikasi akan dikirim ke WhatsApp</span>
                    <span class="inline-flex items-center gap-1"><i class="fas fa-envelope text-blue-500"></i> Cek email untuk dokumen resmi</span>
                </div>
            </div>
        </div>

        {{-- Informasi Tambahan --}}
        <div class="mt-6 text-center text-xs text-gray-500">
            <p><i class="fas fa-phone-alt"></i> Ada pertanyaan? Hubungi admin desa: 0812-3456-7890</p>
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
@endsection