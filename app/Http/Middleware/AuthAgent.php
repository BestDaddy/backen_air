<?php

namespace App\Http\Middleware;

use App\Models\Agent;
use App\Models\Minion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class AuthAgent
{
    public function handle( $request, Closure $next)
    {
        $token = $request->header('token');
        if($token){
            $minion = Minion::where('token', $token)->first();
            if ($minion) {
                $request->merge(['minion' => $minion]);

                return $next($request);
            }
        }
        abort(401);
    }
}
