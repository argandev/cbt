<?php

namespace App\Http\Middleware;

use App\Models\Siswa;
use App\Repositories\SiswaRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($api_token = $request->bearerToken()) {
            //cek bearer token di pengguna
            $siswa = (new SiswaRepository)->getSiswaByApiToken($api_token)            ;
            if ($siswa && $siswa->api_token === $api_token) {
                $request->attributes->add([
                    'siswa_data' => $siswa,
                ]);
                return $next($request);
            } else {
                return response([
                    'error' => true,
                    'message'  => "!Work"
                ], 401);
            }
        }
        return response([
            'error' => true,
            'message'  => "!Work"
        ], 401);
    }
}
