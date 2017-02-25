<?php

namespace Duro85\AjaxAuth;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AjaxAuthRouteServiceProvider extends ServiceProvider
{
    protected $namespace = '';

    public function boot()
    {
        parent::boot();
        if (!$this->app->routesAreCached()) {
            include base_path('routes/ajaxauth.php');
        }
    }

    
}