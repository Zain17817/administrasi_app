<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin')) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}

// class AdminMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Cek session admin
//         if (!session('admin')) {
//             return redirect('/admin/login');
//         }

//         return $next($request);
//     }
// }