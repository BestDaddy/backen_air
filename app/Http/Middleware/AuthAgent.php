<?php

namespace App\Http\Middleware;

use App\Models\Agent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class AuthAgent extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        if($token){
            $agent = Agent::where('token', $token)->first();
            if ($agent)
                $request->merge(['agent' => $agent]);
            else
                abort(401);
        }

        return redirect('/login');
    }
}
