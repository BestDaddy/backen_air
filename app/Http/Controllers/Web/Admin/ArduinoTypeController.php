<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArduinoTypes\ArduinoTypesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArduinoTypeController extends Controller
{
    private ArduinoTypesService $minionTypesService;
    public function __construct(ArduinoTypesService $minionTypesService)
    {
        $this->minionTypesService = $minionTypesService;
    }

    public function index() {
        if(request()->ajax()) {
            return $this->minionTypesService->datatable([ArduinoTypesService::DATATABLE_BUTTON_EDIT], []);
        }

        return view('admin.arduino_types.index');
    }

    public function store(Request $request) {
        $error = Validator::make($request->all(), array(
            'id' => 'numeric|nullable',
            'name' => 'required|max:255',
            'class' => 'required|max:255',

        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], 400);
        }

        $minion = $this->minionTypesService->store(['id' => $request->id], $request->all());
        return response()->json(['code' => 200, 'message'=>'ArduinoType saved successfully', 'data' => $minion], 200);
    }

    public function edit($id) {
        return response()->json($this->minionTypesService->find($id));
    }

    public function destroy(string $id)
    {
        $this->minionTypesService->delete($id);
        return response()->json(['code' => 200, 'message'=>'ArduinoType deleted successfully'], 200);
    }
}
