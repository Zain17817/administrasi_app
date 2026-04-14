<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <h3>Detail Pengajuan #{{ $data->id }}</h3>

    <a href="/admin" class="btn btn-secondary mb-3">← Kembali</a>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table">
                <tr><th>Nama</th><td>{{ $data->nama }}</td></tr>
                <tr><th>No HP</th><td>{{ $data->no_hp }}</td></tr>
                <tr><th>Jenis Surat</th><td>{{ $data->jenis_surat }}</td></tr>
                <tr><th>Keperluan</th><td>{{ $data->keperluan }}</td></tr>
                <tr><th>Tanggal</th><td>{{ $data->tanggal }}</td></tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @php
                            $badge = $data->status == 'Menunggu' ? 'warning' :
                                    ($data->status == 'Diproses' ? 'info' : 'success');
                        @endphp

                        <span class="badge bg-{{ $badge }}">
                            {{ $data->status }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>KTP</th>
                    <td>
                        <a href="{{ asset('storage/uploads/ktp/'.$data->ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat KTP
                        </a>
                    </td>
                </tr>

                <tr>
                    <th>KK</th>
                    <td>
                        <a href="{{ asset('storage/uploads/kk/'.$data->kk) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat KK
                        </a>
                    </td>
                </tr>
            </table>

            {{-- UBAH STATUS --}}
            <hr>
            <h5>Ubah Status</h5>

            <form method="POST" action="/admin/detail/{{ $data->id }}" class="row g-2">
                @csrf

                <div class="col-auto">
                    <select name="status" class="form-select">

                        <option value="Menunggu" {{ $data->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ $data->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ $data->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>

                    </select>
                </div>

                <div class="col-auto">
                    <button class="btn btn-warning">Update Status</button>
                </div>
            </form>

            {{-- WHATSAPP --}}
            <hr>
            <h5>Kirim Notifikasi WhatsApp</h5>

            <a href="https://wa.me/{{ $data->no_hp }}?text=Halo%20{{ urlencode($data->nama) }}%2C%20status%20pengajuan%20Anda%3A%20{{ urlencode($data->status) }}"
               target="_blank"
               class="btn btn-success">
                Kirim WA
            </a>

        </div>
    </div>
</div>

</body>
</html>