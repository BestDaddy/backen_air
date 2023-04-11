<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\Users\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private UsersService $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        if(request()->ajax()) {
            return $this->usersService->datatable([UsersService::DATATABLE_BUTTON_EDIT, UsersService::DATATABLE_BUTTON_MORE], ['role']);
        }

        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = array(
            'id' => 'numeric|nullable',
            'first_name'=> 'required',
            'email' => 'required|email|unique:users,email,'. $request->id,
            'role_id' => 'required',
            'password' => 'required_without:id',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], 400);
        }

        $user = $this->usersService->store(['id' => $request->id], $request->all());
        return response()->json(['code' => 200, 'message'=>'User saved successfully', 'data' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json($this->usersService->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->id == $id) {
            response()->json(['errors' => ['Suicide is bad']], 400);
        }
        $this->usersService->delete($id);

        return response()->json(['code' => 200, 'message'=>'User deleted successfully'], 200);
    }
}
