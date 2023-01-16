<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;


class RestarApache extends Command {

    /* Nombre del Comando */
    protected $signature = 'apache-restart';

    /* Descripción del Comando */
    protected $description = 'Reiniciar Apache en Linux Ubunto.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('REINICIANDO APACHE'));
        $this->info(ArtisanUtilities::processLine("Invocando el comando => sudo restart apache2"));
        $reset_apache = shell_exec('sudo restart apache2');
        
        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
