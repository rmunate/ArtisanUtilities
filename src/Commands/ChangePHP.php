<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class ChangePHP extends Command {

    /* Nombre del Comando */
    protected $signature = 'fpm-php';

    /* Descripción del Comando */
    protected $description = 'Cambie la version del PHP en uso en el servidor Linux Ubunto con FPM.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CAMBIAR VERSION DE PHP-FPM'));

        $versiones = shell_exec('sudo update-alternatives --config php');
        
        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
