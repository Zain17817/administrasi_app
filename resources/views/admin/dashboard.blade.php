<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-blue-700 text-white py-3 px-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin</h2>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-1 rounded text-white"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 m-4 rounded">{{ session('success') }}</div>
            @endif
            <div class="overflow-x-auto p-4">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-3 border">No</th>
                            <th class="py-2 px-3 border">Nomor Pengajuan</th>
                            <th class="py-2 px-3 border">Nama</th>
                            <th class="py-2 px-3 border">Nomor Handphone</th>
                            <th class="py-2 px-3 border">Jenis Surat</th>
                            <th class="py-2 px-3 border">Status</th>
                            <th class="py-2 px-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $key => $p)
                        <tr>
                            <td class="py-2 px-3 border text-center">{{ $key+1 }}</td>
                            <td class="py-2 px-3 border">{{ $p->nomor_pengajuan }}</td>
                            <td class="py-2 px-3 border">{{ $p->nama }}</td>
                            <td class="py-2 px-3 border">{{ $p->no_hp }}</td>
                            <td class="py-2 px-3 border">{{ $p->jenis_surat }}</td>
                            <td class="py-2 px-3 border">
                                <span class="px-2 py-1 rounded text-sm 
                                    @if($p->status == 'Pending') bg-yellow-200
                                    @elseif($p->status == 'Diproses') bg-blue-200
                                    @elseif($p->status == 'Selesai') bg-green-200
                                    @else bg-red-200 @endif">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-2 px-3 border">
                                <form action="{{ route('admin.update-status', $p) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border rounded px-2 py-1 text-sm">
                                        <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Diproses" {{ $p->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ $p->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Update</button>
                                     <a href="https://wa.me/{{ $p->no_hp }}" target="_blank"
                                        class="inline-flex items-center justify-center md:justify-start gap-2 text-primary font-medium hover:underline">
                                        Chat
                                     </a>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4">Belum ada data pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>