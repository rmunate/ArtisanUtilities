<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;


class RestarApache extends Command {

    /* Nombre del Comando */
    protected $signature = 'apache-restart';

    /* Descripción del Comando */
    protected $description = 'Reiniciar Apache en Linux Ubunto.';

    /* @return Void */
    public function handle(){

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Ajuste GitIgnore Principal del Proyecto */
        $this->newLine();
        $this->info('REINICIANDO APACHE');
        $exec = @shell_exec('sudo restart apache2');
        
        if (str_contains($exec, 'found') OR empty($exec)) {
            $this->error('Imposible Reiniciar, consulte como ejecutar el proceso en su Sistema Operativo. Este Comando Es Para Linux Ubuntu.');
            return;
        } else {
            $this->question('Apache Reiniciado Con Exito.');
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
