<?php

namespace App\Listeners;

use App\Events\ParseLog;
use App\Models\ArduinoType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ParseLogListener implements ShouldQueue
{
//    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ParseLog $event): void
    {
        $type = ArduinoType::find($event->arduino_type_id);

        $parser = new $type->class($event->log_id);

        $parser->execute();

        return;
    }
}
