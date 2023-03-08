<?php

namespace Rmunate\ArtisanUtilities;
use Illuminate\Support\Facades\Artisan;

class Utilities
{

    /* Demorar Ejecucion */
    public static function sleep(int $time){
        sleep($time);
    }

    /* Ocultar Los Errores de PHP */
    public static function errorHidden(){
        error_reporting(0);
    }

    /* Mostrar Los Errores de PHP */
    public static function errorShow(){
        error_reporting(-1);
    }

    /* Cambiar Permisos */
    public static function chmod($folder){
        if (str_contains(php_uname(), 'Windows')) {
            @chmod($folder, 0777);
        } else {
            @shell_exec('chmod -R 777 ' . $folder . '/');
        }
    }

    /* Crear Carpeta */
    public static function mkdir($folder){
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    /* Validar Si Existe Una Funcion */
    public static function existNotify(){
        return class_exists('NunoMaduro\LaravelDesktopNotifier\LaravelDesktopNotifierServiceProvider');
    }

    /* Eliminacion Recursiva Carpeta */
    public static function rrmdir(string $src) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if (is_dir($full) ) {
                    Self::rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

    /* Validar Si Tiene Spatie */
    public static function existLaravelPermission(){
        return class_exists('Spatie\Permission\PermissionServiceProvider');
    }

    /* Validar Si Un Comando Existe */
    public static function commandExists($name)
    {
        return array_has(Artisan::all(), $name);
    }
    
}

?>