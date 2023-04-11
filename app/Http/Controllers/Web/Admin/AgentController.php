<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Agents\AgentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    private AgentsService $agentsService;
    public function __construct(AgentsService $agentsService)
    {
        $this->agentsService = $agentsService;
    }

    public function index()
    {
        if(request()->ajax()) {
            return $this->agentsService->datatable([AgentsService::DATATABLE_BUTTON_EDIT, AgentsService::DATATABLE_BUTTON_MORE], []);
        }
        return view('admin.agents.index');
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), array(
            'id' => 'numeric|nullable',
            'name'=> 'required',
            'ip' => 'required|ip|unique:agents,ip,'. $request->id,
            'config' => 'json',
        ));

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], 400);
        }

        $agent = $this->agentsService->store(['id' => $request->id], $request->all());
        return response()->json(['code' => 200, 'message'=>'Agent saved successfully', 'data' => $agent], 200);
    }

    public function edit(string $id)
    {
        return response()->json($this->agentsService->find($id));
    }

    public function destroy(string $id)
    {
        $this->agentsService->delete($id);
        return response()->json(['code' => 200, 'message'=>'Agent deleted successfully'], 200);
    }
}
