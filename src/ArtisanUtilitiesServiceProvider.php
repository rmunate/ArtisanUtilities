<?php

namespace Rmunate\ArtisanUtilities;

use Illuminate\Support\ServiceProvider;

class ArtisanUtilitiesServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->registerCommands();
    }

    protected function registerCommands(){
        $this->commands([
            Commands\FlushCache::class,
            Commands\GitPush::class,
            Commands\GitReset::class,
            Commands\GitRevert::class
        ]);
    }
}
