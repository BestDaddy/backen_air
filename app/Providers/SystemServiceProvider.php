<?php

namespace App\Providers;

use App\Services\Agents\AgentsService;
use App\Services\Agents\AgentsServiceImpl;
use App\Services\Logs\LogsService;
use App\Services\Logs\LogsServiceImpl;
use App\Services\Minions\MinionsService;
use App\Services\Minions\MinionsServiceImpl;
use App\Services\MinionTypes\MinionTypesService;
use App\Services\MinionTypes\MinionTypesServiceImpl;
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
        $this->app->bind(AgentsService::class, AgentsServiceImpl::class);
        $this->app->bind(MinionsService::class, MinionsServiceImpl::class);
        $this->app->bind(MinionTypesService::class, MinionTypesServiceImpl::class);
        $this->app->bind(LogsService::class, LogsServiceImpl::class);
    }
}
