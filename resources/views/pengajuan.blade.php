<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengajuan Surat Online Desa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">

                <div class="card-header bg-primary text-white text-center">
                    <h4>Pengajuan Surat Online Desa</h4>
                </div>

                <div class="card-body">

                    {{-- ✅ Alert Laravel (ganti $_SESSION) --}}
                    @if(session('sukses'))
                        <div class="alert alert-success">
                            {{ session('sukses') }}

                            @if(session('nomor_pengajuan'))
                                <br><strong>Nomor Pengajuan Anda: {{ session('nomor_pengajuan') }}</strong>
                                <br><small>Simpan nomor ini untuk cek status.</small>
                            @endif
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- ✅ Form Laravel --}}
                    <form action="/pengajuan" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP (WhatsApp)</label>
                            <input type="text" class="form-control" name="no_hp" required pattern="[0-9]+">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Surat</label>
                            <select class="form-select" name="jenis_surat" required>
                                <option value="">-- Pilih --</option>
                                <option value="Domisili">Surat Keterangan Kependudukan</option>
                                <option value="Usaha">Surat Keterangan Usaha</option>
                                <option value="Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                                <option value="Keterangan Lain">Surat Keterangan Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keperluan</label>
                            <textarea class="form-control" name="keperluan" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload KTP</label>
                            <input type="file" class="form-control" name="ktp" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload KK</label>
                            <input type="file" class="form-control" name="kk" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </div>

                    </form>

                    <hr>

                    <div class="text-center">
                        <a href="/cek-status" class="btn btn-outline-secondary">Cek Status</a>
                        <a href="/admin/login" class="btn btn-outline-dark">Login Admin</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>