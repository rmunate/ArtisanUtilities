<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class PHPMAC extends Command
{

    /* Nombre del Comando */
    protected $signature = 'php-mac';

    /* Descripción del Comando */
    protected $description = 'Cambie su versión de PHP en MAC OS.';

    /* Constantes */
    const READ_HOMEBREW = 'Leyendo Versión De HomeBrew';
    const READ_PHP = 'Leyendo Versiones De PHP Instaladas En Su MacOS';
    const ERROR_BREW = 'No cuenta con brew en su sistema o no se reconoce su versión, Manual: https://brew.sh/';
    const ERROR_PHP = 'No se reconoce versiones de PHP en el Sistema.';
    const APACHE_RESTART = 'Servicio Apache Reiniciado Con Exito';

    /* @return Void */
    public function handle()
    {

        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Validar que se trabeje con Brew */
        $this->newLine();
        $this->info(Self::READ_HOMEBREW);
        $brew = shell_exec('brew -v');

        if (!empty($brew) && count(explode("\n", $brew)) > 0) {

            $brew = explode("\n", $brew);

            if (str_contains($brew[0], 'Homebrew')) {

                $this->line($brew[0]);

                /* Leer Versiones Por Brew */
                $this->info(Self::READ_PHP);

                $versiones = shell_exec('brew search php');

                if (count(explode("\n", $versiones)) > 0) {

                    $versiones = explode("\n", $versiones);
                    $php_versiones = [];

                    foreach ($versiones as $k => $v) {
                        if (str_contains($v, 'php/php@') && !str_contains($v, 'debug') && !str_contains($v, '8.3')) {
                            $netsData = str_replace('shivammathur/php/', '', $v);
                            array_push($php_versiones, $netsData);
                        }
                    }

                    if (count($php_versiones) > 0) {

                        $version = null;
                        while ($version == null) {

                            $version = $this->choice('Seleccione la Version de PHP a usar.', $php_versiones);

                            if (!empty($version)) {
                                $cambio = shell_exec("brew unlink php && brew link --overwrite --force $version");
                                $apache = shell_exec("brew services restart httpd");
                                $this->question(Self::APACHE_RESTART);
                            }

                        }
                        
                        $version = shell_exec('php -v');
                        $this->question('VERSIÓN VIGENTE PHP: ' .$version);

                    } else {
                        $this->error(Self::ERROR_PHP);
                        return;
                    }
                } else {
                    $this->error(Self::ERROR_PHP);
                    return;
                }
            } else {
                $this->error(Self::ERROR_BREW);
                return;
            }
        } else {
            $this->error(Self::ERROR_BREW);
            return;
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
