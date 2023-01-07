<?php

/*
|--------------------------------------------------------------------------
| Comandos Personalizados Artisan
|--------------------------------------------------------------------------
| Clase de metodos estaticos para la ejecucion de los comenados externos.
| Autor: Ing. Raul Mauricio Uñate Castro
| V 1.0.0 : 20-12-2021 (Primer Release)
| V 1.2.0 : 01-05-2022 (Segundo Release)
| V 2.0.0 : 19-07-2022 (Comando Reescrito)
| V 3.0.1 : 09-09-2022 (Comando Optimizado)
| V 3.1.0 : 04-01-2023 (Comando Ajustado Para MacOS)
|--------------------------------------------------------------------------
|
*/

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class AccessFolders extends Command {

    /* Nombre del Comando */
    protected $signature = 'AccessFolders';

    /* Descripción del Comando */
    protected $description = 'Ajusta los permisos de las carpetas del Proyecto. Brinda accesos de escritura a la carpeta Public y a la carpeta Storage.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Configuracion de permisos */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CONFIGURACION DE PERMISOS CARPETAS (STORAGE AND PUBLIC)'));

        /* Configuracion Carpeta Storage */
        @shell_exec('chmod -R 777 storage');
        $this->info(ArtisanUtilities::processLine("Accedido Correctamente al Interprete de Comandos"));
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Y Lectura Asignados A La Carpeta STORAGE"));

        /* Configuracion Carpeta Public */
        @shell_exec('chmod -R 777 public');
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Y Lectura Asignados A La Carpeta PUBLIC"));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
