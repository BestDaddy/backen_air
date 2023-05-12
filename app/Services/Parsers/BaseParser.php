<?php

namespace App\Services\Parsers;

use App\Models\BaseLog;
use App\Models\Log;
use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Log\Logger;

class BaseParser implements Parser
{
    private Model $model;

    public function __construct()
    {
        $this->model = new BaseLog;
    }

    public function execute($log_id)
    {
        $log = Log::find($log_id);
        if (!empty($log)) {
            $data = json_decode($log->data, true);

            $result = $this->model::create([
                'arduino_id' => $log->arduino_id,
                'log_id' => $log->id,
                'ppm' => $data['ppm']
            ]);

            if ($result->ppm <= 1) {
                $result->loadMissing(['arduino']);
                $ppm = 1000 / ($result->ppm !=0 ? $result->ppm : 0.1);
                $msg = '*' . 'WARNING' . "*\n" . $log->created_at . "\n*" . 'PPM (parts per million): '. $ppm . "*\n";
                $msg .= '*Arduino:' . data_get($result, 'arduino.name') . '*\n';
                Utils::sentTelegram($msg);
            }
        }

    }

    public function getModel()
    {
        return $this->model;
    }
}
