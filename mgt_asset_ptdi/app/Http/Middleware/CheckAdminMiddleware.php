<?php
// app/Http/Middleware/CheckAdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }
        
        return redirect()->route('karyawan.dashboard');  // Redirect jika admin mengakses halaman karyawan
    }
}


