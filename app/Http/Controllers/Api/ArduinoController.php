<?php

namespace App\Http\Controllers\Api;

use App\Events\ParseLog;
use App\Http\Controllers\ApiBaseController;
use App\Services\Arduino\ArduinoService;
use App\Services\Logs\LogsService;
use App\Services\Minions\MinionsService;
use App\Services\Parsers\BaseParser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArduinoController extends ApiBaseController
{
    private ArduinoService $arduinoService;
    private LogsService $logsService;
    public function __construct(ArduinoService $arduinoService, LogsService $logsService)
    {
        $this->arduinoService = $arduinoService;
        $this->logsService = $logsService;
    }
    public function auth(Request $request) {

        $type = $request->header('type');
        $arduino = $this->arduinoService->auth($request->ip(), $type);
        if ($arduino) {
            $token = md5('kekw' . rand(0, 999));
            $expired_at = Carbon::now()->addDay();
            $this->arduinoService->update($arduino->id, ['token' => $token, 'expired_at' => $expired_at, 'last_seen_at' => Carbon::now()]);

            return $this->makeResponse(200, [
                'token' => $token,
                'expired_at' => $expired_at,
                'arduino' => $arduino,
            ]);
        } else {
            return $this->makeResponse(401, [
                'message' => 'Unknown ip'
            ]);
        }

    }

    public function me(Request $request) {
        return $this->makeResponse(200, $request->get('arduino'));
    }

    public function send(Request $request) {
        $request = $request->merge([
            'data' => $request->data ? json_encode($request->data) : null,
        ]);

        $error = Validator::make($request->all(), array(
            'data' => 'required|json',
        ));

        if($error->fails()) {
            return $this->makeResponse(400, ['errors' => $error->errors()->all()]);
        }
        $arduino = $request->get('arduino');
        $log = [
            'arduino_id' => $arduino->id,
            'data' => $request->get('data')
        ];

        $log = $this->logsService->create($log);

        ParseLog::dispatch($log->id, $arduino->type_id);

        return $this->makeResponse(201, [
            'data' => $log
        ]);
    }

}
