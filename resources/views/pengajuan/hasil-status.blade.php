@extends('layouts.app')

@section('title', 'Hasil Cek Status')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pengajuan</h2>
        <div class="border rounded-lg p-4 space-y-2">
            <p><strong>Nomor Pengajuan:</strong> {{ $pengajuan->nomor_pengajuan }}</p>
            <p><strong>Nama:</strong> {{ $pengajuan->nama }}</p>
            <p><strong>Jenis Surat:</strong> {{ $pengajuan->jenis_surat }}</p>
            <p><strong>Status:</strong> 
                <span class="px-2 py-1 rounded-full text-sm 
                    @if($pengajuan->status == 'Pending') bg-yellow-200 text-yellow-800
                    @elseif($pengajuan->status == 'Diproses') bg-blue-200 text-blue-800
                    @elseif($pengajuan->status == 'Selesai') bg-green-200 text-green-800
                    @else bg-red-200 text-red-800 @endif">
                    {{ $pengajuan->status }}
                </span>
            </p>
            <p><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Keperluan:</strong> {{ $pengajuan->keperluan }}</p>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('pengajuan.cek-status') }}" class="text-blue-700 hover:underline">Cek Nomor Lain</a> |
            <a href="{{ route('pengajuan.form') }}" class="text-blue-700 hover:underline">Ajukan Surat Baru</a>
        </div>
    </div>
@endsection