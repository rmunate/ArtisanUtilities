<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Cache;
use Rmunate\ArtisanUtilities\Storage;
use Rmunate\ArtisanUtilities\Messages;
use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\ListCommands;
use Rmunate\ArtisanUtilities\Utilities;

class FlushCache extends Command
{

    /* Nombre del Comando */
    protected $signature = 'FlushCache'; 

    /* Descripción del Comando */
    protected $description = 'Ejecute la limpieza total de su proyecto (cache, vistas, rutas, configuración, autenticación, eventos, colas, calendarios), recuerde estar conectado a la base de datos, ya que se ejecutará la limpieza de información “basura” desde las tablas por defecto de Laravel (Sin tocar información del sistema). Elimina los Logs del proyecto. Ajusta la configuración correcta de la carpeta Storage. Asigna los permisos que corresponden a las diferentes carpetas del Framework para garantizar el correcto funcionamiento.';

    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->question('PROCESO 1 => AJUSTE ESTRUCTURA CARPETA STORAGE');
        $this->info("Iniciando Reajuste Carpete Storage.");
        Storage::default();
        $this->info("Ajuste Estructura Carpeta Storage Completa.");
        $this->info("Log Laravel Del Proyecto Reiniciado Correctamente.");

        /* Eliminacion Cache del proyecto */
        /* Comandos Artisan a Ejecutar - Mismo Orden de Ejecucion */
        $this->newLine();
        $this->question('PROCESO 2 => LIMPIEZA DE PROYECTO');

        /* Definir Comandos y ejecutar */
        Cache::deleteTMP();
        $this->info('Eliminación Configuración De Cache Actual Exitoso');
        $this->info("Cache Actualizado Exitosamente");
        $commands = ListCommands::orderCacheClear();
        $this->info($commands->message);
        foreach ($commands->list as $command => $comment) {
            Artisan::call($command);
            $this->info($comment);
        }

        /* Configuracion de permisos */
        $this->newLine();
        $this->question('PROCESO 3 => CONFIGURACIÓN DE PERMISOS CARPETAS (STORAGE Y PUBLIC)');

        /* Configuracion Carpeta Storage */
        Utilities::chmod('storage');
        $this->info("Permisos De Escritura Y Lectura Asignados A La Carpeta Storage");

        /* Configuracion Carpeta Public */
        Utilities::chmod('public');
        $this->info("Permisos De Escritura Y Lectura Asignados A La Carpeta Public");

        /* ReIniciando Composer */
        $this->newLine();
        $this->question('PROCESO 4 => REGENERAR AUTOLOAD COMPOSER');
        $composer = @shell_exec('composer dump-autoload');
        $this->info("Autoload Composer Regenerado");

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

?>