<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class AccessFolders extends Command
{

    /* Nombre del Comando */
    protected $signature = 'AccessFolders';

    /* Descripción del Comando */
    protected $description = 'Ajusta los permisos de las carpetas del Proyecto. Brinda accesos de escritura a la carpeta Public y a la carpeta Storage.';

    /* @return Void */
    public function handle()
    {

        $bar = $this->output->createProgressBar(100);

        /* Inicio Comando */
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Configuracion de permisos */
        $this->newLine();
        Utilities::chmod('storage');
        $this->question("Permisos De Escritura Y Lectura Asignados A La Carpeta STORAGE");
        
        Utilities::chmod('public');
        $this->question("Permisos De Escritura Y Lectura Asignados A La Carpeta PUBLIC");

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
