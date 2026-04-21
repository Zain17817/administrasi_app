@extends('layouts.app')

@section('title', 'Verifikasi Wajah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-800 to-blue-600 py-4 px-6">
                <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-camera-retro"></i> 
                    Verifikasi Wajah
                </h2>
                <p class="text-blue-100 text-sm mt-1">Ambil foto selfie untuk verifikasi identitas</p>
            </div>

            <div class="p-6 md:p-8">
                <div class="text-center mb-6">
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-3 rounded-lg text-sm">
                        <i class="fas fa-info-circle mr-2"></i> Pastikan wajah terlihat jelas dan pencahayaan cukup
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    {{-- Video Webcam --}}
                    <div class="relative rounded-xl overflow-hidden shadow-lg bg-black w-full max-w-md">
                        <video id="video" class="w-full h-auto" autoplay playsinline></video>
                        <canvas id="canvas" class="hidden"></canvas>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-wrap gap-4 justify-center mt-6">
                        <button id="ambilFoto" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl transition shadow-md flex items-center gap-2">
                            <i class="fas fa-camera"></i> Ambil Foto
                        </button>
                        <button id="ulangFoto" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-xl transition shadow-md flex items-center gap-2 hidden">
                            <i class="fas fa-redo-alt"></i> Ambil Ulang
                        </button>
                        <button id="verifikasiBtn" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-xl transition shadow-md flex items-center gap-2 hidden" disabled>
                            <i class="fas fa-check-circle"></i> Verifikasi
                        </button>
                    </div>

                    {{-- Preview Foto --}}
                    <div id="previewContainer" class="mt-6 hidden">
                        <p class="text-sm text-gray-600 mb-2">Foto Selfie:</p>
                        <img id="preview" class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-md">
                    </div>

                    {{-- Loading --}}
                    <div id="loading" class="hidden mt-4 text-blue-600">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memverifikasi...
                    </div>

                    {{-- Pesan Error --}}
                    <div id="errorMsg" class="hidden mt-4 text-red-600 text-sm"></div>
                </div>
            </div>

            <div class="bg-gray-50 py-3 px-6 text-center text-sm text-gray-500 border-t">
                <a href="{{ route('pengajuan.form') }}" class="text-blue-700 hover:underline">← Kembali ke Form Pengajuan</a>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ambilBtn = document.getElementById('ambilFoto');
        const ulangBtn = document.getElementById('ulangFoto');
        const verifBtn = document.getElementById('verifikasiBtn');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('preview');
        const loadingDiv = document.getElementById('loading');
        const errorDiv = document.getElementById('errorMsg');

        let stream = null;
        let capturedPhoto = null;

        // Akses kamera
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (err) {
                errorDiv.innerText = 'Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.';
                errorDiv.classList.remove('hidden');
                console.error(err);
            }
        }

        // Ambil foto dari video
        function capturePhoto() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');
            capturedPhoto = dataURL;
            previewImg.src = dataURL;
            previewContainer.classList.remove('hidden');
            // Matikan kamera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
            video.classList.add('hidden');
            ambilBtn.classList.add('hidden');
            ulangBtn.classList.remove('hidden');
            verifBtn.classList.remove('hidden');
            verifBtn.disabled = false;
        }

        // Ulang ambil foto
        function retakePhoto() {
            capturedPhoto = null;
            previewContainer.classList.add('hidden');
            video.classList.remove('hidden');
            ambilBtn.classList.remove('hidden');
            ulangBtn.classList.add('hidden');
            verifBtn.classList.add('hidden');
            verifBtn.disabled = true;
            startCamera(); // restart kamera
        }

        // Kirim foto ke server untuk verifikasi
        async function verifikasi() {
            if (!capturedPhoto) {
                errorDiv.innerText = 'Ambil foto terlebih dahulu.';
                errorDiv.classList.remove('hidden');
                return;
            }

            verifBtn.disabled = true;
            loadingDiv.classList.remove('hidden');
            errorDiv.classList.add('hidden');

            try {
                const response = await fetch('{{ route("pengajuan.verifikasi.proses") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ foto_selfie: capturedPhoto })
                });
                const result = await response.json();
                if (result.success) {
                    // Tampilkan notifikasi sukses
                    alert(result.message);
                    window.location.href = result.redirect;
                } else {
                    errorDiv.innerText = result.message || 'Verifikasi gagal. Silakan coba lagi.';
                    errorDiv.classList.remove('hidden');
                    verifBtn.disabled = false;
                }
            } catch (err) {
                errorDiv.innerText = 'Terjadi kesalahan. Periksa koneksi internet.';
                errorDiv.classList.remove('hidden');
                verifBtn.disabled = false;
            } finally {
                loadingDiv.classList.add('hidden');
            }
        }

        // Event listeners
        ambilBtn.addEventListener('click', capturePhoto);
        ulangBtn.addEventListener('click', retakePhoto);
        verifBtn.addEventListener('click', verifikasi);

        // Mulai kamera saat halaman dimuat
        startCamera();
    })();
</script>
@endsection