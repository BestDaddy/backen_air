<?php


namespace App\Services\Users;


use App\Models\User;
use App\Services\BaseServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class UsersServiceImpl extends BaseServiceImpl implements UsersService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


    public function store(array $params, array $attributes){
        $password = $attributes['password'];
        if($attributes['id'] && !$password){
            $password = User::findorfail($attributes['id'])->password;
        }
        elseif($password)
            $password = bcrypt($password);

        $attributes['password'] = $password;

        return User::updateOrCreate($params, $attributes);
    }
}
