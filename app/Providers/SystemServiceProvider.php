<?php

namespace App\Providers;

use App\Services\Arduino\ArduinoService;
use App\Services\Arduino\ArduinoServiceImpl;
use App\Services\Logs\LogsService;
use App\Services\Logs\LogsServiceImpl;
use App\Services\Minions\MinionsService;
use App\Services\Minions\MinionsServiceImpl;
use App\Services\ArduinoTypes\ArduinoTypesService;
use App\Services\ArduinoTypes\ArduinoTypesServiceImpl;
use App\Services\Users\UsersService;
use App\Services\Users\UsersServiceImpl;
use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->bind(UsersService::class, UsersServiceImpl::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UsersService::class, UsersServiceImpl::class);
        $this->app->bind(ArduinoService::class, ArduinoServiceImpl::class);
        $this->app->bind(ArduinoTypesService::class, ArduinoTypesServiceImpl::class);
        $this->app->bind(LogsService::class, LogsServiceImpl::class);
    }
}
