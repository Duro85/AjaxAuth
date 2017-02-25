<?php

namespace Duro85\AjaxAuth;

use Illuminate\Support\ServiceProvider;

class AjaxAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/resources/lang/' => resource_path('lang/')], 'lang');
        $this->publishes([__DIR__.'/config/ajaxauth_test.php' => config_path('/ajaxauth_test.php')], 'ajaxauth');
        $this->publishes([__DIR__.'/routes.php' => base_path('/routes/ajaxauth.php')], 'routes');
    }


}