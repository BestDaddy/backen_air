<?php

namespace App\Http\Middleware;

use App\Models\Arduino;
use App\Models\Minion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class AuthArduino
{
    public function handle( $request, Closure $next)
    {
        $token = $request->header('token');
        if($token){
            $arduino = Arduino::where('token', $token)->first();
            if ($arduino) {
                $request->merge(['arduino' => $arduino]);

                return $next($request);
            }
        }
        abort(401);
    }
}
