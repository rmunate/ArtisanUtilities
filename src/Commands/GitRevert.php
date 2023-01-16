<?php

/*
|--------------------------------------------------------------------------
| Comandos Personalizados Artisan
|--------------------------------------------------------------------------
| Clase de metodos estaticos para la ejecucion de los comenados externos.
| Autor: Ing. Raul Mauricio Uñate Castro
| V 1.0.0 : 20-12-2021 (Primer Release)
| V 1.2.0 : 01-05-2022 (Segundo Release)
| V 2.0.0 : 19-07-2022 (Comando Reescrito)
| V 3.0.1 : 09-09-2022 (Comando Optimizado)
| V 3.1.0 : 04-01-2023 (Comando Ajustado Para MacOS)
|--------------------------------------------------------------------------
|
*/

namespace Rmunate\ArtisanUtilities\Commands;

use Artisan;
use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;

class GitRevert extends Command{

    /**
     * Nombre del Comando
     * @var string
     */ 
    protected $signature = 'GitRevert {--log=}';

    /**
     * Descripcion del proyecto
     * @var string
     */
    protected $description = 'Reversar Cambios en el Proyecto';

    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Codigo del Comando
     * @return Void
     */
    public function handle(){

        /* Inicio Comando */
        $this->line(ArtisanUtilities::$start);

        /* Arreglo de Commits */
        $arrayCommits = ArtisanUtilities::GitCommits();

        /* Cuenta de commits */
        $countCommits = count($arrayCommits);

        /* Se quita un comit porque la ultima llave por defecto viene vacio */
        $msjCommits = $countCommits - 1;

        /* Mensaje con la cantidad de commits del repositorio */
        $this->info('El Repositorio Cuenta Con Un Total De ' . $msjCommits . ' Commits Aplicados.');

        /* Eliminar los comits que llegasen a aparecer repetidos */
        $uniqueCommits = array_unique($arrayCommits);

        /* Validar si se determino por parte del usuario la cantidad de Commits a mostrar en pantalla. */
        /* Valida que este seteada la opcion y que sea superior a 0 */
        if (isset($this->option()["log"]) && strlen($this->option()["log"] > 0)) {

            /* Por defecto se recibe en String, se convierte en INT y se valida que sea superior a 1 */
            if (intval($this->option()["log"]) >= 1) {

                /* Al cumplir con las condiciones, se agrega el valor a la cantidad. */
                $cantidadPre = intval($this->option()["log"]);

                /* Se comparan la cantidad de commits para determinar cuantos mostrar. */
                if ($cantidadPre < $countCommits) {
                    /* Se lista la cantidad definida por el usuario. */
                    $cantidad = $cantidadPre;
                    $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Commits.');

                } else {
                    /* Se lista el total de commits ya que el numero ingresado es superior al existente */
                    $cantidad = $countCommits - 1;
                    $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Commits Aplicados Ya Que El Valor Ingresado Supera El Real Existente.');

                }

            }

        } else {

            /* Si el usuario no define la cantidad, se listan por defecto 10 commits*/
            $cantidad = 10;
            $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Commits Aplicados Ya Que No Se Definio Una Cantidad A Traves De La Opcion --log=');

        }

        /* Se extrae la cantidad de Commits a mostrar */
        $arrayCommits_t = array_slice($uniqueCommits, 0, ($cantidad));

        /* Saneamiento del Log */
        $arrayCommitsList = ArtisanUtilities::GitLogs($arrayCommits_t);

        /* Pregunta de Seleccion */
        $this->line('Revisa Detenidamente!');

        $preguntaRevert = $this->choice(
            'Selecciona El Cambio A Restarurar.',
            $arrayCommitsList
        );

        /* Cambio definido para revertir */
        $cambio = substr($preguntaRevert, 0, 8);

        /* Arreglo con los Datos del Show */
        $arrayShowCommits = ArtisanUtilities::GitShow($cambio);

        /* Extraer los tres datos relevantes del cambio
        * Consecutivo
        * Fecha
        * Autor
        */
        $salidaShowCommits = array_slice($arrayShowCommits, 0, 3);

        $this->line('Detalles Del Commit Seleccionado:');

        /* Detalles del commit a reversar */
        foreach ($salidaShowCommits as $msjCommit) {
            $this->info($msjCommit);
        }

        /* Comentario del cambio a reversar */
        $this->info('Mensaje Manual Del Cambio:' . $arrayShowCommits[4]);

        /* Pregunta Final de Confirmación */
        if ($this->confirm('¿Estas Seguro(a) De Ejecutar Una Reversion Al Cambio ' . $cambio . '?')) {

            // Ejecutar Reverso al Cambio
            ArtisanUtilities::GitRevert($cambio);

            $this->info(ArtisanUtilities::$last);
            $this->line(ArtisanUtilities::$end);

        } else {
            $this->info(ArtisanUtilities::$cancel);
            $this->line(ArtisanUtilities::$end);

        }
    }
}
