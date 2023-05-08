<?php

namespace App\Services\Parsers;

use App\Models\BaseLog;
use App\Models\Log;
use App\Utils\Utils;
use Illuminate\Log\Logger;

class BaseParser implements Parser
{
    private $log_id;
    public function __construct($log_id)
    {
        $this->log_id = $log_id;
    }

    public function execute()
    {
        $log = Log::find($this->log_id);
        if (!empty($log)) {
            $data = json_decode($log->data, true);

            $result = BaseLog::create([
                'log_id' => $log->id,
                'ppm' => $data['ppm']
            ]);

            if ($result->ppm > 100) {
                $msg = '*' . 'WARNING' . "*\n" . $log->created_at . "\n*" . 'CO2 PPM (parts per million): '. $result->ppm . "*\n" ;
                Utils::sentTelegram($msg);
            }
        }

    }
}
