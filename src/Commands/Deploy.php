<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Cache;
use Rmunate\ArtisanUtilities\Storage;
use Rmunate\ArtisanUtilities\Messages;
use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\CommandOS;
use Rmunate\ArtisanUtilities\Utilities;

class Deploy extends Command
{

    /* Nombre del Comando */
    protected $signature = 'deploy';

    /* Descripción del Comando */
    protected $description = 'Todos los comandos para dejar corriendo el proyecto en Linux Ubuntu.';



    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Ajuste Storage & Logs */
        $this->newLine();
        $this->info("Iniciando Reajuste Carpete Storage.");
        Storage::default();
        $this->line("Ajuste Estructura Carpeta Storage Completa.");
        $this->line("Log Laravel Del Proyecto Reiniciado Correctamente.");

        /* Eliminacion Cache del proyecto */
        /* Comandos Artisan a Ejecutar - Mismo Orden de Ejecucion */
        $this->newLine();
        $this->info('Limpiando Proyecto');
        /* Definir Comandos de Acuerdo al Sistema operativo */
        $commands = CommandOS::get();
        $this->line($commands->message);

        foreach ($commands->execute as $command => $comment) {
            Artisan::call($command);
            $this->line($comment);
        }

        /* Configuracion de permisos */
        $this->newLine();
        $this->info('Configurando Permisos (STORAGE Y PUBLIC)');

        /* Configuracion Carpeta Storage */
        Utilities::chmod('storage');
        $this->line("Permisos De Escritura Y Lectura Asignados A La Carpeta Storage");
        /* Configuracion Carpeta Public */
        Utilities::chmod('public');
        $this->line("Permisos De Escritura Y Lectura Asignados A La Carpeta Public");

        /* Configuracion de Cache --- */
        $this->newLine();
        $this->info('Configuración Total De Cache');

        /* Eliminar Cache Actual */
        Cache::deleteTMP();
        $this->newLine();
        $this->line('Eliminación Configuración De Cache Actual Exitoso');

        /* Configurar Cache */
        Cache::artisan();
        $this->line("Cache Actualizado Exitosamente");

        /* ReIniciando Composer */
        $composer = @shell_exec('composer dump-autoload');
        $this->line("Autoload Composer Regenerado");

        $this->question('Proyecto Desplegado!');

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
