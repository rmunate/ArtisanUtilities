<?php

namespace Rmunate\ArtisanUtilities;

class Ignore
{
    /* Registrar Archivos a Ignorar */
    public static function create(){

        $file_storage_app_public = base_path() . '\.gitignore';

        if(unlink($file_storage_app_public)){

            $gitignore = fopen($file_storage_app_public, 'w');

            /* Archivos que se Ignoran por defecto */
            fwrite($gitignore, "# Git Ignore Default Artisan Utilities" . PHP_EOL);

            /* Node JS */
            if (file_exists(base_path() . '/node_modules')) fwrite($gitignore, "/node_modules" . PHP_EOL);

            /* Carpeta Publica */
            if (file_exists(base_path() . '/public/build')) fwrite($gitignore, "/public/build" . PHP_EOL);
            if (file_exists(base_path() . '/public/hot')) fwrite($gitignore, "/public/hot" . PHP_EOL);
            if (file_exists(base_path() . '/public/storage')) fwrite($gitignore, "/public/storage" . PHP_EOL);

            /* Uso de Vue JS */
            if (file_exists(base_path() . '/public/mix-manifest.json')){
                fwrite($gitignore, "/public/mix-manifest.json" . PHP_EOL);
                fwrite($gitignore, "/public/css/app.css" . PHP_EOL);
                fwrite($gitignore, "/public/js/app.js" . PHP_EOL);
            }

            /* Carpeta Storage */
            if (file_exists(base_path() . '/storage')){
                fwrite($gitignore, "/storage" . PHP_EOL);
                fwrite($gitignore, "/storage/*.key" . PHP_EOL);
            }

            /* Carpeta Vendor */
            if (file_exists(base_path() . '/vendor')) fwrite($gitignore, "/vendor" . PHP_EOL);

            /* Carpeta ENV */
            if (file_exists(base_path() . '/.env')) fwrite($gitignore, "/.env" . PHP_EOL);
            if (file_exists(base_path() . '.env')) fwrite($gitignore, ".env" . PHP_EOL);
            if (file_exists(base_path() . '/.env.backup')) fwrite($gitignore, "/.env.backup" . PHP_EOL);
            if (file_exists(base_path() . '.env.backup')) fwrite($gitignore, ".env.backup" . PHP_EOL);

            /* Paqueteria JS */
            if (file_exists(base_path() . 'npm-debug.log')) fwrite($gitignore, "npm-debug.log" . PHP_EOL);
            if (file_exists(base_path() . '/npm-debug.log')) fwrite($gitignore, "/npm-debug.log" . PHP_EOL);
            if (file_exists(base_path() . 'yarn-error.log')) fwrite($gitignore, "yarn-error.log" . PHP_EOL);
            if (file_exists(base_path() . '/yarn-error.log')) fwrite($gitignore, "/yarn-error.log" . PHP_EOL);
            if (file_exists(base_path() . 'yarn-debug.log')) fwrite($gitignore, "yarn-debug.log" . PHP_EOL);
            if (file_exists(base_path() . '/yarn-debug.log')) fwrite($gitignore, "/yarn-debug.log" . PHP_EOL);

            /* Homestead */
            if (file_exists(base_path() . 'Homestead.json')) fwrite($gitignore, "Homestead.json" . PHP_EOL);
            if (file_exists(base_path() . '/Homestead.json')) fwrite($gitignore, "/Homestead.json" . PHP_EOL);
            if (file_exists(base_path() . 'Homestead.yaml')) fwrite($gitignore, "Homestead.yaml" . PHP_EOL);
            if (file_exists(base_path() . '/Homestead.yaml')) fwrite($gitignore, "/Homestead.yaml" . PHP_EOL);

            /* Auth */
            if (file_exists(base_path() . 'auth.json')) fwrite($gitignore, "auth.json" . PHP_EOL);
            if (file_exists(base_path() . '/auth.json')) fwrite($gitignore, "/auth.json" . PHP_EOL);

            /* Uso de Docker */
            if (file_exists(base_path() . 'docker-compose.override.yml')) fwrite($gitignore, "docker-compose.override.yml" . PHP_EOL);
            if (file_exists(base_path() . '/docker-compose.override.yml')) fwrite($gitignore, "/docker-compose.override.yml" . PHP_EOL);

            /* Carpetas de IDE*/
            if (file_exists(base_path() . '.idea')) fwrite($gitignore, ".idea" . PHP_EOL);
            if (file_exists(base_path() . '/.idea')) fwrite($gitignore, "/.idea" . PHP_EOL);
            if (file_exists(base_path() . '.vscode')) fwrite($gitignore, ".vscode" . PHP_EOL);
            if (file_exists(base_path() . '/.vscode')) fwrite($gitignore, "/.vscode" . PHP_EOL);

            /* PHP Unit */
            if (file_exists(base_path() . '.phpunit.result.cache')) fwrite($gitignore, ".phpunit.result.cache" . PHP_EOL);
            if (file_exists(base_path() . '/.phpunit.result.cache')) fwrite($gitignore, "/.phpunit.result.cache" . PHP_EOL);

            /* Carpeta Dist */
            if (file_exists(base_path() . '/dist')) fwrite($gitignore, "/dist" . PHP_EOL);
            if (file_exists(base_path() . 'dist/')) fwrite($gitignore, "dist/" . PHP_EOL);

            /* Composer LOCK */
            if (file_exists(base_path() . '/composer.lock')) fwrite($gitignore, "/composer.lock" . PHP_EOL);
            if (file_exists(base_path() . 'composer.lock')) fwrite($gitignore, "composer.lock" . PHP_EOL);

            /* Archivos DS Mac */
            if (file_exists(base_path() . '/.DS_Store')) fwrite($gitignore, "/.DS_Store" . PHP_EOL);
            if (file_exists(base_path() . '.DS_Store')) fwrite($gitignore, ".DS_Store" . PHP_EOL);

            /* Cerrar Archivo */
            fclose($gitignore);

        }
    }

