<?php

namespace Rmunate\ArtisanUtilities; 

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
            /* Comandos GIT */
            Commands\GitPush::class,
            Commands\GitReset::class,
            Commands\GitRevert::class,
            Commands\GitCheckOut::class,
            Commands\DefaultIgnore::class,
            /* Framework */
            Commands\ConfigCache::class,
            Commands\FlushCache::class,
            Commands\DefaultStorage::class,
            Commands\Debugger::class,
            /* Utilitarios */
            Commands\AccessFolders::class,
            Commands\PHPVersion::class,
            Commands\PHPMAC::class,
            Commands\RestarApacheFPM::class,
            Commands\RestarApache::class,
            Commands\Deploy::class,
            /* Librerias de Terceris */
            Commands\Spatie::class,
        ]);
    }
}

?>