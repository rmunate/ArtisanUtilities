<?php

namespace Rmunate\ArtisanUtilities;

use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\ListCommands;

class Cache
{
    /* Eliminar Temporales Cache */
    public static function deleteTMP()
    {
        /* Carpeta para busqueda de  */
        $files = glob('bootstrap/cache/*.tmp');
        /* Ciclo para eliminacion de archivos */
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }

    /* Configurar Cache */
    public static function artisan()
    {
        foreach (ListCommands::COMMANDS_CACHE as $command => $message) {
            Artisan::call($command);
        }
    }
}

?>