<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Services\Agents\AgentsService;
use App\Services\Logs\LogsService;
use App\Services\Minions\MinionsService;
use App\Services\Parsers\AirParser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentController extends ApiBaseController
{
    private AgentsService $agentsService;
    private MinionsService $minionsService;
    private LogsService $logsService;
    public function __construct(AgentsService $agentsService, MinionsService $minionsService, LogsService $logsService)
    {
        $this->agentsService = $agentsService;
        $this->minionsService = $minionsService;
        $this->logsService = $logsService;
    }
    public function auth(Request $request) {

        $type = $request->header('type');
        $minion = $this->minionsService->auth($request->ip(), $type);
        if ($minion) {
            $token = md5('kekw' . rand(0, 999));
            $expired_at = Carbon::now()->addDay();
            $this->minionsService->update($minion->id, ['token' => $token, 'expired_at' => $expired_at]);

            return $this->makeResponse(200, [
                'token' => $token,
                'expired_at' => $expired_at,
                'minion' => $minion,
            ]);
        } else {
            return $this->makeResponse(401, [
                'message' => 'Unknown ip'
            ]);
        }

    }

    public function me(Request $request) {
        return $this->makeResponse(200, $request->get('minion'));
    }

    public function send(Request $request) {
        return $this->makeResponse(200, [
            'asdf' => AirParser::class
        ]);
//        $log = $request->only('minion_id', 'data');
//        $log['agent_id'] = $request->get('agent')->id;
//
//        $this->logsService->store([], $log);
    }

}
