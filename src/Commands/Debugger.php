<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;

class Debugger extends Command
{
    protected $signature = 'debugger {code*}';

    protected $description = 'Ejecute codigo PHP desde la Consola';

    public function handle()
    {
        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        if (! $this->isAllowedToRun()) {
            $this->error('Este comando solo se puede ejecutar si la variable de entorno `ALLOW_DD_COMMAND` se establece en `true` o en el entorno local.');
            return;
        }

        return collect($this->argument('code'))->map(function (string $command) {
                    return rtrim($command, ';');
                })->map(function (string $sanitizedCommand) {
                    return eval("dump({$sanitizedCommand});");
                })->implode(PHP_EOL);

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

    protected function isAllowedToRun(): bool
    {
        if (env('ALLOW_DD_COMMAND') === true) {
            return true;
        }

        return app()->environment('local');
    }
}

?>