<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;

class DefaultStorage extends Command
{

    /* Nombre del Comando */
    protected $signature = 'DefaultStorage';

    /* Descripción del Comando */
    protected $description = 'Ajusta o crea la carpeta Storage del Framework de acuerdo al estándar.';

    /* @return Void */
    public function handle()
    {

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('AJUSTE ESTRUCTURA CARPETA STORAGE'));
        $this->info(ArtisanUtilities::processLine("Iniciando Reajuste Carpete Storage."));
        @ArtisanUtilities::DefaultStorage();
        $this->info(ArtisanUtilities::processLine("Ajuste Estructura Carpeta Storage Completa."));
        $this->info(ArtisanUtilities::processLine("Log Laravel Del Proyecto Reiniciado Correctamente."));

        /* Configuracion Carpeta Storage */
        if (str_contains(php_uname(), 'Windows')) {
            @chmod('storage', 0777);
        } else {
            @shell_exec('chmod -R 777 storage');
        }
        $this->info(ArtisanUtilities::processLine("Accedido Correctamente al Interprete de Comandos"));
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Y Lectura Asignados A La Carpeta /STORAGE"));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
