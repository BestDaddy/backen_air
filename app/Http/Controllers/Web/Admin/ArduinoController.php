<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Minion;
use App\Services\Arduino\ArduinoService;
use App\Services\ArduinoTypes\ArduinoTypesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ArduinoController extends Controller
{
    private ArduinoService $arduinoService;
    private ArduinoTypesService $arduinoTypesService;
    public function __construct(ArduinoService $arduinoService, ArduinoTypesService $arduinoTypesService)
    {
        $this->arduinoService = $arduinoService;
        $this->arduinoTypesService = $arduinoTypesService;
    }

    public function index()
    {
        if(request()->ajax()) {
            return $this->arduinoService->datatable([ArduinoService::DATATABLE_BUTTON_EDIT, ArduinoService::DATATABLE_BUTTON_MORE], ['type']);
        }

        $types = $this->arduinoTypesService->all();
        return view('admin.arduino.index', compact('types'));
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), array(
            'id' => 'numeric|nullable',
            'name'=> 'required',
            'type_id' => 'required|exists:arduino_types,id',
            'ip' => 'required|ip|unique:arduino,ip,'. $request->id,
            'config' => 'json',
        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], 400);
        }

        $agent = $this->arduinoService->store(['id' => $request->id], $request->all());
        return response()->json(['code' => 200, 'message'=>'Arduino saved successfully', 'data' => $agent], 200);
    }

    public function edit(string $id)
    {
        return response()->json($this->arduinoService->find($id));
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
            'aggregate_transform' => function($value) {
                return round($value / 100, 2);
            },
            'filter_period' => 'week',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'chart_color' => "64,66,185"
        ];
        $chart = new LaravelChart($chart_options);



        return view('admin.logs.type_' . $arduino->type->id, compact('arduino', 'chart'));
    }

    public function destroy(string $id)
    {
        $this->arduinoService->delete($id);
        return response()->json(['code' => 200, 'message'=>'Arduino deleted successfully'], 200);
    }
}
