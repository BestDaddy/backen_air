<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\MinionTypes\MinionTypesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MinionTypeController extends Controller
{
    private MinionTypesService $minionTypesService;
    public function __construct(MinionTypesService $minionTypesService)
    {
        $this->minionTypesService = $minionTypesService;
    }

    public function index() {
        if(request()->ajax()) {
            return $this->minionTypesService->datatable([MinionTypesService::DATATABLE_BUTTON_EDIT], []);
        }

        return view('admin.minion_types.index');
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
        return response()->json(['code' => 200, 'message'=>'MinionType saved successfully', 'data' => $minion], 200);
    }

    public function edit($id) {
        return response()->json($this->minionTypesService->find($id));
    }

    public function destroy(string $id)
    {
        $this->minionTypesService->delete($id);
        return response()->json(['code' => 200, 'message'=>'MinionType deleted successfully'], 200);
    }
}
