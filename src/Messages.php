<?php

namespace Rmunate\ArtisanUtilities;

class Messages
{

    /* Mensaje de Inicio */
    public static function start(){
        return '» Inicio Ejecución Artisan Utilities «';
    }

    /* Mensaje de Cierre */
    public static function end(){
        return '» Fin Ejecución Artisan Utilities «';
    }

    /* Mensaje de Cancelacion */
    public static function cancel(){
        return '» ─── ¡Proceso Cancelado! ─── «';
    }

    /* Mensaje de Cancelacion */
    public static function success(){
        return '» ─── ¡Fin Ejecución Artisan Utilities! ─── «';
    }

    /* Mensaje de Cancelacion */
    public static function alertTittle(){
        return '» Ejecución Completa «';
    }
    
    /* Mensaje de Cancelacion */
    public static function alertBody(){
        return '¡Gracias por utilizar Artizan Utilities!. Grupo Altum Developers';
    }
}

?>