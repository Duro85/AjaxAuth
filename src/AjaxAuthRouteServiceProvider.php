<?php
/**
 * @link      https://github.com/duro85/ajaxauth
 *
 * @copyright 2017 Michelangelo Belfiore
 */

namespace Duro85\AjaxAuth;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AjaxAuthRouteServiceProvider extends ServiceProvider
{
    protected $namespace = '';

    public function boot()
    {
        parent::boot();
        if (!$this->app->routesAreCached()) {
            if (file_exists(base_path('routes/ajaxauth.php'))) {
                include base_path('routes/ajaxauth.php');
            }
        }
    }
}
