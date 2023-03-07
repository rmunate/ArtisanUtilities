<?php

namespace Rmunate\ArtisanUtilities;

class CommandOS
{

    /* Identificadores MacOS */
    const MAC = ['Mac', 'Darwin'];

    public static function get(){

        /* Inicialmente No Será MAC */
        $macOS = false;

        /* Validacion de Identificadores */
        foreach (Self::MAC as $identifier) { 
            $pos = strpos(php_uname(), $identifier);
            if ($pos !== false) {
                $macOS = true;
            }
        }

        /* Se revisan los comandos que se pueden ejecutar e4n MAC */
        if ($macOS) {
            $data['message'] = "Definidos Los Comandos Compatibles En MAC OS.";
            $data['execute'] = [
                'cache:clear' => 'Cache Eliminado del Proyecto Correctamente',
                'config:clear' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'view:clear' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route:clear' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                //'auth:clear-resets' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event:clear' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue:flush' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule:clear-cache' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado',
            ];
        } else {
            $data['message'] = "Definidos Los Comandos Compatibles En Su Sistema Operativo " . php_uname() . ".";
            $data['execute'] = [
                'cache:clear' => 'Cache Eliminado del Proyecto Correctamente',
                'config:clear' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'view:clear' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route:clear' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                //'auth:clear-resets' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
                'event:clear' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue:flush' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule:clear-cache' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                'optimize' => 'Proyecto Optimizado',
            ];
        }

        /* Retorno Datos a Iterar */
        return (object) $data;
    }

}

?>