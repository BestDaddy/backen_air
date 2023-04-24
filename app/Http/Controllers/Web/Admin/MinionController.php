<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Minions\MinionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MinionController extends Controller
{
    private MinionsService $minionsService;
    public function __construct(MinionsService $minionsService)
    {
        $this->minionsService = $minionsService;
    }

    public function index() {
        if(request()->ajax()) {
            return $this->minionsService->datatable([], ['minionType']);
        }

        return view('admin.minions.index');
    }

    public function store(Request $request) {
        $error = Validator::make($request->all(), array(
            'id' => 'numeric|nullable',
            'minion_type_id' => 'required|exists:minion_types,id',
            'agent_id' => [
                'required',
                'exists:agents,id',
                Rule::unique('minions')->where(function ($q) use ($request) {
                    return $q->where('agent_id', $request->agent_id)
                        ->where('minion_type_id', $request->minion_type_id);
                })->ignore($request->id),
            ],

        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], 400);
        }

        $minion = $this->minionsService->store(['id' => $request->id], $request->all());
        return response()->json(['code' => 200, 'message'=>'Minion saved successfully', 'data' => $minion], 200);
    }

    public function edit($id) {
        return response()->json($this->minionsService->find($id));
    }

    public function destroy(string $id)
    {

        $this->minionsService->delete($id);
        return response()->json(['code' => 200, 'message'=>'Minion deleted successfully'], 200);
    }
}
