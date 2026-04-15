{{-- resources/views/pengajuan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Online | Desa Sejahtera</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-teal-100 py-10 font-sans">

<div class="container mx-auto px-4 max-w-3xl">
    <!-- Header -->
    <div class="text-center mb-6">
        <i class="fas fa-tree text-5xl text-green-700"></i>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">Desa Sejahtera</h1>
        <p class="text-gray-600">Layanan Surat Online | Cepat & Transparan</p>
    </div>

    <!-- Kartu Utama -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap bg-gray-50 border-b">
            <button id="tabForm" class="tab-btn active flex-1 py-3 px-4 text-center font-semibold transition hover:bg-green-50">
                <i class="fas fa-edit mr-1"></i> Ajukan
            </button>
            <button id="tabCek" class="tab-btn flex-1 py-3 px-4 text-center font-semibold transition hover:bg-green-50">
                <i class="fas fa-search mr-1"></i> Cek Status
            </button>
            <button id="tabAdmin" class="tab-btn flex-1 py-3 px-4 text-center font-semibold transition hover:bg-green-50">
                <i class="fas fa-user-shield mr-1"></i> Admin
            </button>
        </div>

        <div class="p-6 md:p-8">
            @if(session('sukses'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800">
                    {{ session('sukses') }}<br>
                    <strong>Nomor Pengajuan: {{ session('nomor_pengajuan') }}</strong><br>
                    <small>Simpan nomor ini untuk cek status.</small>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800">{{ session('error') }}</div>
            @endif

            <!-- ========= FORM PENGAJUAN ========= -->
            <div id="formSection">
                <h3 class="text-xl font-bold text-gray-700 mb-4"><i class="fas fa-file-alt text-green-600 mr-2"></i>Form Pengajuan</h3>
                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div><label class="block font-medium">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400" required></div>
                    <div><label class="block font-medium">Nomor HP (WA) <span class="text-red-500">*</span></label>
                        <input type="tel" name="no_hp" class="w-full border border-gray-300 rounded-lg px-4 py-2" pattern="[0-9]+" required></div>
                    <div><label class="block font-medium">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2" required></textarea></div>
                    <div><label class="block font-medium">Jenis Surat <span class="text-red-500">*</span></label>
                        <select name="jenis_surat" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Domisili">Surat Domisili</option>
                            <option value="Usaha">Surat Usaha</option>
                            <option value="Tidak Mampu">Surat Tidak Mampu</option>
                            <option value="Keterangan Lain">Keterangan Lain</option>
                        </select></div>
                    <div><label class="block font-medium">Keperluan <span class="text-red-500">*</span></label>
                        <textarea name="keperluan" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2" required></textarea></div>
                    <div><label class="block font-medium">Upload KTP <span class="text-red-500">*</span></label>
                        <input type="file" name="ktp" accept="image/*,application/pdf" class="w-full border border-gray-300 rounded-lg p-2" required></div>
                    <div><label class="block font-medium">Upload KK <span class="text-red-500">*</span></label>
                        <input type="file" name="kk" accept="image/*,application/pdf" class="w-full border border-gray-300 rounded-lg p-2" required></div>
                    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 rounded-xl transition"><i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan</button>
                </form>
            </div>

            <!-- ========= CEK STATUS (AJAX) ========= -->
            <div id="cekSection" class="hidden">
                <h3 class="text-xl font-bold text-gray-700 mb-4"><i class="fas fa-clipboard-list text-green-600 mr-2"></i>Cek Status Surat</h3>
                <div class="flex gap-2">
                    <input type="text" id="nomorCek" placeholder="Masukkan nomor pengajuan" class="flex-1 border border-gray-300 rounded-lg px-4 py-2">
                    <button id="btnCek" class="bg-green-700 hover:bg-green-800 text-white px-5 rounded-lg"><i class="fas fa-check"></i> Cek</button>
                </div>
                <div id="hasilCek" class="mt-5"></div>
            </div>

            <!-- ========= ADMIN ========= -->
            <div id="adminSection" class="hidden">
                <div class="text-center">
                    <a href="{{ route('admin.login') }}" class="inline-block bg-green-700 text-white px-6 py-2 rounded-lg"><i class="fas fa-sign-in-alt mr-2"></i> Login sebagai Admin</a>
                    <p class="text-gray-500 text-sm mt-2">Akses khusus petugas desa</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 text-center text-xs text-gray-500 py-3 border-t">Simpan nomor pengajuan untuk lacak status</div>
    </div>
</div>

<script>
    // Tab navigation
    const tabs = document.querySelectorAll('.tab-btn');
    const sections = {
        form: document.getElementById('formSection'),
        cek: document.getElementById('cekSection'),
        admin: document.getElementById('adminSection')
    };
    function setActiveTab(active) {
        Object.values(sections).forEach(sec => sec.classList.add('hidden'));
        sections[active].classList.remove('hidden');
        tabs.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-800'));
        if (active === 'form') tabs[0].classList.add('bg-green-100', 'text-green-800');
        else if (active === 'cek') tabs[1].classList.add('bg-green-100', 'text-green-800');
        else tabs[2].classList.add('bg-green-100', 'text-green-800');
    }
    tabs[0].addEventListener('click', () => setActiveTab('form'));
    tabs[1].addEventListener('click', () => setActiveTab('cek'));
    tabs[2].addEventListener('click', () => setActiveTab('admin'));
    setActiveTab('form');

    // Cek Status AJAX
    document.getElementById('btnCek').addEventListener('click', async () => {
        const nomor = document.getElementById('nomorCek').value.trim();
        const hasilDiv = document.getElementById('hasilCek');
        if (!nomor) {
            hasilDiv.innerHTML = `<div class="bg-yellow-100 p-3 rounded">Masukkan nomor pengajuan</div>`;
            return;
        }
        try {
            const res = await fetch(`/cek-status?nomor=${encodeURIComponent(nomor)}`);
            if (!res.ok) throw new Error();
            const data = await res.json();
            if (!data) throw new Error();
            let statusClass = {
                Pending: 'bg-yellow-100 text-yellow-800',
                Diproses: 'bg-blue-100 text-blue-800',
                Selesai: 'bg-green-100 text-green-800',
                Ditolak: 'bg-red-100 text-red-800'
            }[data.status] || 'bg-gray-100';
            hasilDiv.innerHTML = `
                <div class="border rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between"><span class="font-bold">${data.nomor_pengajuan}</span><span class="px-2 py-0.5 rounded-full text-xs ${statusClass}">${data.status}</span></div>
                    <hr class="my-2">
                    <p><strong>Nama:</strong> ${data.nama}</p>
                    <p><strong>Jenis:</strong> ${data.jenis_surat}</p>
                    <p><strong>Keperluan:</strong> ${data.keperluan}</p>
                    <p><strong>Alamat:</strong> ${data.alamat}</p>
                    <p><strong>File:</strong> ${data.file_ktp.split('/').pop()}, ${data.file_kk.split('/').pop()}</p>
                    <small class="text-gray-500">Tanggal: ${new Date(data.created_at).toLocaleString()}</small>
                </div>`;
        } catch (err) {
            hasilDiv.innerHTML = `<div class="bg-red-100 p-3 rounded">Nomor tidak ditemukan</div>`;
        }
    });
</script>
</body>
</html>