<?php

namespace Rmunate\ArtisanUtilities;

class ListCommands
{
    /* Comandos Para Configuracion de Cache */
    const COMMANDS_CACHE_CLEAR = [
        'schedule:clear-cache'  =>  'Cache De Calendario, Volcado Correctamente.',
        'cache:clear'           =>  'Cache General, Volcado Correctamente.',
        'config:clear'          =>  'Cache De Configuración, Volcado Correctamente.',
        'event:clear'           =>  'Cache De Eventos, Volcado Correctamente.',
        'optimize:clear'        =>  'Cache De Optimización, Volcado Correctamente.',
        'route:clear'           =>  'Cache De Rutas, Volcado Correctamente.',
        'view:clear'            =>  'Cache De Vistas, Colcado Correctamente.'
    ];

    const COMMANDS_CACHE_CONFIG = [
        'config:clear'          =>  'Volcado Configuración.',
        'config:cache'          =>  'Ejecutada La Configuración De Cache.',
        'optimize'              =>  'Ejecutada La Optimización Del Proyecto.'
    ];

    const COMMANDS_DEPLOY = [
        'key:generate'          =>  'Creacion Nueva Llave Pryecto (.ENV).',
    ];

    const COMMANDS_LARAVEL_PASSPORT = [
        'passport:keys'          =>  'Creacion Nueva Llave Pryecto (.ENV).',
    ];

    /* OrderDeploy */
    public static function orderDeploy(){
        return (object) [
            'message' => "Definidos Los Comandos Compatibles En Su Proyecto Sobre El Sistema Operativo " . php_uname() . ".",
            'list' => array_unique(
                array_merge(
                    Self::COMMANDS_DEPLOY,
                    Self::COMMANDS_CACHE_CLEAR,
                    Self::COMMANDS_CACHE_CONFIG
                )
            )
        ];
    }

    /* Para Flush Cache */
    public static function orderCacheClear(){
        return (object) [
            'message' => "Definidos Los Comandos Compatibles En Su Proyecto Sobre El Sistema Operativo " . php_uname() . ".",
            'list' => Self::COMMANDS_CACHE_CLEAR,
        ];
    }


}

?>