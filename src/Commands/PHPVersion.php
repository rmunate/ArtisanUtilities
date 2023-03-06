<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class PHPVersion extends Command
{

    /* Nombre del Comando */
    protected $signature = 'php-version';

    /* Descripción del Comando */
    protected $description = 'Conocer La Versión de PHP En USO.';

    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Imprimir Version de PHP */
        $this->newLine();
        $this->question('VERSION DE PHP EN USO');
        $version = shell_exec('php -v');
        $this->question($version);

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
