<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Ganti dengan autentikasi sesungguhnya (misal cek di .env)
        if ($request->username === 'admin' && $request->password === 'desa123') {
            session(['admin_logged_in' => true]);
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    // Perbaikan: tambahkan parameter Request $request dan filter bulan/tahun
    public function dashboard(Request $request)
    {
        // Ambil parameter filter, default bulan dan tahun saat ini
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Filter data pengajuan berdasarkan bulan & tahun
        $pengajuans = Pengajuan::whereMonth('created_at', $bulan)
                            ->whereYear('created_at', $tahun)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Hitung total & status counts
        $totalBulanan = $pengajuans->count();
        $statusCounts = [
            'Pending' => $pengajuans->where('status', 'Pending')->count(),
            'Diproses' => $pengajuans->where('status', 'Diproses')->count(),
            'Selesai' => $pengajuans->where('status', 'Selesai')->count(),
            'Ditolak' => $pengajuans->where('status', 'Ditolak')->count(),
        ];

        return view('admin.dashboard', compact('pengajuans', 'totalBulanan', 'statusCounts'));
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai,Ditolak'
        ]);

        $pengajuan->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect('/admin/login')->with('success', 'Logout berhasil.');
    }
}