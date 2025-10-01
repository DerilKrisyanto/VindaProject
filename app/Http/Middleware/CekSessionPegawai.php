<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekSessionPegawai
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('pegawai')) {
            return redirect()->route('auth.Login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}
