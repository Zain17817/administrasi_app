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

<<<<<<< HEAD
    return redirect('/admin/detail/'.$id)->with('success', 'Status berhasil diubah');
}

use Illuminate\Support\Facades\Storage;

public function download($file)
{
    $path = 'public/uploads/' . $file;

    if (Storage::exists($path)) {
        return Storage::download($path);
    }

    return back()->with('error', 'File tidak ditemukan');
}
}
=======
        // Ganti dengan autentikasi sesungguhnya (misal cek di .env)
        if ($request->username === 'admin' && $request->password === 'desa123') {
            session(['admin_logged_in' => true]);
            return redirect('/admin/dashboard');
        }
>>>>>>> af9bbc9e36b2eae0fc97d1836c4959577fd3144b

        return back()->with('error', 'Username atau password salah.');
    }

    public function dashboard()
    {
        $pengajuans = Pengajuan::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('pengajuans'));
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