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
        $response->header('X-Frame-Options', 'ALLOW-FROM https://dashboardbedas.bandungkab.go.id');
        return $response;
    }
}