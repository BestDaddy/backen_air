<?php


namespace App\Services\Users;


use App\Services\BaseService;
use Illuminate\Http\Request;

interface UsersService extends BaseService
{
    public function store(array $params, array $attributes);

}
