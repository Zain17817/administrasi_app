<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Konsistensi transisi untuk semua interaksi */
        .transition-custom {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 py-8 px-4 sm:px-6 font-sans">
    <div class="container mx-auto max-w-7xl">
        <!-- Card Dashboard -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <!-- Header dengan gaya konsisten -->
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

            <!-- Notifikasi sukses dengan gaya konsisten -->
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded-lg shadow-sm flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabel dengan padding dan margin konsisten -->
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
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pengajuans as $key => $p)
                            <tr class="hover:bg-gray-50 transition-custom">
                                <td class="py-3 px-4 text-sm text-gray-800">{{ $key+1 }}</td>
                                <td class="py-3 px-4 text-sm font-mono text-gray-700">{{ $p->nomor_pengajuan }}</td>
                                <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $p->nama }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $p->no_hp }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $p->jenis_surat }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($p->status == 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($p->status == 'Diproses') bg-blue-100 text-blue-800
                                        @elseif($p->status == 'Selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <form action="{{ route('admin.update-status', $p) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="border border-gray-300 rounded-lg px-2 py-1.5 text-sm bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-custom">
                                                <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Diproses" {{ $p->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Selesai" {{ $p->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-custom">
                                                <i class="fas fa-sync-alt mr-1"></i> Update
                                            </button>
                                        </form>
                                        <a href="https://wa.me/{{ $p->no_hp }}" target="_blank" 
                                           class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-custom">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500 bg-gray-50">
                                    <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                    Belum ada data pengajuan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer opsional dengan margin konsisten -->
            <div class="border-t border-gray-200 px-6 py-3 bg-gray-50 text-right text-xs text-gray-500">
                Total Pengajuan: {{ $pengajuans->count() ?? 0 }}
            </div>
        </div>
    </div>
</body>
</html>