<?php
 
namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Cache;
use Rmunate\ArtisanUtilities\Messages;
use Rmunate\ArtisanUtilities\Utilities;

class CacheClear extends Command
{
    /* Nombre del Comando */
    protected $signature = 'CacheClear';

    /* Descripción del Comando */
    protected $description = 'Eliminar todos los caches del proyecto';

    /* @return Void */
    public function handle()
    {
        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Configuracion de Cache --- */
        $this->newLine();
        $this->info('Configuración Total De Cache');

        /* Eliminar Cache Actual */
        Cache::deleteTMP();
        $this->newLine();
        $this->info('Eliminación Configuración De Cache Actual Exitoso');

        /* Configurar Cache */
        Cache::clear();
        $this->question("Cache Actualizado Exitosamente");

        /* ReIniciando Composer */
        $composer = @shell_exec('composer dump-autoload');
        $this->question("Autoload Composer Regenerado");

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

?>