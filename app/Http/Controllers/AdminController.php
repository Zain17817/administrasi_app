<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function detail($id)
{
    $data = \DB::table('pengajuan')->where('id', $id)->first();

    if (!$data) {
        return redirect('/admin')->with('error', 'Data tidak ditemukan');
    }

    return view('admin.detail', compact('data'));
}

public function updateStatus(Request $request, $id)
{
    \DB::table('pengajuan')
        ->where('id', $id)
        ->update([
            'status' => $request->status
        ]);

    return redirect('/admin/detail/'.$id)->with('success', 'Status berhasil diubah');
}
}

