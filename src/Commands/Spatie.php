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
    protected $signature = 'Spatie {action}';

    /* Descripción del Comando */
    protected $description = 'Comandos Spatie Show(Listar Comandos) Cache(Limpiar Cache Permisos).';

    /* @return Void */
    public function handle(){

        /* Inicio de Comando */
        $this->line(ArtisanUtilities::$start);
        
        /* Argumento Comando */
        $action = $this->argument('action');

        if ($action == 'Show') {
            
            $permissionClass = app(PermissionContract::class);
            $roleClass = app(RoleContract::class);
            $team_key = config('permission.column_names.team_foreign_key');

            $style = 'default';
            $guards = $permissionClass::pluck('guard_name')->merge($roleClass::pluck('guard_name'))->unique();

            foreach ($guards as $guard) {

                $this->newLine();
                $this->info("Accediendo A La Libreria Spatie");
                $this->newLine();
                $this->info("Guard: $guard");

                $roles = $roleClass::whereGuardName($guard)
                    ->with('permissions')
                    ->when(config('permission.teams'), function ($q) use ($team_key) {
                        $q->orderBy($team_key);
                    })
                    ->orderBy('name')->get()->mapWithKeys(function ($role) use ($team_key) {
                        return [$role->name.'_'.($role->$team_key ?: '') => ['permissions' => $role->permissions->pluck('id'), $team_key => $role->$team_key ]];
                    });

                $permissions = $permissionClass::whereGuardName($guard)->orderBy('name')->pluck('name', 'id');

                $body = $permissions->map(function ($permission, $id) use ($roles) {
                    return $roles->map(function (array $role_data) use ($id) {
                        return $role_data['permissions']->contains($id) ? ' ✔' : ' ·';
                    })->prepend($permission);
                });

                if (config('permission.teams')) {
                    $teams = $roles->groupBy($team_key)->values()->map(function ($group, $id) {
                        return new TableCell('Team ID: '.($id ?: 'NULL'), ['colspan' => $group->count()]);
                    });
                }

                $this->table(
                    array_merge([
                        config('permission.teams') ? $teams->prepend('')->toArray() : [],
                        $roles->keys()->map(function ($val) {
                            $name = explode('_', $val);

                            return $name[0];
                        })
                        ->prepend('')->toArray(),
                    ]),
                    $body->toArray(),
                    $style
                );
                
            }
        } else if ($action == 'Cache') {

            if (app(PermissionRegistrar::class)->forgetCachedPermissions()) {
                $this->newLine();
                $this->info('Cache De Permisos Reiniciados.');
            } else {
                $this->newLine();
                $this->error('No se logró Reiniciar el Cache.');
            }

        } else {

            $this->error('Comando No Valido');
            $this->info('php artisan Spatie Show [Use este comando para listar los permisos actuales]');
            $this->info('php artisan Spatie Cache [Use este comando para limpiar el Cache de Permisos]');

        }
        
        /* Cierre */
        $this->newLine();
        $this->info(ArtisanUtilities::$last);
        $this->newLine();
        $this->line(ArtisanUtilities::$end);

    }
}
