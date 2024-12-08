<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FrameHeadersMiddlewar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Tambahkan logika middleware Anda di sini
        $response = $next($request);
        $response->headers->remove('X-Frame-Options');  // Hapus header jika tidak perlu
        // Atau ubah menjadi 'allow-from' jika perlu
        $response->headers->set('X-Frame-Options', 'ALLOWALL');  // Atau 'SAMEORIGIN' jika diperlukan
        $response->headers->set('Content-Security-Policy', "frame-ancestors *;");
        return $response;
    }
}