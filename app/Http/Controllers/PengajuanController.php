<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Upload file
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
            $kkPath = $request->file('kk')->store('kk', 'public');

            // Simpan ke database
            $id = DB::table('pengajuan')->insertGetId([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jenis_surat' => $request->jenis_surat,
                'keperluan' => $request->keperluan,
                'ktp' => $ktpPath,
                'kk' => $kkPath,
                'status' => 'Menunggu'
            ]);

            // Nomor pengajuan
            $kode = 'SR-' . str_pad($id, 5, '0', STR_PAD_LEFT);

            return redirect('/pengajuan')->with([
                'sukses' => 'Pengajuan berhasil dikirim!',
                'nomor_pengajuan' => $kode
            ]);

        } catch (\Exception $e) {
            return redirect('/pengajuan')->with('error', 'Terjadi kesalahan!');
        }
    }
}

class CekStatusController extends Controller
{
    public function cek(Request $request)
    {
        $id = $request->no_pengajuan;

        $data = DB::table('pengajuan')->where('id', $id)->first();

        if (!$data) {
            return redirect('/cek-status')->with('error', 'Nomor pengajuan tidak ditemukan.');
        }

        return view('cek-status', compact('data'));
    }
}

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        // ✅ VALIDASI (pengganti manual validation)
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|numeric',
            'jenis_surat' => 'required',
            'keperluan' => 'required',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            // ✅ Upload file (pengganti uploadFile())
            $ktpPath = $request->file('ktp')->store('uploads/ktp', 'public');
            $kkPath  = $request->file('kk')->store('uploads/kk', 'public');

            // Ambil hanya nama file (opsional, biar mirip versi kamu)
            $ktpName = basename($ktpPath);
            $kkName  = basename($kkPath);

            // ✅ Simpan ke database
            $id = DB::table('pengajuan')->insertGetId([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jenis_surat' => $request->jenis_surat,
                'keperluan' => $request->keperluan,
                'ktp' => $ktpName,
                'kk' => $kkName,
                'status' => 'Menunggu',
                'tanggal' => now()
            ]);

            // ✅ Generate nomor pengajuan
            $kode = 'SR-' . str_pad($id, 5, '0', STR_PAD_LEFT);

            return redirect('/pengajuan')->with([
                'sukses' => 'Pengajuan berhasil dikirim!',
                'nomor_pengajuan' => $kode
            ]);

        } catch (\Exception $e) {
            return redirect('/pengajuan')->with('error', 'Terjadi kesalahan!');
        }
    }
}

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data terbaru
        $data = DB::table('pengajuan')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('admin.index', compact('data'));
    }
}

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // login sederhana (hardcode)
        if ($username === 'admin' && $password === 'admin123') {

            // simpan session Laravel
            session(['admin' => true]);

            return redirect('/admin');
        }

        return redirect('/admin/login')->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin/login');
    }
}