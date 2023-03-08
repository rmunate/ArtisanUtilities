# Artisan Utilities (LARAVEL)
> [![Raul Mauricio Uñate Castro](https://storage.googleapis.com/lola-web/storage_apls/RecursosCompartidos/LogoGithubLibrerias.png)](#)

Paquete de Comandos Artisan con diversas funcionalidades dentro del proyecto, con la capacidad de ejecutar diversas tareas que van desde el correcto manejo de las fuentes hasta el debugger por consola de sus funciones o algoritmos.

## Características
-   Maneje sus fuentes en GIT a través de comandos artisan que ejecutan en las tareas por usted, garantizando las mejores practicas.
-   Configure el cache de su proyecto de la forma correcta con un solo comando.
-   Limpie su proyecto (log, temporales, etc) con un solo comando.
-   Ajuste el .gitignore de su proyecto desde la facilidad de la terminal, el sistema escanea por usted las carpetas y genera el estándar que corresponda.
-   Ajuste los permisos de los directorios para el correcto funcionamiento de manejo de archivos.
-   Si trabaja en MAC con HomeBrew puede cambiar entre las versiones de PHP instaladas.
-   Si trabaja desde Linux o hace deploy en este Sistema Operativo, podrá reiniciar servicios, o desplegar la configuración del proyecto desde un solo comando.

# Instalación
## _Instalación a través de Composer_

```console
composer require rmunate/artisan-utilities 5.0.x-dev
```

## _(OPCIONAL) Presentar el Proveedor en el archivo config\app.php_

```php
'providers' => [
	//...Providers Actuales
	Rmunate\ArtisanUtilities\ArtisanUtilitiesServiceProvider::class,
],
```

## Metodos Git

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| `php artisan GitPush Rama --m"Comentario"` | Cargue los cambios de su repositorio a GIT (al Git que tenga configurada su máquina), este comando se puede ejecutar con comentario o sin comentario `php artisan GitPush Rama”` en este caso la misma librería le asignará un comentario de los archivos ajustados.  Además, el comando le preguntará si desea descargar cambios de alguna rama remota del proyecto, ejecutando la tarea por usted. Solo deberá seleccionar la rama de la cual quiere bajar cambios de la lista desplegable que le entrega el comando. |
| `php artisan GitReset --log"10"` | GitReset es el comando que usamos cuando queremos mover el repositorio a una confirmación anterior, descartando cualquier cambio realizado después de esa confirmación, este comando es el igual a (git reset --hard), se debe ejecutar bajo la responsabilidad que amerita el regresar el proyecto descartando los cambios posteriores. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |
| `php artisan GitRevert --log"10"` | GitRevert es el comando que usamos cuando queremos revertir el efecto de algunos cambios anteriores (posiblemente defectuosos), no elimina los cambios solo revierte lo implementado en las confirmaciones posteriores a la seleccionada para revertir. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |
| `php artisan GitCheckOut --log"10"` | GitCheckOut es el comando que usamos cuando queremos ir a el estado de algún cambio anterior especifico. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |
| `php artisan DefaultIgnore` | Ajusta el Git Ignore principal del proyecto, de acuerdo con el estándar del Framework, adicional valida si usa dependencias de NPM o carpetas del IDE para igualmente ignorarlas en los cargues. |

## Metodos Framework

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| `php artisan ConfigCache` | Ajusta el cache del proyecto, eliminando los archivos previos de configuración, creando los nuevos y regenerando el autoload de composer. |
| `php artisan ConfigCache` | Elimina la configuración del cache del proyecto, sin crear nuevo cache. |
| `php artisan FlushCache` | Ejecute la limpieza total de su proyecto (cache, vistas, rutas, configuración, autenticación, eventos, colas, calendarios), recuerde estar conectado a la base de datos, ya que se ejecutará la limpieza de información “basura” desde las tablas por defecto de Laravel (Sin tocar información del sistema). Elimina los Logs del proyecto. Ajusta la configuración correcta de la carpeta Storage. Asigna los permisos que corresponden a las diferentes carpetas del Framework para garantizar el correcto funcionamiento. |
| `php artisan DefaultStorage` | Ajusta o crea la carpeta Storage del Framework de acuerdo al estándar. |
| `php artisan debugger "App\Models\User::first()"` | Ejecuta el debugger del codigo desde la terminal. |

## Metodos Utilitarios

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| `php artisan AccessFolders` | Ajusta los permisos de las carpetas del Proyecto. Brinda accesos de escritura a la carpeta Public y a la carpeta Storage. |
| `php artisan php-version` | Retorna la versión en uso de PHP. |
| `php artisan php-mac` | (MAC OS) (Solo si se trabaja con HomeBrew) Lista las versiones de PHP disponibles instaladas en el MAC, permitiendo seleccionar cual configurar al sistema. |
| `php artisan apache-restart-fpm` | (LINUX UBUNTU PHP-FPM) Reiniciar el servicio de Apache en el servidor Lunux Ubunto con FPM instalado. |
| `php artisan apache-restart` | (LINUX UBUNTU) Reiniciar el servicio de Apache en el servidor. |
| `php artisan deploy` | (LINUX UBUNTU) Ejecuta todas las líneas de comandos para garantizar el correcto funcionamiento del proyecto en el ambiente productivo, crea una nueva llave, regenera el cache, asigna permisos, actualiza dependencias, alerta ajustes en el ENV, etc. |

## Metodos Librerias Externas

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| `php artisan Spatie Cache` | (Solo si se usa Spatie Permission) Limpia el cache de permisos de Spatie sobre todo el sistema. |
| `php artisan Spatie Show` | (Solo si se usa Spatie Permission) Lista los permisos creados en el sistema. |


## Mantenedores
- Ingeniero, Raúl Mauricio Uñate Castro (raulmauriciounate@gmail.com)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)