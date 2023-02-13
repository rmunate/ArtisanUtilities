<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;

class FlushCache extends Command
{

    /* Nombre del Comando */
    protected $signature = 'FlushCache'; 

    /* Descripción del Comando */
    protected $description = 'Ejecute la limpieza total de su proyecto (cache, vistas, rutas, configuración, autenticación, eventos, colas, calendarios), recuerde estar conectado a la base de datos, ya que se ejecutará la limpieza de información “basura” desde las tablas por defecto de Laravel (Sin tocar información del sistema). Elimina los Logs del proyecto. Ajusta la configuración correcta de la carpeta Storage. Asigna los permisos que corresponden a las diferentes carpetas del Framework para garantizar el correcto funcionamiento.';

    /* @return Void */
    public function handle()
    {

        /* Omitir Errores */
        ArtisanUtilities::errorHidden();

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('PROCESO 1 => AJUSTE ESTRUCTURA CARPETA STORAGE'));
        $this->info(ArtisanUtilities::processLine("Iniciando Reajuste Carpete Storage."));
        @ArtisanUtilities::DefaultStorage();
        $this->info(ArtisanUtilities::processLine("Ajuste Estructura Carpeta Storage Completa."));
        $this->info(ArtisanUtilities::processLine("Log Laravel Del Proyecto Reiniciado Correctamente."));

        /* Eliminacion Cache del proyecto */
        /* Comandos Artisan a Ejecutar - Mismo Orden de Ejecucion */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('PROCESO 2 => LIMPIEZA DE PROYECTO'));

        /* Definir Comandos de Acuerdo al Sistema operativo */
        $identifiers = ['Mac', 'Darwin']; //Textos Identificadores (Agregar n)
        $macOS = false;
        foreach ($identifiers as $identifier) { /* Validacion de Identificadores */
            $pos = strpos(php_uname(), $identifier);
            if ($pos !== false) {$macOS = true;}
        }

        if ($macOS) {
            $this->info(ArtisanUtilities::processLine("Definidos Los Comandos Compatibles En MAC OS."));
            $commands = [
                'cache' => 'Cache Eliminado del Proyecto Correctamente',
                'view' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'auth' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado',
            ];
        } else {
            $this->info(ArtisanUtilities::processLine("Definidos Los Comandos Compatibles En Su Sistema Operativo " . php_uname() . "."));
            $commands = [
                'cache' => 'Cache Eliminado del Proyecto Correctamente',
                'config' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'view' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'auth' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado',
            ];
        }

        foreach ($commands as $command => $comment) {
            @ArtisanUtilities::Call($command);
            $this->info(ArtisanUtilities::processLine($comment));
        }

        /* Configuracion de Cache --- */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('PROCESO 3 => CONFIGURACION DE CACHE'));
        /* Eliminar Cache Actual */
        @ArtisanUtilities::deleteTMP();
        $this->info(ArtisanUtilities::headerLine('Eliminación Configuración De Cache Actual Exitoso'));
        @ArtisanUtilities::ConfigCache();
        $this->info(ArtisanUtilities::processLine("Cache Actualizado Exitosamente"));

        /* Configuracion de permisos */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('PROCESO 4 => CONFIGURACIÓN DE PERMISOS CARPETAS (STORAGE Y PUBLIC)'));

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

        /* ReIniciando Composer */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('PROCESO 4 => CONFIGURACIÓN AUTOLOAD COMPOSER'));
        $this->line('Dependiendo la configuración del proyecto, esto puede demorar.');
        @shell_exec('composer dump-autoload');
        $this->info(ArtisanUtilities::processLine("Autoload Composer Regenerado"));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
