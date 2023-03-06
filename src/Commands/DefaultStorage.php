<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Storage;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class DefaultStorage extends Command
{

    /* Nombre del Comando */
    protected $signature = 'DefaultStorage';

    /* Descripción del Comando */
    protected $description = 'Ajusta o crea la carpeta Storage del Framework de acuerdo al estándar.';

    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info('Inicio Ajuste Estructura Carpeta Storage');
        Storage::default();
        $this->question("Ajuste Estructura Carpeta Storage Completa.");
        $this->question("Log Laravel Del Proyecto Reiniciado Correctamente.");

        /* Configuracion Carpeta Storage */
        Utilities::chmod('storage');
        $this->info("Permisos De Escritura Y Lectura Asignados A La Carpeta Storage");

        /* Cierre */
        $this->newLine();
        $bar->finish();
        $this->newLine();
        $this->comment(Messages::success());
        if(Utilities::existNotify()){
            $this->notify(Messages::alertTittle(),Messages::alertBody());
        }

        /* Activacion Errores */
        Utilities::errorShow();

    }
}
