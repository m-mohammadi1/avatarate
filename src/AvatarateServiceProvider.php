<?php

namespace Avatarate;

use Illuminate\Support\ServiceProvider;

class AvatarateServiceProvider extends ServiceProvider
{
    public function register()
    {
         $this->mergeConfigFrom(__DIR__.'/../config/avatarate.php', 'avatarate');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/avatarate.php' => config_path('avatarate.php')
        ]);
    }
}
