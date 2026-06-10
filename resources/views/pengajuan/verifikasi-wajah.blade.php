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
                    <div class="relative rounded-xl overflow-hidden shadow-lg bg-black w-full max-w-md">
                        <video id="video" class="w-full h-auto" autoplay playsinline></video>
                        <canvas id="canvas" class="hidden"></canvas>
                    </div>

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

                    <div id="previewContainer" class="mt-6 hidden">
                        <p class="text-sm text-gray-600 mb-2">Foto Selfie:</p>
                        <img id="preview" class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-md">
                    </div>

                    <div id="loading" class="hidden mt-4 text-blue-600">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memverifikasi...
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 py-3 px-6 text-center text-sm text-gray-500 border-t">
                <a href="{{ route('pengajuan.form') }}" class="text-blue-700 hover:underline">← Kembali ke Form Pengajuan</a>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUKSES --}}
<div id="modalSukses" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModalSukses()"></div>
        <div class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 transform transition-all animate-fade-in">
            <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                    <h3 class="text-white font-bold text-lg">Verifikasi Berhasil</h3>
                </div>
                <button onclick="closeModalSukses()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="text-center mb-4">
                    <i class="fas fa-id-card text-green-500 text-5xl mb-3"></i>
                </div>
                <div id="modalSuksesMessage" class="text-gray-700 text-center mb-4"></div>
                
                {{-- Box Nomor Pengajuan + Tombol Copy --}}
                <div id="nomorBox" class="hidden bg-gray-50 rounded-xl p-3 mb-5">
                    <p class="text-xs text-gray-500 mb-1">Nomor Pengajuan</p>
                    <div class="flex items-center justify-between gap-2">
                        <code id="nomorPengajuan" class="text-sm font-mono font-semibold text-gray-800 bg-gray-100 px-3 py-1.5 rounded-lg flex-1 break-all"></code>
                        <button id="btnCopyNomor" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <a id="btnCekStatus" href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition shadow-md text-center flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Cek Status Pengajuan
                    </a>
                    <button onclick="closeModalSukses()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 rounded-xl transition text-center">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ERROR --}}
<div id="modalError" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModalError()"></div>
        <div class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 transform transition-all animate-fade-in">
            <div class="bg-gradient-to-r from-red-600 to-red-500 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    <h3 class="text-white font-bold text-lg">Verifikasi Gagal</h3>
                </div>
                <button onclick="closeModalError()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="text-center mb-4">
                    <i class="fas fa-frown text-red-500 text-5xl mb-3"></i>
                </div>
                <div id="modalErrorMessage" class="text-gray-700 text-center mb-6"></div>
                <button onclick="closeModalError()" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition shadow-md">
                    <i class="fas fa-redo-alt mr-2"></i> Coba Lagi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95) translateY(-20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    body.modal-open {
        overflow: hidden;
    }
</style>

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

        let stream = null;
        let capturedPhoto = null;
        let successRedirectUrl = null;

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (err) {
                openErrorModal('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
                console.error(err);
            }
        }

        function capturePhoto() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');
            capturedPhoto = dataURL;
            previewImg.src = dataURL;
            previewContainer.classList.remove('hidden');
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

        function retakePhoto() {
            capturedPhoto = null;
            previewContainer.classList.add('hidden');
            video.classList.remove('hidden');
            ambilBtn.classList.remove('hidden');
            ulangBtn.classList.add('hidden');
            verifBtn.classList.add('hidden');
            verifBtn.disabled = true;
            startCamera();
        }

        async function verifikasi() {
            if (!capturedPhoto) {
                openErrorModal('Ambil foto terlebih dahulu.');
                return;
            }

            verifBtn.disabled = true;
            loadingDiv.classList.remove('hidden');

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
                    successRedirectUrl = result.redirect;
                    // Tampilkan pesan (bisa HTML)
                    document.getElementById('modalSuksesMessage').innerHTML = result.message;
                    // Jika ada nomor_pengajuan dari server, tampilkan box copy
                    if (result.nomor_pengajuan) {
                        document.getElementById('nomorPengajuan').innerText = result.nomor_pengajuan;
                        document.getElementById('nomorBox').classList.remove('hidden');
                        // Set tombol cek status langsung dengan nomor pengajuan (opsional mengisi form)
                        document.getElementById('btnCekStatus').href = "{{ route('pengajuan.cek-status') }}?nomor=" + encodeURIComponent(result.nomor_pengajuan);
                    } else {
                        document.getElementById('nomorBox').classList.add('hidden');
                        document.getElementById('btnCekStatus').href = successRedirectUrl;
                    }
                    openSuccessModal();
                } else {
                    openErrorModal(result.message || 'Verifikasi gagal. Silakan coba lagi.');
                    verifBtn.disabled = false;
                }
            } catch (err) {
                openErrorModal('Terjadi kesalahan. Periksa koneksi internet.');
                verifBtn.disabled = false;
            } finally {
                loadingDiv.classList.add('hidden');
            }
        }

        function openSuccessModal() {
            document.getElementById('modalSukses').classList.remove('hidden');
            document.body.classList.add('modal-open');
        }

        function closeModalSukses() {
            document.getElementById('modalSukses').classList.add('hidden');
            document.body.classList.remove('modal-open');
            if (successRedirectUrl) {
                window.location.href = successRedirectUrl;
            }
        }

        function openErrorModal(message) {
            document.getElementById('modalErrorMessage').innerText = message;
            document.getElementById('modalError').classList.remove('hidden');
            document.body.classList.add('modal-open');
        }

        function closeModalError() {
            document.getElementById('modalError').classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        // Copy nomor pengajuan
        document.getElementById('btnCopyNomor')?.addEventListener('click', function() {
            const nomorText = document.getElementById('nomorPengajuan').innerText;
            if (nomorText) {
                navigator.clipboard.writeText(nomorText).then(() => {
                    // Tampilkan notifikasi kecil (tooltip) - opsional
                    const btn = document.getElementById('btnCopyNomor');
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                    }, 2000);
                }).catch(() => {
                    alert('Gagal menyalin nomor');
                });
            }
        });

        ambilBtn.addEventListener('click', capturePhoto);
        ulangBtn.addEventListener('click', retakePhoto);
        verifBtn.addEventListener('click', verifikasi);

        startCamera();
    })();
</script>
@endsection