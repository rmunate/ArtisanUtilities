<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class DefaultIgnore extends Command {

    /* Nombre del Comando */
    protected $signature = 'DefaultIgnore';

    /* Descripción del Comando */
    protected $description = 'Ajusta el Git Ignore principal del proyecto, de acuerdo con el estándar del Framework, adicional valida si usa dependencias de NPM o carpetas del IDE para igualmente ignorarlas en el cargue.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('Ajustando .gitignore - Proyecto'));
        @ArtisanUtilities::gitIgnoreBase();
        $this->info(ArtisanUtilities::processLine("Archivo Principal de GitIgnore Ajustado al Estandar."));
        $this->info(ArtisanUtilities::processLine("Archivo Publicado =>/.gitignore"));

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
