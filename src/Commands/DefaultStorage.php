<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class DefaultStorage extends Command {

    /* Nombre del Comando */
    protected $signature = 'DefaultStorage';

    /* Descripción del Comando */
    protected $description = 'Ajusta o crea la carpeta Storage del Framework de acuerdo al estándar.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('AJUSTE CARPETA STORAGE'));
        @ArtisanUtilities::DefaultStorage();
        $this->info(ArtisanUtilities::processLine("Ajuste Estructura Carpeta Storage Completa."));
        $this->info(ArtisanUtilities::processLine("Log Laravel Del Proyecto Reiniciado Correctamente."));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
