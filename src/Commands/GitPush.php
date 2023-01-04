<?php

/*
|--------------------------------------------------------------------------
| Comandos Personalizados Artisan
|--------------------------------------------------------------------------
| Clase de metodos estaticos para la ejecucion de los comenados externos.
| Autor: Ing. Raul Mauricio Uñate Castro
| V 1.0.0 : 20-12-2021 (Primer Release)
| V 1.2.0 : 01-05-2022 (Segundo Release)
| V 2.0.0 : 19-07-2022 (Comando Reescrito)
| V 3.0.1 : 09-09-2022 (Comando Optimizado)
| V 3.1.0 : 04-01-2023 (Comando Ajustado Para MacOS)
|--------------------------------------------------------------------------
|
*/

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\ArtisanUtilities;

class GitPush extends Command {

    /**
     * Nombre del Comando
     * @var string
     */
    protected $signature = 'GitPush {rama} {--m=}';

    /**
     * Descripcion del proyecto
     * @var string
     */
    protected $description = 'Ejecutar Git Push al repositorio desde una rama puesta como parámetro, con la opción de ejecutar Pull de una Rama especifica creada en el repositorio.';

    /**
     * Mensaje que se retorna si la rama enviada como parametro no es la misma que esta en uso.
     * @var string
     */
    private $msgErrorRama = 'La Rama Ingresada Como Parámetro No Es La Misma Sobre La Cual Se Está Trabajando, Por Favor Vuelva A Ejecutar El Comando Ingresando La Rama Actual.';

    /**
     * Mensaje en los casos donde el comentario personalizado es inferior a 2 caracteres.
     * @var string
     */
    private $msgComentarioInvalido = 'El comentario asociado tiene menos de 2 caracteres, por lo cual no se usará en el Cambio a cargar, Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha.';

    /**
     * Comentario en pantalla en los casos donde no se ingrese un comentario personalizado.
     * @var string
     */
    private $commentDefault = 'Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha, en la ausencia de un comentario personalizado';

    /**
     * Mensaje de Pregunta si desea hacer pull
     * @var string
     */
    private $msgConfirmPull = '¿Deseas Hacer Pull De Una Rama?';

    /**
     * Mensaje previo a seleccionar la rama.
     * @var string
     */
    private $selectRama = 'Selecciona La Rama Desde La Cual Ejecutar El Pull';

    /**
     * Codigo del Comando
     * @return Void
     */
    public function handle(){

        /* Inicio Comando */
        $this->line(ArtisanUtilities::$start);

        /* Argumentos Funcion */
        $rama = $this->argument('rama');

        /* Si la rama enviada como argumento no es la misma en uso, se detendra el proceso */
        if(!ArtisanUtilities::branchValidate($rama)){
            return $this->error($this->msgErrorRama);
        };

        /* Ajustar el Git Ignore */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('AJUSTANDO GIT_IGNORE PRINCIPAL'));
        $this->info(ArtisanUtilities::processLine("Archivo Principal de GitIgnore Ajustado al estandar."));
        @ArtisanUtilities::gitIgnoreBase();

