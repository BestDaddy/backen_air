<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Logs\LogsService;

class LogController extends Controller
{
    private LogsService $logsService;
    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;
    }
    public function index() {
        if(request()->ajax()) {
            return $this->logsService->datatable([LogsService::DATATABLE_BUTTON_EDIT], ['arduino' => function ($q) {$q->select('id', 'name', 'type_id');}, 'arduino.type']);
        }
        return view('admin.logs.index');
    }
}
