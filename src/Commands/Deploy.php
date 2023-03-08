<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Cache;
use Rmunate\ArtisanUtilities\Storage;
use Rmunate\ArtisanUtilities\Messages;
use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\ListCommands;
use Rmunate\ArtisanUtilities\Utilities;

class Deploy extends Command
{

    /* Nombre del Comando */
    protected $signature = 'deploy';

    /* Descripción del Comando */
    protected $description = 'Script de comandos para dejar desplegado el proyecto en Linux Ubuntu.';

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
        $this->newLine();
        $this->info('Limpiando Proyecto');
        Cache::deleteTMP();
        $commands = ListCommands::orderDeploy();
        $this->line($commands->message);
        foreach ($commands->list as $command => $comment) {
            if (Utilities::commandExists($command)) {
                Artisan::call($command);
                $this->line($comment);
            }
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

        /* ReIniciando Composer */
        $this->info("Actualizando Dependencias");
        $composer = @shell_exec('composer update');
        $this->line("Autoload Composer Regenerado");

        $this->question('¡Proyecto Desplegado!');

        if (env("APP_DEBUG")) {
            $this->newLine();
            $this->warn('Por favor ajuste su .ENV "APP_DEBUG = false", actualmente se están imprimiendo los mensajes de depuración y esto pone en riesgo la seguridad del proyecto.');
        }

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