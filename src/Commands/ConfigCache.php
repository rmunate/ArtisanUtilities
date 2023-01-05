<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class ConfigCache extends Command {

    /* Nombre del Comando */
    protected $signature = 'ConfigCache';

    /* Descripción del Comando */
    protected $description = 'Ajusta el cache del proyecto, eliminando los archivos previos de configuración, creando los nuevos y regenerando el autoload de composer.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Configuracion de Cache --- */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CONFIGURACION DE CACHE'));
        @ArtisanUtilities::deleteTMP();
        $this->info(ArtisanUtilities::headerLine('Eliminación Cache Actual'));
        @ArtisanUtilities::ConfigCache();
        $this->info(ArtisanUtilities::processLine("Cache Actualizado Exitosamente"));

        /* ReIniciando Composer */
        $this->info(ArtisanUtilities::processLine("Regenerando Autoload Composer"));
        @shell_exec('composer dump-autoload'); //

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);
    }
}
