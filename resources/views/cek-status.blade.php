<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengajuan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-info text-white">
                    <h5>Cek Status Pengajuan Surat</h5>
                </div>

                <div class="card-body">

                    {{-- FORM --}}
                    <form method="POST" action="/cek-status">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Masukkan Nomor Pengajuan</label>
                            <input type="number" class="form-control" name="no_pengajuan" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Cek Status</button>
                        <a href="/" class="btn btn-secondary">Kembali</a>
                    </form>

                    {{-- ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- HASIL --}}
                    @if(isset($data))
                        <hr>
                        <h6>Detail Pengajuan:</h6>

                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Surat</th>
                                <td>{{ $data->jenis_surat }}</td>
                            </tr>
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
                                <th>Tanggal</th>
                                <td>{{ $data->tanggal }}</td>
                            </tr>
                        </table>
                    @endif

                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>