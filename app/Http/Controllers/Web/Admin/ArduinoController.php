<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Minion;
use App\Services\Arduino\ArduinoService;
use App\Services\ArduinoTypes\ArduinoTypesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $agent = $this->arduinoService->find($id);
        if(request()->ajax()) {
            return datatables()->of($agent->logs()->query())
                ->addColumn('edit', function ($data) {
                    return '<button
                         class=" btn btn-primary btn-sm btn-block "
                          data-id="' . $data->id . '"
                          onclick="editModel(event.target)"><i class="fas fa-edit" data-id="' . $data->id . '"></i> ' . 'Edit' . '</button>';
                })
                ->rawColumns(['edit'])
                ->make();
        }

        return view('admin.arduino.show', compact('agent'));
    }

    public function destroy(string $id)
    {
        $this->arduinoService->delete($id);
        return response()->json(['code' => 200, 'message'=>'Arduino deleted successfully'], 200);
    }
}
