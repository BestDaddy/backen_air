<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Services\Agents\AgentsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgentController extends ApiBaseController
{
    private AgentsService $agentsService;
    public function __construct(AgentsService $agentsService)
    {
        $this->agentsService = $agentsService;
    }
    public function auth(Request $request) {
        $agent = $this->agentsService->firstWhere(['ip' => $request->ip()]);
        if ($agent) {
            $token = md5('kekw' . rand(0, 999));
            $expired_at = Carbon::now()->addDay();
            $this->agentsService->update($agent->id, ['token' => $token, 'expired_at' => $expired_at, 'last_seen_at' => Carbon::now()]);

            return $this->makeResponse(200, [
                'token' => $token,
                'expired_at' => $expired_at,
                'agent' => $agent,
            ]);
        } else {
            return $this->makeResponse(401, [
                'message' => 'Unknown ip'
            ]);
        }

    }

}
