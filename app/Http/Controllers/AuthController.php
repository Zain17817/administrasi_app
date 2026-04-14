<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        if ($request->username === 'admin' && $request->password === 'admin123') {
            session(['admin' => true]);
            return redirect('/admin');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin/login');
    }
}