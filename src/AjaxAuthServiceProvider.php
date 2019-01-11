<?php

/**
 * @link      https://github.com/duro85/ajaxauth
 *
 * @copyright 2017 Michelangelo Belfiore
 */

namespace Duro85\AjaxAuth;

use Illuminate\Support\ServiceProvider;

class AjaxAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/resources/lang/' => resource_path('lang/')], 'lang');
        $this->publishes([__DIR__.'/config/ajaxauth.php' => config_path('/ajaxauth.php')], 'ajaxauth');
        $this->publishes([__DIR__.'/routes/ajaxauth.php' => base_path('/routes/ajaxauth.php')], 'routes');
    }
}
