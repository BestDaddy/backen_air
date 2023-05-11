<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaseLog;
use App\Services\Arduino\ArduinoService;
use App\Services\Logs\LogsService;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class LogController extends Controller
{
    private LogsService $logsService;
    private ArduinoService $arduinoService;
    public function __construct(LogsService $logsService, ArduinoService $arduinoService)
    {
        $this->logsService = $logsService;
        $this->arduinoService = $arduinoService;
    }
    public function index() {
        if(request()->ajax()) {
            return $this->logsService->datatable([LogsService::DATATABLE_BUTTON_EDIT], ['arduino' => function ($q) {$q->select('id', 'name', 'type_id');}, 'arduino.type']);
        }
        return view('admin.logs.index');
    }

//    public function parsedIndex($arduino_id) {
//        $arduino = $this->arduinoService->findWith($arduino_id, ['type']);
//        if (empty($arduino)) {
//            abort(404);
//        }
//
//        if(request()->ajax()) {
//            $parser = new $arduino->type->class();
//            return datatables()->of($parser->getModel()->query()->where('arduino_id', $arduino->id))->make();
//        }
//
//        $chart_options = [
//            'chart_title' => 'PPM:',
//            'report_type' => 'group_by_string',
//            'model' => 'App\Models\BaseLog',
//            'where_raw' => 'base_logs.arduino_id = ' . $arduino->id,
//            'group_by_field' => 'created_at',
//            'aggregate_function' => 'avg',
//            'aggregate_field' => 'ppm',
//            'aggregate_transform' => function($value) {
//                return round($value / 100, 2);
//            },
//            'filter_period' => 'week',
//            'group_by_period' => 'day',
//            'chart_type' => 'line',
//            'chart_color' => "64,66,185"
//        ];
//        $chart = new LaravelChart($chart_options);
//
//
//
//        return view('admin.logs.type_' . $arduino->type->id, compact('arduino', 'chart'));
//    }
}
