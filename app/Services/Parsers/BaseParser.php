<?php

namespace App\Services\Parsers;

use App\Models\BaseLog;
use App\Models\Log;
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
        sleep(5);
        $log = Log::find($this->log_id);
        if (!empty($log)) {
            $data = json_decode($log->data, true);

            BaseLog::create([
                'log_id' => $log->id,
                'ppm' => $data['ppm']
            ]);
        }

    }
}
