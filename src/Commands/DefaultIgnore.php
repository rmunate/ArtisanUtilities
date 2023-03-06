<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Ignore;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class DefaultIgnore extends Command
{

    /* Nombre del Comando */
    protected $signature = 'DefaultIgnore';

    /* Descripción del Comando */
    protected $description = 'Ajusta el Git Ignore principal del proyecto, de acuerdo con el estándar del Framework, adicional valida si usa dependencias de NPM o carpetas del IDE para igualmente ignorarlas en el cargue.';

    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info('Ajustando .gitignore');
        Ignore::create();
        $this->info("Archivo Principal de GitIgnore Ajustado al Estandar.");
        $this->question("Archivo Publicado => /.gitignore");

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
