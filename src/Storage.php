<?php

namespace Rmunate\ArtisanUtilities;

use Rmunate\ArtisanUtilities\Ignore;
use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\Utilities;

class Storage
{

    /* Validar Si Maneja Llaves Para Apps */
    public static function oauthPublicKey(){
        return (file_exists(base_path()  . '/storage/oauth-public.key')) ? true : false;
    }

    /* Eliminacion y creacion de la carpeta Storage */
    public static function default(){

        /* Previo a la eliminacion se debe determinar si el proyecto cuenta con passport:keys [Laravel Passport] */
        $oauth_public_key = Self::oauthPublicKey();

        #1. CARPETA PRINCIPAL.
        $path_storage = base_path() . '/storage';
        if (!file_exists($path_storage)) {
            mkdir($path_storage, 0777, true);
        } else {
            Utilities::rrmdir($path_storage);
            mkdir($path_storage, 0777, true);
        }

        #2. SUBCARPETA APP
        Utilities::mkdir(storage_path('app'));

        #2.1. GitIgnore Carpeta.
        Ignore::storageApp();

        #2.2 Validacion Existencia Carpeta Storage/app/public
        Utilities::mkdir(storage_path('app/public'));

        #2.2.1 Validacion Existencia archivo en carpeta Storage/app/public
        Ignore::storageAppPublic();

        #3. SUB CARPETA FRAMEWORK | Validacion Existencia Carpeta Storage/framework
        Utilities::mkdir(storage_path('framework'));

        #3.1 Validacion Existencia archivo en carpeta Storage/framework/cache
        Ignore::storageFramework();

        #3.2 Validacion Existencia Carpeta Storage/framework/cache
        Utilities::mkdir(storage_path('framework/cache'));

        #3.3. Validacion Existencia archivo en carpeta Storage/framework/cache
        Ignore::storageFrameworkCache();

        #3.4. Validacion Existencia Carpeta Storage/framework/cache/data
        Utilities::mkdir(storage_path('framework/cache/data'));

        #3.5 Validacion Existencia archivo en carpeta Storage/framework/cache
        Ignore::storageFrameworkCacheData();

        #3.6 Validacion Existencia Carpeta Storage/framework/sessions
        Utilities::mkdir(storage_path('framework/sessions'));

        #3.7 Validacion Existencia archivo en carpeta Storage/framework/sessions
        Ignore::storageFrameworkSession();

        #3.8 Validacion Existencia Carpeta Storage/framework/testing
        Utilities::mkdir(storage_path('framework/testing'));

        #3.9 Validacion Existencia archivo en carpeta Storage/framework/testing
        Ignore::storageFrameworkTesting();

        #3.10 Validacion Existencia Carpeta Storage/framework/views
        Utilities::mkdir(storage_path('framework/views'));

        #3.11 Validacion archivo en carpeta Storage/views */
        Ignore::storageFrameworkViews();

        #4 ELIMINACION Y CREACION LOGS
        #4.1 Creacion Carpeta de Logs
        Utilities::mkdir(storage_path('logs'));

        #4.2 Git Ignore Logs
        Ignore::storageLogs();

        // Creacion Nuevo Archivo de Logs
        Self::clearLogs();

        /* Permisos CHMOD */
        Utilities::chmod('storage');

        /* Despues de Crear la carpeta en caso de manejar clave rehacerla === Laravel Passport === */
        if ($oauth_public_key) {
            Artisan::call('passport:keys');
        }
    }

    /* Reiniciar Log */
    public static function clearLogs(){
        if (@unlink(storage_path('logs/laravel.log'))) {
            $file_handle = fopen(storage_path('logs/laravel.log'), 'w');
            fclose($file_handle);
        }
    }
    
}
