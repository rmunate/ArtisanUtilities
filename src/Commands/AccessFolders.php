<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;

class AccessFolders extends Command
{

    /* Nombre del Comando */
    protected $signature = 'AccessFolders';

    /* Descripción del Comando */
    protected $description = 'Ajusta los permisos de las carpetas del Proyecto. Brinda accesos de escritura a la carpeta Public y a la carpeta Storage.';

    /* @return Void */
    public function handle()
    {

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Configuracion de permisos */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CONFIGURACIÓN DE PERMISOS CARPETAS (STORAGE Y PUBLIC)'));

        /* Configuracion Carpeta Storage */
        if (str_contains(php_uname(), 'Windows')) {
            @chmod('storage', 0777);
        } else {
            @shell_exec('chmod -R 777 storage');
        }
        $this->info(ArtisanUtilities::processLine("Accedido Correctamente al Interprete de Comandos"));
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Y Lectura Asignados A La Carpeta /STORAGE"));

        /* Configuracion Carpeta Public */
        if (str_contains(php_uname(), 'Windows')) {
            @chmod('public', 0777);
        } else {
            @shell_exec('chmod -R 777 public');
        }
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Y Lectura Asignados A La Carpeta /PUBLIC"));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
