<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifPermintaanSuratMasuk;

class PengajuanController extends Controller
{
    // Menampilkan form pengajuan
    public function create()
    {
        return view('pengajuan.form');
    }

    // Menyimpan data sementara ke session, lalu redirect ke verifikasi wajah
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'no_hp'       => 'required|string|max:20',
            'alamat'      => 'required|string',
            'jenis_surat' => 'required|in:Surat Domisili,Surat Usaha,Surat Keterangan Tidak Mampu,Surat Keterangan Lain',
            'keperluan'   => 'required|string',
            'ktp'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_rt'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file sementara ke storage/temp
        $ktpPath = $request->file('ktp')->store('temp/ktp', 'public');
        $kkPath  = $request->file('kk')->store('temp/kk', 'public');
        $suratRtPath = $request->file('surat_rt')->store('temp/surat_rt', 'public');

        // Simpan data ke session
        Session::put('pengajuan_sementara', [
            'nama'        => $validated['nama'],
            'no_hp'       => $validated['no_hp'],
            'alamat'      => $validated['alamat'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan'   => $validated['keperluan'],
            'file_ktp'    => $ktpPath,
            'file_kk'     => $kkPath,
            'file_surat_rt' => $suratRtPath,
        ]);

        return redirect()->route('pengajuan.verifikasi');
    }

    // Tampilkan halaman verifikasi wajah
    public function verifikasiForm()
    {
        if (!Session::has('pengajuan_sementara')) {
            return redirect()->route('pengajuan.form')->with('error', 'Silakan isi form pengajuan terlebih dahulu.');
        }
        return view('pengajuan.verifikasi-wajah');
    }

    // Proses verifikasi wajah (simulasi) & simpan permanen ke database
    public function verifikasiProses(Request $request)
    {
        $request->validate([
            'foto_selfie' => 'required|string'
        ]);

        if (!Session::has('pengajuan_sementara')) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 400);
        }

        $data = Session::get('pengajuan_sementara');

        // Generate nomor unik
        $nomor = $this->generateNomorPengajuan($data['jenis_surat']);

        // Simpan ke database (hilangkan field 'verifikasi_wajah' jika tidak ada di migration)
        $pengajuan = Pengajuan::create([
            'nomor_pengajuan' => $nomor,
            'nama'            => $data['nama'],
            'no_hp'           => $data['no_hp'],
            'alamat'          => $data['alamat'],
            'jenis_surat'     => $data['jenis_surat'],
            'keperluan'       => $data['keperluan'],
            'file_ktp'        => $data['file_ktp'],
            'file_kk'         => $data['file_kk'],
            'file_surat_rt'   => $data['file_surat_rt'],
            'status'          => 'Pending',
        ]);

        // Pindahkan file dari temp ke folder permanen
        $newKtpPath = str_replace('temp/', 'ktp/', $data['file_ktp']);
        $newKkPath  = str_replace('temp/', 'kk/', $data['file_kk']);
        $newSuratRtPath = str_replace('temp/', 'surat_rt/', $data['file_surat_rt']);

        Storage::disk('public')->move($data['file_ktp'], $newKtpPath);
        Storage::disk('public')->move($data['file_kk'], $newKkPath);
        Storage::disk('public')->move($data['file_surat_rt'], $newSuratRtPath);

        $pengajuan->update([
            'file_ktp' => $newKtpPath,
            'file_kk'  => $newKkPath,
            'file_surat_rt' => $newSuratRtPath,
        ]);

        // Simpan foto selfie (opsional)
        $imageData = $request->foto_selfie;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $fileName = 'selfie_' . $pengajuan->nomor_pengajuan . '.png';
        Storage::disk('public')->put('selfie/' . $fileName, base64_decode($imageData));

        // Kirim notifikasi email ke admin desa
        try {
            $adminEmail = env('ADMIN_EMAIL', 'barospkl1234@gmail.com');
            Notification::route('mail', $adminEmail)
                ->notify(new NotifPermintaanSuratMasuk($data, $pengajuan->nomor_pengajuan));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email notifikasi: ' . $e->getMessage());
        }

        // Hapus session
        Session::forget('pengajuan_sementara');

        return response()->json([
            'success' => true,
            'message' => "Verifikasi berhasil! Pengajuan tersimpan.<br>Nomor Pengajuan: <strong>{$pengajuan->nomor_pengajuan}</strong>",
            'nomor_pengajuan' => $pengajuan->nomor_pengajuan,
            'redirect' => route('pengajuan.cek-status')
        ]);
    }

    // Generate nomor pengajuan unik
    private function generateNomorPengajuan($jenisSurat)
    {
        // Ambil singkatan jenis surat (3 huruf)
        $prefix = match ($jenisSurat) {
            'Surat Domisili' => '',
            'Surat Usaha' => 'USA',
            'Surat Keterangan Tidak Mampu' => '',
            'Surat Keterangan Lain' => '',
            default => '',
        };
        
        // Format: PREFIX-YYYYMMDD-XXXX (XXXX = random 4 karakter)
        $date = now()->format('Ymd');
        
        
        return $prefix . '-' . $date ;
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