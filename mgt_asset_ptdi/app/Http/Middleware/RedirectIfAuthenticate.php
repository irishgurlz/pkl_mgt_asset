<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        $guards = empty($guards) ? [null] : $guards;
        if(Auth::guard('admin')->check()){
            return redirect('admin/dashboard');
        }
        if(Auth::guard('karyawan')->check()){
            return redirect('karyawan/dashboard');
        }
    }
}
