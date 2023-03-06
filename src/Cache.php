<?php

namespace Rmunate\ArtisanUtilities;

use Illuminate\Support\Facades\Artisan;

class Cache
{
    /* Eliminar Temporales Cache */
    public static function deleteTMP(){
        $files = glob('bootstrap/cache/*.tmp');
        foreach($files as $file){
            if(is_file($file)){
                @unlink($file);
            }
        }
    }

    /* Configurar Cache */
    public static function artisan(){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return true;
    }
}
