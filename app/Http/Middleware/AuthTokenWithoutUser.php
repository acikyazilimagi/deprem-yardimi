<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthTokenWithoutUser
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $key = 'X-AUTH-KEY';

        $token = $request->header($key) ?? $request->get($key);

        if ($token) {
            $AUTH_KEY_STATIC_TOKENS = explode(',', config('app.AUTH_KEY_STATIC'));

            // Geliştirici ekip..
            if (in_array($token, $AUTH_KEY_STATIC_TOKENS)) {
                return $response;
            }

            // Diğer kullanıcılar..
            if (Cache::pull('token:'.$token)) {
                return $response;
            }

            return response()->json(['message' => 'Access denied'], 403);
        } else {
            if ($request->route()->getName() === 'get-token') {
                // TODO : Domain kontrolü doğru çalışmıyor, güvenli hale getirilecek..
                $domain = substr($request->root(), 7);

                if ($domain === config('app.AUTH_DOMAIN')) {
                    $value = mt_rand();

                    Cache::set('token:'.$value, $value);

                    $response->header($key, $value);
                } else {
                    return response()->json(['message' => 'Access denied'], 403);
                }
            } else {
                return response()->json(['message' => 'Access denied'], 403);
            }
        }

        return $response;
    }
}
