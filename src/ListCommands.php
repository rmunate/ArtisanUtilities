<?php

namespace Rmunate\ArtisanUtilities;

class ListCommands
{
    /* Litado de Comandos Globles Ajecutar */
    const COMMANDS_ALL = [
        'optimize'              =>  'Revisión De La Optimización Del Proyecto.',
        'config:cache'          =>  'Revisión Configuración De Cache.',
        'config:clear'          =>  'Cache De Configuración Del Proyecto, Volcado Correctamente.',
        'cache:clear'           =>  'Cache General Del Proyecto, Volcado Correctamente.',
        'view:clear'            =>  'Cache De Vistas, Colcado Correctamente.',
        'route:clear'           =>  'Cache De Rutas, Volcado Correctamente.',
        'event:clear'           =>  'Cache De Eventos, Volcado Correctamente.',
        'queue:flush'           =>  'Cache de Cola, volcado correctamente.',
        'schedule:clear-cache'  =>  'Cache de Calendario, volcado correctamente.',
        'auth:clear-resets'     =>  'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos'
    ];

    /* Comandos Para Configuracion de Cache */
    const COMMANDS_CACHE_CLEAR = [
        'route:clear'           =>  'Cache De Rutas, Volcado Correctamente.',
        'event:clear'           =>  'Cache De Eventos, Volcado Correctamente.',
        'cache:clear'           =>  'Cache General Del Proyecto, Volcado Correctamente.',
        'config:clear'          =>  'Cache De Configuración Del Proyecto, Volcado Correctamente.',
        'view:clear'            =>  'Cache De Vistas, Colcado Correctamente.',
        'config:cache'          =>  'Revisión Configuración De Cache.'
    ];

    const COMMANDS_CACHE_CONFIG = [
        'config:cache'          =>  'Revisión Configuración De Cache.',
        'optimize'              =>  'Revisión De La Optimización Del Proyecto.'
    ];

    /* Mensajes */
    const MAC =  'Definidos Los Comandos Compatibles Y Dispoinibles En Su Proyecto.';


    /* Local */
    public static function get(){

        /* Se revisan los comandos que se pueden ejecutar en MAC */
        /* Algunos Comandos No Se Ejecutan Correctamente, listar los de funcionamiento correcto y los erroneos. */
        if ($macOS) {
            $data['message'] = "Definidos Los Comandos Compatibles En MAC OS.";
            $data['execute'] = [
                'optimize' => 'Proyecto Optimizado',
                'config:cache' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'config:clear' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'cache:clear' => 'Cache Eliminado del Proyecto Correctamente',
                'view:clear' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route:clear' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'event:clear' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue:flush' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule:clear-cache' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                //'auth:clear-resets' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
            ];
        } else {
            $data['message'] = "Definidos Los Comandos Compatibles En Su Sistema Operativo " . php_uname() . ".";
            $data['execute'] = [
                'optimize' => 'Proyecto Optimizado',
                'cache:clear' => 'Cache Eliminado del Proyecto Correctamente',
                'config:clear' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
                'view:clear' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
                'route:clear' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
                'event:clear' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
                'queue:flush' => 'Cache de Cola Eliminado del Proyecto Correctamente',
                'schedule:clear-cache' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
                //'auth:clear-resets' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
            ];
        }

        /* Retorno Datos a Iterar */
        return (object) $data;
    }
    
}

?>