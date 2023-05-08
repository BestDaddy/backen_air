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

            if ($result->ppm > 100) {
                $msg = '*' . 'WARNING' . "*\n" . $log->created_at . "\n*" . 'CO2 PPM (parts per million): '. $result->ppm . "*\n" ;
                Utils::sentTelegram($msg);
            }
        }

    }

    public function getModel()
    {
        return $this->model;
    }
}
