<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;

class Debugger extends Command
{
    protected $signature = 'debugger {code*}';

    protected $description = 'Ejecute el Codigo dado y descargue el Resultado';

    public function handle()
    {
        if (! $this->isAllowedToRun()) {
            $this->error('Este comando solo se puede ejecutar si la variable de entorno `ALLOW_DD_COMMAND` se establece en `true` o en el entorno local.');
            return;
        }

        return collect($this->argument('code'))
            ->map(function (string $command) {
                return rtrim($command, ';');
            })
            ->map(function (string $sanitizedCommand) {
                return eval("dump({$sanitizedCommand});");
            })
            ->implode(PHP_EOL);
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