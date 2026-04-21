<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('logo kec kedungwuni.png') }}" type="image/png">
    <style>
        .transition-custom {
            transition: all 0.2s ease;
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        .modal-container {
            animation: modalSlideIn 0.3s ease-out;
        }
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        body.modal-open {
            overflow: hidden;
        }
        .file-preview {
            max-height: 150px;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 py-8 px-4 sm:px-6 font-sans">
    <div class="container mx-auto max-w-7xl">
        <!-- Card Dashboard -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-tachometer-alt"></i> 
                    <span>Dashboard Admin</span>
                </h2>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-md transition-custom flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded-lg shadow-sm flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- ==================== FITUR REKAP BULANAN ==================== -->
            <div class="px-6 pt-6">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-5 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                        <i class="fas fa-chart-line text-blue-600"></i> Rekap Data Bulanan
                    </h3>
                    
                    <!-- Form Filter Bulan & Tahun -->
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-end gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                            <select name="bulan" class="border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-400">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan', date('m')) == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <select name="tahun" class="border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-400">
                                @for ($i = date('Y'); $i >= date('Y')-3; $i--)
                                    <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition-custom flex items-center gap-2">
                                <i class="fas fa-filter"></i> Tampilkan
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow transition-custom inline-flex items-center gap-2">
                                <i class="fas fa-undo-alt"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Statistik Ringkasan (Card) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Pengajuan</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $totalBulanan ?? 0 }}</p>
                                </div>
                                <i class="fas fa-file-alt text-blue-400 text-3xl"></i>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-yellow-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $statusCounts['Pending'] ?? 0 }}</p>
                                </div>
                                <i class="fas fa-clock text-yellow-400 text-3xl"></i>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Diproses</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $statusCounts['Diproses'] ?? 0 }}</p>
                                </div>
                                <i class="fas fa-spinner fa-pulse text-blue-400 text-3xl"></i>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Selesai</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $statusCounts['Selesai'] ?? 0 }}</p>
                                </div>
                                <i class="fas fa-check-circle text-green-400 text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Pengajuan -->
            <div class="p-4 md:p-6 overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nomor Pengajuan</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nomor Handphone</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Jenis Surat</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pengajuans as $key => $p)
                            <tr class="hover:bg-gray-50 transition-custom" data-id="{{ $p->id }}">
                                <td class="py-3 px-4 text-sm text-gray-800">{{ $key+1 }}</td>
                                <td class="py-3 px-4 text-sm font-mono text-gray-700">{{ $p->nomor_pengajuan }}</td>
                                <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $p->nama }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $p->no_hp }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $p->jenis_surat }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <!-- Tombol Detail -->
                                        <button type="button" 
                                                onclick="openDetailModal({{ $p->id }}, '{{ $p->nomor_pengajuan }}', '{{ addslashes($p->nama) }}', '{{ $p->jenis_surat }}', '{{ $p->status }}', '{{ $p->file_ktp }}', '{{ $p->file_kk }}', '{{ $p->file_surat_rt }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-custom inline-flex items-center gap-1">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </button>
                                        
                                        <!-- Tombol Chat -->
                                        <button type="button" 
                                                onclick="openChatModal('{{ $p->no_hp }}', '{{ addslashes($p->nama) }}', '{{ $p->nomor_pengajuan }}', '{{ $p->jenis_surat }}', '{{ $p->status }}')"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-custom inline-flex items-center gap-1">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </button>
                                    </div>
                                </td>
                             </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 bg-gray-50">
                                    <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                    Tidak ada data pengajuan untuk bulan dan tahun yang dipilih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 px-6 py-3 bg-gray-50 text-right text-xs text-gray-500">
                Total Pengajuan (filter): {{ $pengajuans->count() ?? 0 }}
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengajuan -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="modal-overlay fixed inset-0" onclick="closeDetailModal()"></div>
            
            <div class="modal-container bg-white rounded-2xl shadow-2xl max-w-3xl w-full mx-auto relative z-10 transform transition-all">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                        <h3 class="text-white font-bold text-lg">Detail Pengajuan</h3>
                    </div>
                    <button onclick="closeDetailModal()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- Informasi Pengajuan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">Nomor Pengajuan</p>
                            <p class="font-mono font-semibold text-gray-800" id="detailNomor">-</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800" id="detailNama">-</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">Jenis Surat</p>
                            <p class="text-gray-800" id="detailJenisSurat">-</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">Status Saat Ini</p>
                            <span id="detailStatusBadge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"></span>
                        </div>
                    </div>

                    <!-- Form Update Status -->
                    <div class="border-t border-gray-200 pt-5 mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-sync-alt text-blue-500"></i> Ubah Status
                        </h4>
                        <form id="updateStatusForm" method="POST" action="">
                            @csrf
                            @method('PATCH')
                            <div class="flex flex-wrap gap-3 items-end">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-400">
                                        <option value="Pending">Pending</option>
                                        <option value="Diproses">Diproses</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-custom flex items-center gap-2">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Preview File Upload -->
                    <div class="border-t border-gray-200 pt-5">
                        <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-paperclip text-blue-500"></i> Dokumen Pendukung
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- KTP -->
                            <div class="bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-sm font-medium text-gray-700 mb-2">Foto KTP</p>
                                <div id="ktpPreview" class="flex justify-center">
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-2xl"></i>
                                    </div>
                                </div>
                                <a id="ktpLink" href="#" target="_blank" class="text-xs text-blue-600 mt-2 inline-block hover:underline">Lihat file</a>
                            </div>
                            <!-- KK -->
                            <div class="bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-sm font-medium text-gray-700 mb-2">Foto KK</p>
                                <div id="kkPreview" class="flex justify-center">
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-2xl"></i>
                                    </div>
                                </div>
                                <a id="kkLink" href="#" target="_blank" class="text-xs text-blue-600 mt-2 inline-block hover:underline">Lihat file</a>
                            </div>
                            <!-- Surat Rekomendasi RT -->
                            <div class="bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-sm font-medium text-gray-700 mb-2">Surat Rekomendasi RT</p>
                                <div id="suratRtPreview" class="flex justify-center">
                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-file-pdf text-2xl"></i>
                                    </div>
                                </div>
                                <a id="suratRtLink" href="#" target="_blank" class="text-xs text-blue-600 mt-2 inline-block hover:underline">Lihat file</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Chat Otomatis (sama seperti sebelumnya) -->
    <div id="chatModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="modal-overlay fixed inset-0" onclick="closeChatModal()"></div>
            
            <div class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 transform transition-all">
                <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="fab fa-whatsapp text-white text-2xl"></i>
                        <h3 class="text-white font-bold text-lg">Chat via WhatsApp</h3>
                    </div>
                    <button onclick="closeChatModal()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- Informasi Penerima -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-5">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-user-circle text-green-600 text-2xl"></i>
                            <div>
                                <p class="text-xs text-gray-500">Penerima</p>
                                <p class="font-semibold text-gray-800" id="penerimaNama">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-green-600"></i>
                            <div>
                                <p class="text-xs text-gray-500">Nomor WhatsApp</p>
                                <p class="font-mono text-sm text-gray-700" id="penerimaNoHp">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-2">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            <div>
                                <p class="text-xs text-gray-500">Jenis Surat</p>
                                <p class="text-sm text-gray-700" id="penerimaJenisSurat">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Template Pesan -->
                    <label class="block font-semibold text-gray-700 mb-2">
                        <i class="fas fa-comment-dots text-green-500 mr-2"></i>Template Pesan
                    </label>
                    <select id="templatePesan" class="w-full border border-gray-300 rounded-xl px-4 py-2 mb-4 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="default">📝 Pilih template pesan...</option>
                        <option value="konfirmasi">✅ Konfirmasi Pengajuan</option>
                        <option value="diproses">⚙️ Pengajuan Diproses</option>
                        <option value="selesai">🎉 Pengajuan Selesai</option>
                        <option value="ditolak">❌ Pengajuan Ditolak</option>
                        <option value="verifikasi">📋 Verifikasi Berkas</option>
                        <option value="custom">✏️ Custom / Tulis Sendiri</option>
                    </select>

                    <textarea id="pesanText" rows="8" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Tulis pesan Anda di sini..."></textarea>

                    <div class="flex gap-3 mt-6">
                        <a id="kirimWaLink" href="#" target="_blank" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl transition text-center flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                        </a>
                        <button onclick="closeChatModal()" class="px-4 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-xl transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---------- Detail Modal ----------
        let currentPengajuanId = null;

        function openDetailModal(id, nomor, nama, jenisSurat, status, fileKtp, fileKk, fileSuratRt) {
            currentPengajuanId = id;
            document.getElementById('detailNomor').innerText = nomor;
            document.getElementById('detailNama').innerText = nama;
            document.getElementById('detailJenisSurat').innerText = jenisSurat;
            
            // Set status badge
            const statusBadge = document.getElementById('detailStatusBadge');
            let badgeClass = '';
            if (status === 'Pending') badgeClass = 'bg-yellow-100 text-yellow-800';
            else if (status === 'Diproses') badgeClass = 'bg-blue-100 text-blue-800';
            else if (status === 'Selesai') badgeClass = 'bg-green-100 text-green-800';
            else badgeClass = 'bg-red-100 text-red-800';
            statusBadge.innerHTML = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">${status}</span>`;
            
            // Set form action update status
            const form = document.getElementById('updateStatusForm');
            form.action = "{{ url('admin/update-status') }}/" + id;
            
            // Set value dropdown status sesuai status saat ini
            const statusSelect = form.querySelector('select[name="status"]');
            if (statusSelect) {
                statusSelect.value = status;
            }
            
            // Preview files
            const storageUrl = "/storage/";
            const ktpFull = storageUrl + fileKtp;
            const kkFull = storageUrl + fileKk;
            const suratRtFull = storageUrl + fileSuratRt;
            
            function setPreview(containerId, linkId, fileUrl, isImage = true) {
                const container = document.getElementById(containerId);
                const link = document.getElementById(linkId);

                if (!fileUrl) {
                    container.innerHTML = `<div class="text-gray-400 text-sm">Tidak ada file</div>`;
                    link.style.display = 'none';
                    return;
                }

                link.href = fileUrl;
                link.style.display = 'inline-block';

                if (isImage) {
                    container.innerHTML = `<img src="${fileUrl}" class="w-full h-32 object-cover rounded-lg">`;
                } else {
                    container.innerHTML = `<div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                        <i class="fas fa-file-pdf text-3xl"></i>
                    </div>`;
                }
            }
            
            // Cek ekstensi file untuk menentukan apakah gambar atau pdf
            const isImageKtp = /\.(jpeg|jpg|png|gif)$/i.test(fileKtp);
            const isImageKk = /\.(jpeg|jpg|png|gif)$/i.test(fileKk);
            const isImageSurat = /\.(jpeg|jpg|png|gif)$/i.test(fileSuratRt);
            
            setPreview('ktpPreview', 'ktpLink', ktpFull, isImageKtp);
            setPreview('kkPreview', 'kkLink', kkFull, isImageKk);
            setPreview('suratRtPreview', 'suratRtLink', suratRtFull, isImageSurat);
            
            document.getElementById('detailModal').classList.remove('hidden');
            document.body.classList.add('modal-open');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        // ---------- Chat Modal (sama seperti sebelumnya) ----------
        let currentData = {
            no_hp: '',
            nama: '',
            nomor_pengajuan: '',
            jenis_surat: '',
            status: ''
        };

        function openChatModal(no_hp, nama, nomor_pengajuan, jenis_surat, status) {
            currentData = {
                no_hp: no_hp,
                nama: nama,
                nomor_pengajuan: nomor_pengajuan,
                jenis_surat: jenis_surat,
                status: status
            };
            
            document.getElementById('penerimaNama').innerText = nama;
            document.getElementById('penerimaNoHp').innerText = no_hp;
            document.getElementById('penerimaJenisSurat').innerText = jenis_surat;
            
            document.getElementById('templatePesan').value = 'default';
            document.getElementById('pesanText').value = '';
            
            document.getElementById('chatModal').classList.remove('hidden');
            document.body.classList.add('modal-open');
        }

        function closeChatModal() {
            document.getElementById('chatModal').classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        const templates = {
            konfirmasi: `Halo {nama},

Kami telah menerima pengajuan surat Anda dengan detail:
📋 Nomor Pengajuan: {nomor_pengajuan}
📄 Jenis Surat: {jenis_surat}
📅 Tanggal Pengajuan: {{ date('d/m/Y H:i') }}

Status saat ini: *PENDING*

Mohon ditunggu proses verifikasi dari petugas desa.

Terima kasih.

*Desa Sejahtera*`,

            diproses: `Halo {nama},

Pengajuan surat Anda dengan nomor *{nomor_pengajuan}* sedang *DIPROSES* oleh petugas desa.

Kami akan menginformasikan kembali setelah surat selesai.

Terima kasih atas kesabarannya.

*Desa Sejahtera*`,

            selesai: `🎉 *Halo {nama}* 🎉

Selamat! Pengajuan surat Anda dengan nomor *{nomor_pengajuan}* telah *SELESAI*.

Surat dapat diambil di Kantor Desa Sejahtera atau akan kami kirimkan via email/WhatsApp.

Terima kasih telah menggunakan layanan surat online Desa Sejahtera.

*Desa Sejahtera*`,

            ditolak: `Halo {nama},

Mohon maaf, pengajuan surat Anda dengan nomor *{nomor_pengajuan}* *DITOLAK*.

Alasan: [Isi alasan penolakan]

Silakan lengkapi persyaratan yang kurang dan ajukan kembali.

Terima kasih.

*Desa Sejahtera*`,

            verifikasi: `Halo {nama},

Kami perlu melakukan verifikasi berkas untuk pengajuan surat *{nomor_pengajuan}*.

Mohon segera menghubungi nomor 0812-3456-7890 untuk konfirmasi data.

Terima kasih.

*Desa Sejahtera*`
        };

        function replaceVariables(text, data) {
            return text
                .replace(/{nama}/g, data.nama)
                .replace(/{nomor_pengajuan}/g, data.nomor_pengajuan)
                .replace(/{jenis_surat}/g, data.jenis_surat);
        }

        document.getElementById('templatePesan')?.addEventListener('change', function() {
            const templateValue = this.value;
            const pesanTextarea = document.getElementById('pesanText');
            if (templateValue !== 'default' && templates[templateValue]) {
                let pesan = templates[templateValue];
                pesan = replaceVariables(pesan, currentData);
                pesanTextarea.value = pesan;
            } else if (templateValue === 'custom') {
                pesanTextarea.value = '';
            } else {
                pesanTextarea.value = '';
            }
            updateWhatsAppLink();
        });

        document.getElementById('pesanText')?.addEventListener('input', function() {
            updateWhatsAppLink();
        });

        function updateWhatsAppLink() {
            const noHp = currentData.no_hp;
            const pesan = document.getElementById('pesanText').value;
            if (noHp && pesan) {
                const encodedMessage = encodeURIComponent(pesan);
                document.getElementById('kirimWaLink').href = `https://wa.me/${noHp}?text=${encodedMessage}`;
            } else if (noHp) {
                document.getElementById('kirimWaLink').href = `https://wa.me/${noHp}`;
            }
        }

        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
                closeDetailModal();
                closeChatModal();
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDetailModal();
                closeChatModal();
            }
        });
    </script>
</body>
</html>