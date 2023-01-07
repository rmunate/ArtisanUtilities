<?php

namespace Rmunate\ArtisanUtilities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Permission\PermissionRegistrar;
use Rmunate\ArtisanUtilities\ArtisanUtilities;
use Symfony\Component\Console\Helper\TableCell;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class Spatie extends Command {

    /**
     * Nombre del Comando
     * @var string
     */
    protected $signature = 'mac-php';

    /* Descripción del Comando */
    protected $description = 'Cambie su versión de PHP en MAC OS.';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start); 

        
        
        
    
        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
