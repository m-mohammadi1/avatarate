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
//        name , bgcolor , color, shape , size

//        $image =  new AvatarGenerator(name: $name, background_color:$background_color, text_color:$text_color, shape:$shape, size:$size);

    }
}
