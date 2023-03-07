<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Git;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class GitCheckOut extends Command
{
    /* Nombre del Comando */
    protected $signature = 'GitCheckOut {--log=}';

    /* Descripcion del proyecto */
    protected $description = 'Ir a Un Cambio Especifico Historico Del Proyecto.';

    /* Codigo del Comando */
    public function handle()
    {
        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Arreglo de Commits */
        $arrayCommits = Git::commits();
        
        /* Mensaje con la cantidad de commits del repositorio */
        $this->info('El Proyecto Cuenta Con Un Total De ' . count($arrayCommits) . ' Cambios Registrados.');
        
        /* Validar si se determino por parte del usuario la cantidad de Commits a mostrar en pantalla. */
        /* Valida que este seteada la opcion y que sea superior a 0 */
        if ((isset($this->option()["log"])) && (intval($this->option()["log"]) > 0)) {

            /* Al cumplir con las condiciones, se agrega el valor a la cantidad. */
            $cantidadPre = intval($this->option()["log"]);

            /* Se comparan la cantidad de commits para determinar cuantos mostrar. */
            if ($cantidadPre < count($arrayCommits)) {
                /* Se lista la cantidad definida por el usuario. */
                $cantidad = $cantidadPre;
                $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Cambios Historicos Aplicados.');

            } else {
                /* Se lista el total de commits ya que el numero ingresado es superior al existente */
                $cantidad = count($arrayCommits);
                $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Cambios Historicos Aplicados Ya Que El Valor Ingresado Supera El Real Existente.');

            }

        } else {

            /* Si el usuario no define la cantidad, se listan por defecto 10 commits*/
            $cantidad = 10;
            $this->info('Se Listaran Un Maximo De ' . $cantidad . ' Cambios Historicos Aplicados Ya Que No Se Definio Una Cantidad A Traves De La Opcion --log="10"');

        }

        /* Se extrae la cantidad de Commits a mostrar */
        $arrayCommitsList = Git::logs($cantidad);

        /* Pregunta de Seleccion */
        $this->warn('Elija El Cambio Al Cual Hacer El Cambio');

        $preguntaRevert = $this->choice(
            'Seleccione A Cual Cambio Ir.',
            $arrayCommitsList
        );

        /* Cambio definido para revertir */
        $cambio = substr($preguntaRevert, 0, 8);
        
        /* Detalles del commit a reversar */
        $this->question('Detalles del Cambio Seleccionado:');
        $this->newLine(); 
        foreach (Git::show($cambio) as $msjCommit) {
            $this->line($msjCommit);
        }
        $this->newLine(); 

        $this->question('Ejecutar Un RESET --HARD');

        /* Pregunta Final de Confirmación */
        if ($this->confirm('¿Esta Seguro(a) De Ir Al Cambio "' . $cambio . '"')) {

            // Ejecutar Reverso al Cambio
            Git::checkout($cambio);
            
            /* Cierre */
            $this->line('Cambio ' . $cambio . ' Aplicado Correctamente.');
            $this->newLine();
            $bar->finish();
            $this->newLine();
            $this->comment(Messages::success());
            if(Utilities::existNotify()){
                $this->notify(Messages::alertTittle(),Messages::alertBody());
            }

            
        } else {
            
            $this->newLine();
            $bar->finish();
            $this->newLine();
            $this->comment(Messages::cancel());
            if(Utilities::existNotify()){
                $this->notify(Messages::alertTittle(),Messages::alertBody());
            }
        }
        
        /* Activacion Errores */
        Utilities::errorShow();
    }
}
