<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class PHPVersion extends Command {

    /* Nombre del Comando */
    protected $signature = 'PHPVersion';

    /* Descripción del Comando */
    protected $description = 'Conocer Versión de PHP En USO.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('VERSION DE PHP EN USO'));

        $version = shell_exec('php -v');
        $this->info($version);
        
        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
