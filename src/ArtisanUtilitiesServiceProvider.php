<?php

namespace Rmunate\ArtisanUtilities;

/*
|--------------------------------------------------------------------------
| Comandos Personalizados Artisan
| Autor: Ing. Raul Mauricio Uñate Castro
|--------------------------------------------------------------------------
*/

use Illuminate\Support\ServiceProvider;

class ArtisanUtilitiesServiceProvider extends ServiceProvider
{

    /* Registrar Comandos Sistema */
    public function boot(){
        $this->registerCommands();
    }

    /* Comandos a Registrar */
    protected function registerCommands(){
        $this->commands([
            Commands\FlushCache::class,
            Commands\GitPush::class,
            Commands\GitReset::class,
            Commands\GitRevert::class,
            Commands\AccessFolders::class,
            Commands\ConfigCache::class,
            Commands\DefaultIgnore::class,
            Commands\DefaultStorage::class,
            Commands\PHPVersion::class,
            Commands\Spatie::class,
            Commands\PHPMAC::class,
            Commands\RestarApacheFPM::class,
            Commands\RestarApache::class,
        ]);
    }
}
