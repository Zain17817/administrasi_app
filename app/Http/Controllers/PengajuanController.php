<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    // Menampilkan form pengajuan
    public function create()
    {
        return view('pengajuan.form');
    }

    // Menyimpan pengajuan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'no_hp'     => 'required|string|max:20',
            'alamat'    => 'required|string',
            'jenis_surat' => 'required|in:Surat Domisili,Surat Usaha,Surat Keterangan Tidak Mampu,Surat Keterangan Lain',
            'keperluan' => 'required|string',
            'ktp'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_rt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file
        $fileKtp = $request->file('ktp')->store('ktp', 'public');
        $fileKk  = $request->file('kk')->store('kk', 'public');
        $fileSuratRt = $request->file('surat_rt')->store('surat_rt', 'public');

        // Generate nomor unik
        $nomor = 'SRT-' . now()->format('YmdHis') . '-' . Str::random(4);

        $pengajuan = Pengajuan::create([
            'nomor_pengajuan' => $nomor,
            'nama'            => $validated['nama'],
            'no_hp'           => $validated['no_hp'],
            'alamat'          => $validated['alamat'],
            'jenis_surat'     => $validated['jenis_surat'],
            'keperluan'       => $validated['keperluan'],
            'file_ktp'        => $fileKtp,
            'file_kk'         => $fileKk,
            'file_surat_rt'   => $fileSuratRt,
            'status'          => 'Pending',
        ]);

        return redirect()->route('pengajuan.form')->with('success', "Pengajuan berhasil!<br>Nomor Pengajuan: <strong>{$pengajuan->nomor_pengajuan}</strong><br>Simpan nomor ini untuk cek status.");
    }

    // Form cek status
    public function cekStatusForm()
    {
        return view('pengajuan.cek-status');
    }

    // Proses cek status
    public function cekStatus(Request $request)
    {
        $request->validate([
            'nomor_pengajuan' => 'required|string|exists:pengajuans,nomor_pengajuan'
        ]);

        $pengajuan = Pengajuan::where('nomor_pengajuan', $request->nomor_pengajuan)->firstOrFail();
        return view('pengajuan.hasil-status', compact('pengajuan'));
    }
}