    /* Default Storage App */
    public static function storageApp(){
        $file_storage_app = storage_path('app/.gitignore');
        if (!file_exists($file_storage_app)) {
            $gitignore = fopen($file_storage_app, 'w');
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!public/" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            fclose($gitignore);
        }
    }

    /* Default Storage App Public */
    public static function storageAppPublic(){
        $file_storage_app_public = storage_path('app/public/.gitignore');
        if (!file_exists($file_storage_app_public)) {
            $gitignore = fopen($file_storage_app_public, 'w');
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            fclose($gitignore);
        }
    }

    /* Default Storage Framework */
    public static function storageFramework(){
        $file_storage_framework_cache = storage_path('framework/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $gitignore = fopen($file_storage_framework_cache, 'w');
            /* Configuración por defecto. */
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!cache/" . PHP_EOL);
            fwrite($gitignore, "!sessions/" . PHP_EOL);
            fwrite($gitignore, "!testing/" . PHP_EOL);
            fwrite($gitignore, "!views/" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            /* Configuración Escrituras Adicionales */
            fwrite($gitignore, "compiled.php" . PHP_EOL);
            fwrite($gitignore, "config.php" . PHP_EOL);
            fwrite($gitignore, "down" . PHP_EOL);
            fwrite($gitignore, "events.scanned.php" . PHP_EOL);
            fwrite($gitignore, "maintenance.php" . PHP_EOL);
            fwrite($gitignore, "routes.php" . PHP_EOL);
            fwrite($gitignore, "routes.scanned.php" . PHP_EOL);
            fwrite($gitignore, "schedule-*" . PHP_EOL);
            fwrite($gitignore, "services.json" . PHP_EOL);
            fclose($gitignore);
        }
    }

    /* Default Storage Framework Cache */
    public static function storageFrameworkCache(){
        $file_storage_framework_cache = storage_path('framework/cache/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $file_git_ignore4 = fopen($file_storage_framework_cache, 'w');
            fwrite($file_git_ignore4, "*" . PHP_EOL);
            fwrite($file_git_ignore4, "!data/" . PHP_EOL);
            fwrite($file_git_ignore4, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore4);
        }
    }

    /* Default Storage Framework Cache Data */
    public static function storageFrameworkCacheData(){
        $file_storage_framework_cache_data = storage_path('framework/cache/data/.gitignore');
        if (!file_exists($file_storage_framework_cache_data)) {
            $file_git_ignore5 = fopen($file_storage_framework_cache_data, 'w');
            fwrite($file_git_ignore5, "*" . PHP_EOL);
            fwrite($file_git_ignore5, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore5);
        }
    }

    /* Default Storage Framework Session */
    public static function storageFrameworkSession(){
        $file_storage_framework_session = storage_path('framework/sessions/.gitignore');
        if (!file_exists($file_storage_framework_session)) {
            $file_git_ignore6 = fopen($file_storage_framework_session, 'w');
            fwrite($file_git_ignore6, "*" . PHP_EOL);
            fwrite($file_git_ignore6, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore6);
        }
    }

    /* Default Storage Framework Testing */
    public static function storageFrameworkTesting(){
        $file_storage_framework_testing = storage_path('framework/testing/.gitignore');
        if (!file_exists($file_storage_framework_testing)) {
            $file_git_ignore7 = fopen($file_storage_framework_testing, 'w');
            fwrite($file_git_ignore7, "*" . PHP_EOL);
            fwrite($file_git_ignore7, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore7);
        }
    }

    /* Default Storage Framework Views */
    public static function storageFrameworkViews(){
        $file_storage_framework_views = storage_path('framework/views/.gitignore');
        if (!file_exists($file_storage_framework_views)) {
            $file_git_ignore8 = fopen($file_storage_framework_views, 'w');
            fwrite($file_git_ignore8, "*" . PHP_EOL);
            fwrite($file_git_ignore8, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore8);
        }
    }

    /* Default Storage Logs */
    public static function storageLogs(){
        $file_storage_logs = storage_path('logs/.gitignore');
        if (!file_exists($file_storage_logs)) {
            $file_git_ignore9 = fopen($file_storage_logs, 'w');
            fwrite($file_git_ignore9, "*" . PHP_EOL);
            fwrite($file_git_ignore9, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore9);
        }
    }

}