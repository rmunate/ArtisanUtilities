<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Permission\PermissionRegistrar;
use Rmunate\ArtisanUtilities\ArtisanUtilities;
use Symfony\Component\Console\Helper\TableCell;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class PHPMAC extends Command {

    /**
     * Nombre del Comando
     * @var string
     */
    protected $signature = 'mac-php';

    /* Descripción del Comando */
    protected $description = 'Cambie su versión de PHP en MAC OS.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start); 

        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('LEYENDO VERSION DE HOMEBREW'));
        /* Validar que se trabeje con Brew */
        $brew = shell_exec('brew -v');

        if (!empty($brew) && count(explode("\n", $brew)) > 0) {
            $brew = explode("\n", $brew);
            if (str_contains($brew[0], 'Homebrew')) {

                $this->line(ArtisanUtilities::processLine($brew[0]));

                /* Leer Versiones Por Brew */
                $this->info(ArtisanUtilities::headerLine('LEYENDO VERSIONES DE PHP'));
                $versiones = shell_exec('brew search php');
                if (count(explode("\n", $versiones)) > 0) {
                    $versiones = explode("\n", $versiones);
                    $php_versiones = [];
                    foreach ($versiones as $k => $v) {
                        if (str_contains($v, 'php/php@') && !str_contains($v, 'debug')) {
                            $netsData = str_replace('shivammathur/php/','',$v);
                            array_push($php_versiones, $netsData);
                        }
                    }
                    if (count($php_versiones) > 0) {

                        $version = $this->choice('Seleccione la Version de PHP a usar.',$php_versiones);

                        $cambio =  shell_exec("brew unlink php && brew link --overwrite --force $version");

                        if (str_contains($cambio, 'Error:')) {
                            $this->error("No se logró cargar la version $version");
                        } else {
                            $this->line("Version $version Cargada Exitosamente.");
                        }

                        $apache =  shell_exec("brew services restart httpd");
                        $this->line("Servicio Apache Reiniciado Con Exito");
                        
                        $this->line("--------------------------------------");
                        $version = shell_exec('php -v');
                        $this->info($version);
                        $this->line("--------------------------------------");

                    } else {
                        $this->error('No se reconoce versiones de PHP en el Sistema.');
                    }
                } else {
                    $this->error('No se reconoce versiones de PHP en el Sistema.');
                }
            } else {
                $this->error('No se reconoce su version de Brew, no es posible ejecutar el comando.');
            }
        } else {
            $this->error('No cuenta con brew en su sistema, ingrese a https://brew.sh/ para conocer su instalación.');
        }

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}