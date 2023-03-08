<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class Debugger extends Command
{
    /* Nombre Comando */
    protected $signature = 'debugger {code*}';

    /* Descripcion */
    protected $description = 'Ejecute codigo PHP desde la Consola';

    public function handle()
    {
        /* Inicio Comando */
        $this->comment(Messages::start());

        if (! $this->isAllowedToRun()) {
            $this->error('Este comando solo se puede ejecutar si la variable de entorno `ALLOW_DD_COMMAND` se establece en `true` o en el entorno local.');
            return;
        }

        $out =  collect($this->argument('code'))->map(function (string $command) {
                    return rtrim($command, ';');
                })->map(function (string $sanitizedCommand) {
                    return eval("dump({$sanitizedCommand});");
                })->implode(PHP_EOL);

        $this->comment(Messages::success());
        if(Utilities::existNotify()){
            $this->notify(Messages::alertTittle(),Messages::alertBody());
        }

        return $out;
    
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