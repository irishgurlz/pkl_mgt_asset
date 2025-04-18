<?php

// app/Http/Middleware/CheckKaryawanMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckKaryawanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('karyawan')->check()) {
            return $next($request);
        }
        
        return redirect()->route('admin.dashboard');  // Redirect jika karyawan mengakses halaman admin
    }
}
