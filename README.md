# Artisan Git Utilities
## _Automatización Manejo GIT, Permisos, Caches, etc. Ideal para trabajo en Equipo_

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Este paquete contiene diversos comandos de Artisan que buscan ejecutar diferentes trabajos relacionados con el control de cambios, el trabajo comunitario y la optimización del proyecto. Todo desde la facilidad del terminal.
Funciona para proyectos Laravel ^8.0 y PHP ^7.4

## Características

-	Ejecute comandos rápidos desde la terminal y deje que el paquete trabaje por usted.
-	Ejecute cargues y descargues de cambios en GIT con las mejores prácticas (Automatizadas).
-	Limpie su proyecto las veces que quiera con una sola línea (Limpie el cache, tokken vencidos, etc.).
-	Mejore el rendimiento del sistema con un simple comando. (Permisos a Public y Storage, Ajuste de los GitIgnore, etc.).

## Instalación

# Instalar con Composer.
```sh
composer require rmunate/artisan-utilities
```

# (OPCIONAL) Presentar el Proveedor en el archivo config\app.php.

```sh
'providers' => [
	//...
	Rmunate\ArtisanUtilities\ArtisanUtilitiesServiceProvider::class,
],
```

## Comandos

Podrá invocar el comando que requiera desde la terminal sobre la raiz principal del proyecto.

```sh
php artisan FlushCache
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan FlushCache` | Ejecute la limpieza total de su proyecto (cache, vistas, rutas, configuración, autenticación, eventos, colas, calendarios), recuerde estar conectado a la base de datos, ya que se ejecutará la limpieza de información “basura” desde las tablas por defecto de Laravel (Sin tocar información del sistema). Elimina los Logs del proyecto. Ajusta la configuración correcta de la carpeta Storage. Asigna los permisos que corresponden a las diferentes carpetas del Framework para garantizar el correcto funcionamiento. |

```sh
php artisan DefaultStorage
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan DefaultStorage` | Ajusta o crea la carpeta Storage del Framework de acuerdo al estándar. |

```sh
php artisan DefaultIgnore
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan DefaultIgnore` | Ajusta el Git Ignore principal del proyecto, de acuerdo con el estándar del Framework, adicional valida si usa dependencias de NPM o carpetas del IDE para igualmente ignorarlas en los cargues. |

```sh
php artisan ConfigCache
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan ConfigCache` | Ajusta el cache del proyecto, eliminando los archivos previos de configuración, creando los nuevos y regenerando el autoload de composer. |

```sh
php artisan AccessFolders
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan AccessFolders` | Ajusta los permisos de las carpetas del Proyecto. Brinda accesos de escritura a la carpeta Public y a la carpeta Storage. |


```sh
// Estrcutura Con Comentario
php artisan GitPush Rama --m=“Comentario commit”

//Estructura Sin Comentario
php artisan GitPush Rama 
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan GitPush Rama --m=“Comentario commit”` | Cargue los cambios de su repositorio a GIT (al Git que tenga configurada su máquina), este comando se puede ejecutar con comentario o sin comentario `php artisan GitPush Rama”` en este caso la misma librería le asignará un comentario de los archivos ajustados.  Además, el comando le preguntará si desea descargar cambios de alguna rama remota del proyecto, ejecutando la tarea por usted. Solo deberá seleccionar la rama de la cual quiere bajar cambios de la lista desplegable que le entrega el comando. |

![image](https://user-images.githubusercontent.com/91748598/189487197-9054821b-8d2a-42fd-b9be-cf0b2a830779.png)

```sh
php artisan PHPVersion
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan PHPVersion` | Retorna la versión en uso de PHP. |

```sh
php artisan mac-php
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan mac-php` | (MAC OS) (Solo si se trabaja con HomeBrew) Lista las versiones de PHP disponibles instaladas en el MAC, permitiendo seleccionar cual configurar al sistema. |

```sh
php artisan fpm-php
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan fpm-php` | (LINUX UBUNTU PHP-FPM) Permite cambiar la versión de PHP configurada en el servidor Linux Ubunto. |

```sh
php artisan apache-restart
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan apache-restart` | (LINUX UBUNTU) Reiniciar el servicio de Apache en el servidor |

```sh
php artisan apache-restart-fpm
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan apache-restart-fpm` | (LINUX UBUNTU PHP-FPM) Reiniciar el servicio de Apache en el servidor Lunux Ubunto con FPM instalado. |

```sh
php artisan Spatie Show
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan Spatie Show` | (Solo si se usa Spatie Permission) Lista los permisos creados en el sistema. |

```sh
php artisan Spatie Cache
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan Spatie Cache` | (Solo si se usa Spatie Permission) Limpia el cache de permisos de Spatie sobre todo el sistema. |

```sh
php artisan GitReset --log=“10”
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan GitReset --log=“10”` | GitReset es el comando que usamos cuando queremos mover el repositorio a una confirmación anterior, descartando cualquier cambio realizado después de esa confirmación, este comando es el igual a (git reset), se debe ejecutar bajo la responsabilidad que amerita el regresar el proyecto descartando los cambios posteriores. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |

```sh
php artisan GitRevert --log=“10”
```

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| `php artisan GitRevert --log=“10”` | GitRevert es el comando que usamos cuando queremos revertir el efecto de algunos cambios anteriores (posiblemente defectuosos), no elimina los cambios solo revierte lo implementado en las confirmaciones posteriores a la seleccionada para revertir. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |

## Desarrollador

- Ingeniero, Raúl Mauricio Uñate Castro
- raulmauriciounate@gmail.com
- (Recomendaciones y sugerencias por correo electrónico)
