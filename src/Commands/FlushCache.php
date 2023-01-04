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


class FlushCache extends Command {

    /* Nombre del Comando */
    protected $signature = 'FlushCache';

    /* Descripción del Comando */
    protected $description = 'Ejecute la limpieza total de su proyecto, recuerde estar conectado a la base de datos, ya que se ejecutará la limpieza de información basura desde las tablas por defecto de Laravel. Elimina los Logs del proyecto, Ajusta la configuración correcta de la carpeta Storage, asigna los permisos para el correcto funcionamiento del sistema en servidores de producción o pruebas.';

    /* @return Void */
    public function handle(){

        /* Omitir Errores */
        ArtisanUtilities::errorHidden();

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('AJUSTE CARPETA STORAGE'));
        @ArtisanUtilities::DefaultStorage();
        $this->info(ArtisanUtilities::processLine("Ajuste Estructura Carpeta Storage Completa."));
        $this->info(ArtisanUtilities::processLine("Log Laravel Del Proyecto Reiniciado Correctamente."));

        /* Eliminacion Cache del proyecto */
        /* Comandos Artisan a Ejecutar - Mismo Orden de Ejecucion */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('LIMPIEZA DE PROYECTO'));

        /* Definir Comandos de Acuerdo al Sistema operativo */
        $identifiers = ['Mac','Darwin']; //Textos Identificadores
        $macOS = false;
        foreach ($identifiers as $identifier) { /* Validacion de Identificadores */
            $pos = strpos(php_uname(), $identifier);
            if ($pos !== false) { $macOS = true; }
        }

        if ($macOS) {
            $this->info(ArtisanUtilities::processLine("Definiendo Comandos Compatibles En MAC OS."));
            $commands = [
                'cache' => 'Cache Eliminado del Proyecto Correctamente',
                'view' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'auth' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado'
            ];
        } else {
            $commands = [
                'cache' => 'Cache Eliminado del Proyecto Correctamente',
                'config' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'view' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'auth' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'permission' => 'Cache de Permisos Eliminado del Proyecto Correctamente',
                'queue' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado'
            ];
        }
        
        foreach ($commands as $command => $comment) {
            @ArtisanUtilities::Call($command);
            $this->info(ArtisanUtilities::processLine($comment));
        }

        /* Configuracion de Cache --- */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CONFIGURACION DE CACHE'));
        @ArtisanUtilities::deleteTMP();
        @ArtisanUtilities::ConfigCache();
        $this->info(ArtisanUtilities::processLine("Cache Actualizado Exitosamente"));

        /* Configuracion de permisos */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('CONFIGURACION DE PERMISOS CARPETAS'));
        @shell_exec('chmod -R 777 storage');
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Asignados A La Carpeta Storage"));
        @shell_exec('chmod -R 777 public');
        $this->info(ArtisanUtilities::processLine("Permisos De Escritura Asignados A La Carpeta Public"));

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('AJUSTANDO GIT_IGNORE PRINCIPAL'));
        $this->info(ArtisanUtilities::processLine("Archivo Principal de GitIgnore Ajustado al estandar."));
        @ArtisanUtilities::gitIgnoreBase();

        /* ReIniciando Composer */
        $this->info(ArtisanUtilities::processLine("Regenerando Autoload Composer"));
        @shell_exec('composer dump-autoload');

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
