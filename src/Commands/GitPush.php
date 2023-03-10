<?php

namespace Rmunate\ArtisanUtilities\Commands; 

use Illuminate\Console\Command;
use Rmunate\ArtisanUtilities\Git;
use Rmunate\ArtisanUtilities\Cache;
use Rmunate\ArtisanUtilities\Storage;
use Rmunate\ArtisanUtilities\Messages;
use Illuminate\Support\Facades\Artisan;
use Rmunate\ArtisanUtilities\Utilities;
use Rmunate\ArtisanUtilities\ListCommands;
use Rmunate\ArtisanUtilities\Notification;

class GitPush extends Command
{
    /* Nombre del Comando */
    protected $signature = 'GitPush {rama} {--m=}';
    
    /* Descripcion del proyecto */
    protected $description = 'Ejecutar Git Push al repositorio desde una rama puesta como parámetro, con la opción de ejecutar Pull de una Rama especifica creada en el repositorio.';
    
    /* Contantes (Mensajes) */
    const INVALID_COMMENT = 'El comentario asociado tiene menos de 2 caracteres, por lo cual no se usará en el Cambio a cargar, Registraremos el nombre del(los) archivo(s) modificado(s) de existir cambios.';

    const MESSAGE_DEFAULT = 'Registraremos el nombre del(los) archivo(s) modificado(s) de existir cambios, en la ausencia de un comentario personalizado';

    const QUESTION_PULL = '¿Deseas Hacer Pull De Una Rama?';

    const CHOICE_BRANCH = 'Selecciona La Rama Desde La Cual Ejecutar El Pull';

    const ERROR_ARGUMENT = 'Debe Relacionar La Rama Origen ejempo: "php artisan GitPush Raul"';

    const ERROR_BRANCH = 'La Rama Ingresada Como Argumento No Es La Misma Sobre La Cual Se Está Trabajando, Por Favor Vuelva A Ejecutar El Comando Sobre La Rama Correcta.';
    
    public function handle()
    {
        /* Inicio Comando */
        $bar = $this->output->createProgressBar(100);
        Utilities::errorHidden();
        $this->comment(Messages::start());

        /* Validar que haya un argumento */
        if (empty($this->argument('rama'))) {
            $rama = $this->error(Self::ERROR_ARGUMENT);
            return;
        }

        /* Si la rama enviada como argumento no es la misma en uso, se detendra el proceso */
        $rama = Git::validateBranch($this->argument('rama'));
        if(!$rama->validate){ 
            $this->error(Self::ERROR_BRANCH);
            $this->error('La rama actual en uso es: "' . $rama->name . '"');
            return;
        };
        
        /* Estatus del proyecto */
        $this->newLine();
        $this->info('Leyendo Cambios Del Proyecto.');
        $gitStatus = Git::status();
        $this->info('Obtenido El Listado De Archivos Modificados');
        $this->line($gitStatus);

        /* LLamado Comando FlushCache */
        $this->newLine();
        $this->info(trim('Limpiando El Proyecto ' . env('APP_NAME', '')));

        Storage::clearLogs();
        Cache::deleteTMP();
        $commands = ListCommands::orderCacheClear();
        $this->info($commands->message);
        foreach ($commands->list as $command => $comment) {
            if (Utilities::commandExists($command)) {
                Artisan::call($command);
                $this->line($comment);
            }
        }
        Utilities::chmod('storage');
        Utilities::chmod('public');
        $this->question('Ejecutado Exitosamente El Limpiado Del Proyecto.');

        /* GIT ADD . */
        $this->newLine();
        $this->info('Registrando Cambios Locales');
        Git::add();
        Utilities::sleep(3);
        $this->question('Invocado con Exito => "git add ."');

        
        /* GIT COMMIT - Definir si existe comentarios para el Commit */
        $options = $this->option();
        $comment = null;
        if (is_string($options["m"])) {

            /* Se Valida la longitud de la Observacion. */
            if (strlen($options["m"]) > 2) {
                
                $this->newLine();
                $this->info('Registrando Cambio');
                Git::commit($options["m"]);
                Utilities::sleep(3);
                $this->question('Invocado con Exito => git commit -m "' . $options["m"] . '"');
                $comment = $options["m"];

            } else {

                /* De tener menos de 2 caracteres, se usará el datatime como comentario del commmit */
                $this->warn(Self::INVALID_COMMENT);

                /* Comentario Por Defecto */
                $comment = Git::default_comment($gitStatus);

                /* Git Commit */
                $this->newLine();
                $this->info('Registrando Cambio');
                Git::commit($comment);
                Utilities::sleep(3);
                $this->question('Invocado con Exito => git commit -m "' . $comment . '"');
            }

        } else {

            /* De no haberse ingresado un comentario en el comando, se usará el datetime como comentario del commmit */
            $this->info(Self::MESSAGE_DEFAULT);

            /* Comentario Por Defecto */
            $comment = Git::default_comment($gitStatus);

            /* Git Commit */
            $this->newLine();
            $this->info('Registrando Cambio');
            Git::commit($comment);
            Utilities::sleep(3);
            $this->question('Invocado con Exito => git commit -m "' . $comment . '"');

        }
        
        /* GIT PULL - Ramas Proyecto | Conocer las Ramas Asociadas al Proyecto diferentes a la que esta en uso. */
        $ramas = Git::getOtherBranches();

        /* De contar con ramas adicionales. */
        if (count($ramas) >= 1) {

            $preguntaPull = null;
            while ($preguntaPull == null) {

                $this->newLine();
                $this->info('¡Descargar Cambios Remotos!');
                $this->info('Este Proyecto Tiene Un Total De ' . count($ramas) . ' Rama(s) Remotas En GIT');

                $preguntaPull = $this->choice(Self::QUESTION_PULL, ['No', 'Si']);

                if ($preguntaPull == 'Si') {

                    $pullRama = $this->choice(Self::CHOICE_BRANCH, $ramas);

                    /* Git Pull */
                    $this->newLine();
                    $this->info('Descargando Cambios');
                    Git::pull($pullRama);
                    Utilities::sleep(4);
                    $this->question('Invocado con Exito => "git pull origin ' . $pullRama . '"');

                    /* Git Add */
                    Git::add();
                    Utilities::sleep(3);

                    /* Comentario */
                    $comment = 'Pull Desde El Origen => ' . $pullRama;

                    /* Git Commit */
                    $this->newLine();
                    Git::commit($comment);
                    Utilities::sleep(3);
                    $this->info('Registrando Cambio Con Los Datos Recibidos En El Pull.');
                    $this->question('Invocado con Exito => git commit -m "' . $comment . '"');

                }
            }
        }
        
        /* GIT PUSH */
        $this->newLine();
        $this->info('Publicando Cambios En La Rama Remota.');
        Git::push($this->argument('rama'));
        Utilities::sleep(4);

        /* Enviar Email */
        $email = new Notification();
        $email->setbranch($this->argument('rama'));
        $email->setChanges($gitStatus);
        $email->setComment($comment);
        $email->send();

        $this->question('Invocado con Exito => "git push origin ' . $this->argument('rama') . '"');

        /* Cierre */
        $this->newLine();
        $bar->finish();
        $this->newLine();
        $this->comment(Messages::success());
        if(Utilities::existNotify()){
            $this->notify(Messages::alertTittle(),Messages::alertBody());
        }

        /* Activacion Errores */
        Utilities::errorShow();
    }
}

?>