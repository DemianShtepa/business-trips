<?php

namespace App\Application\Providers;

use App\Application\Action\Employee;
use App\Application\Action\Trip;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(
        Employee\Router $employeeRouter,
        Trip\Router $tripRouter,
    ): void {
        $employeeRouter->register();
        $tripRouter->register();
    }
}
