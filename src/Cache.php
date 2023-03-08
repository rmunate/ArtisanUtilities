<?php

namespace Rmunate\ArtisanUtilities;

use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\Utilities;
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
    public static function config()
    {
        foreach (ListCommands::COMMANDS_CACHE_CONFIG as $command => $message) {
            if (Utilities::commandExists($command)) {
                Artisan::call($command);
            }
        }
    }

    /* Limpiar Cache */
    public static function clear()
    {
        foreach (ListCommands::COMMANDS_CACHE_CLEAR as $command => $message) {
            if (Utilities::commandExists($command)) {
                Artisan::call($command);
            }
        }
    }
}

?>