        /* Estatus del proyecto */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('LEYENDO CAMBIOS EN EL PROYECTO'));
        $gitStatus = ArtisanUtilities::GitStatus();
        $this->info(ArtisanUtilities::processLine('Obtenido El Listado De Archivos Modificados'));
        $this->line($gitStatus);

        /* LLamado Comando FlushCache */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('LIMPIANDO EL PROYECTO'));
        $this->info(ArtisanUtilities::processLine('Ejecutado Exitosamente el Comando => php artisan FlushCache'));
        ArtisanUtilities::Call('FlushCache');

        /* GIT ADD . */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('REGISTRANDO CAMBIOS LOCALES EN GIT'));
        $this->line(ArtisanUtilities::processLine('Invocado con Exito => git add .'));
        ArtisanUtilities::GitAdd();
        ArtisanUtilities::ProcessingTime(3);

        /* GIT COMMIT */
        /* Definir si existe comentarios para el Commit */
        if (is_string($this->option()["m"])) {

            /* Se Valida la longitud de la Observacion. */
            if (strlen($this->option()["m"]) > 2) {

                /* LLamado Comando FlushCache */
                ArtisanUtilities::Call('FlushCache');

                /* De tener mas de dos Caracteres, se usará el texto como comentario del commmit */
                $comentarioCommit = $this->option()["m"];
                $this->newLine();
                $this->info(ArtisanUtilities::headerLine('CREANDO CAMBIO'));
                $this->line(ArtisanUtilities::processLine('Invocado con Exito => git commit -m "' . $comentarioCommit . '"'));
                ArtisanUtilities::GitCommit($comentarioCommit);
                ArtisanUtilities::ProcessingTime(3);

            } else {

                /* LLamado Comando FlushCache */
                ArtisanUtilities::Call('FlushCache');

                /* De tener menos de 2 caracteres, se usará el datatime como comentario del commmit */
                $this->info($this->msgComentarioInvalido);

                /* Comentario */
                $comment = ArtisanUtilities::comment($gitStatus);

                /* Git Commit */
                $this->newLine();
                $this->info(ArtisanUtilities::headerLine('CREANDO CAMBIO'));
                $this->line(ArtisanUtilities::processLine('Invocado con Exito => git commit -m "' . $comment . '"'));
                ArtisanUtilities::GitCommit($comment);
                ArtisanUtilities::ProcessingTime(3);
            }

        } else {

            /* LLamado Comando FlushCache */
            ArtisanUtilities::Call('FlushCache');

            /* De no haberse ingresado un comentario en el comando, se usará el datetime como comentario del commmit */
            $this->info($this->commentDefault);

            /* Comentario */
            $comment = ArtisanUtilities::comment($gitStatus);

            /* Git Commit */
            $this->newLine();
            $this->info(ArtisanUtilities::headerLine('CREANDO CAMBIO'));
            $this->line(ArtisanUtilities::processLine('Invocado con Exito => git commit -m "' . $comment . '"'));
            ArtisanUtilities::GitCommit($comment);
            ArtisanUtilities::ProcessingTime(3);

        }

        /* GIT PULL */
        /* Ramas Proyecto | Conocer las Ramas Asociadas al Proyecto. */
        $ramas = ArtisanUtilities::GitBranch();

        /* Generando un array de las ramas. */
        $arrayRamas = explode('remotes/origin/' , $ramas);

        /* De contar con dos ramas o más. */
        if (count($arrayRamas) > 1) {

            /* Arreglo con las Ramas */
            $ramasFinal = ArtisanUtilities::ArrayRamas($arrayRamas);

            /* Cantidad de Ramas */
            $cantidadRamas = count($ramasFinal);

            $preguntaPull = null;
            while ($preguntaPull == null) {

                $this->newLine();
                $this->info(ArtisanUtilities::headerLine('DESCARGAR CAMBIOS DE OTRO DESARROLLADOR!'));
                $this->info('Este Proyecto Tiene Un Total De ' . $cantidadRamas . ' Rama(s) En GIT');

                $preguntaPull = $this->choice($this->msgConfirmPull,['No', 'Si']);

                if ($preguntaPull == 'Si') {

                    $pullRama = $this->choice($this->selectRama,$ramasFinal);

                    /* LLamado Comando FlushCache */
                    ArtisanUtilities::Call('FlushCache');

                    /* Git Pull */
                    $this->newLine();
                    $this->info(ArtisanUtilities::headerLine('DESCARGANDO CAMBIOS'));
                    $this->line(ArtisanUtilities::processLine('Invocado con Exito => git pull origin ' . $pullRama));
                    ArtisanUtilities::GitPull($pullRama);
                    ArtisanUtilities::ProcessingTime(4);

                    /* Git Add */
                    ArtisanUtilities::GitAdd();
                    ArtisanUtilities::ProcessingTime(3);

                    /* Comentario */
                    $comment = 'Pull Desde El Origen =>' . $pullRama;

                    /* Git Commit */
                    $this->newLine();
                    $this->info(ArtisanUtilities::headerLine('CREANDO REGISTRO LOCAL CON LOS CAMBIOS DESCARGADOS'));
                    $this->line(ArtisanUtilities::processLine('Invocado con Exito => git commit -m "' . $comment . '"'));
                    ArtisanUtilities::GitCommit($comment);
                    ArtisanUtilities::ProcessingTime(3);

                }
            }
        }

        /* LLamado Comando FlushCache */
        ArtisanUtilities::Call('FlushCache');

        /* GIT PUSH */
        $this->newLine();
        $this->info(ArtisanUtilities::headerLine('SUBIENDO CAMBIOS A LA RAMA REMOTA'));
        $this->line(ArtisanUtilities::processLine('Invocado con Exito => git push origin ' . $rama));
        ArtisanUtilities::GitPush($rama);
        ArtisanUtilities::ProcessingTime(4);

        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->line(ArtisanUtilities::$end);
    }
}
