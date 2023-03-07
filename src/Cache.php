<?php

namespace Rmunate\ArtisanUtilities;

use Illuminate\Support\Facades\Artisan;

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
        /* Comandos Artisan Para Ejecucion En Segundo Plano */
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        
    }
}

?>