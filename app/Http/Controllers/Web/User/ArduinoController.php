<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Services\Arduino\ArduinoService;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ArduinoController extends Controller
{
    private ArduinoService $arduinoService;

    public function __construct(ArduinoService $arduinoService)
    {
        $this->arduinoService = $arduinoService;
    }
    public function index() {
        if(request()->ajax()) {
            return $this->arduinoService->datatable([ArduinoService::DATATABLE_BUTTON_EDIT, ArduinoService::DATATABLE_BUTTON_MORE], ['type']);
        }

        return view('user.arduino.index');
    }

    public function show($id) {
        $arduino = $this->arduinoService->findWith($id, ['type']);
        if (empty($arduino)) {
            abort(404);
        }

        if(request()->ajax()) {
            $parser = new $arduino->type->class();
            return datatables()->of($parser->getModel()->query()->where('arduino_id', $arduino->id))->make();
        }

        $chart_options = [
            'chart_title' => 'PPM:',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\BaseLog',
            'where_raw' => 'base_logs.arduino_id = ' . $arduino->id,
            'group_by_field' => 'created_at',
            'aggregate_function' => 'avg',
            'aggregate_field' => 'ppm',
//            'aggregate_transform' => function($value) {
//                return round($value / 100, 2);
//            },
            'filter_period' => 'week',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'chart_color' => "64,66,185"
        ];
        $chart = new LaravelChart($chart_options);



        return view('admin.logs.type_' . $arduino->type->id, compact('arduino', 'chart'));
    }
}
