<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin Desa</span>
        <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <h3>Daftar Pengajuan Surat</h3>
    <hr>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->no_hp }}</td>
                    <td>{{ $row->jenis_surat }}</td>

                    <td>
                        @php
                            $badge = $row->status == 'Menunggu' ? 'warning' :
                                    ($row->status == 'Diproses' ? 'info' : 'success');
                        @endphp

                        <span class="badge bg-{{ $badge }}">
                            {{ $row->status }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y H:i') }}
                    </td>

                    <td>
                        <a href="/admin/detail/{{ $row->id }}" class="btn btn-sm btn-primary">Detail</a>

                        <a href="https://wa.me/{{ $row->no_hp }}?text=Halo%20{{ urlencode($row->nama) }}%2C%20status%20pengajuan%20Anda%3A%20{{ urlencode($row->status) }}"
                           target="_blank"
                           class="btn btn-sm btn-success">
                           WA
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

</body>
</html>