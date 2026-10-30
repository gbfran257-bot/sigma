# Laravel 9 con Platilla AdminLTE 

## Comenzando 🚀

_Sigue las siguientes instruscciones para clonar este repositorio en tu máquina local y poder trabajar desde el principio con la plantilla AdminLTE en Laravel 9._

### Pre-requisitos 📋

Para clonar este repositorio, debes tener instalado un servidor Apache, PHP y MSQL (Wamp, Xampp, Mamp o Lamp) y los gerenciadores de dependencias para PHP (Composer) y para NodeJs (Npm).

Antes de comenzar verifica si tienes composer con cualquiera de los siguientes comandos en tu terminal.
```
composer --version 
composer -v
```
Si no lo tienes instalado lo pueden instalar siguiendo la documentación oficial en:  
https://getcomposer.org/doc/00-intro.md

Verifica tambien la version de NPM en la terminal con
```
npm --version
```
Si no lo tienes instalado lo pueden instalar siguiendo la documentación oficial en:  
https://www.npmjs.com/get-npm

Verifica las versiones de cada uno de ellos

Versión PHP - 8.0  
Versión Mysql - 5.7.34  
Versión Composer - 2.3.5  
Versión NPM - 8.15.0  

### Instalación 🔧

_Sigue las siguientes instrucciones para clonar el repositorio_

_Clone el repositorio_

```
git clone https://github.com/jorgehernandezch/Laravel-9-AdminLTE.git
```

_Instale todas las dependencias del Proyecto con_

```
composer install
```

_Actualize las dependencias de Composer con_

```
composer update
```

_Como el proyecto tiene dependencias en JS instalelas con_

```
npm install
```

_Actualize las dependencias de NPM con_

```
npm update
```

_Copie el Archivo .env.example en un archivo nuevo .env con_

```
cp .env.example .env
```
_Configure la base de datos y las demas variables de entorno en el archivo .env_

_Genere una nueva Key para el protecto con_

```
php artisan key:generate
```

_Corra las migraciones del proyecto con_

```
php artisan migrate
```

_Corra los seeder del proyecto con_

```
php artisan db:seed
```
_Corra el proyecto con_

```
php artisan serve
```

_Si todo está correcto puede acceder al proyecto en la dirección http://localhost:8000_ con el Usuario admin@admin.com - Admin

## Docker

En la última actualización se ha configurado el proyecto para trabajar en conjunto a la red local 'sigma', esto para permitir mantener los servicios separados. Por lo que a continuación se describe como se ejecuta el proyecto:

-   Ambos proyectos se ejecutan con el comando `docker-compose up -d [--build]` (Agregando build cuando se modifique el Dockerfile), el orden de ejecución es:
    - 1 sigma-web-interno
    - 2 servicio-timbrado-php (En caso de solo querer correr el servicio de timbrado, se ha señalado una linea en "Network" que se debe comentar para que pueda correr solo)
-   servicio-timbrado-php contiene 2 Dockerfile dentro de la carpeta Docker:
    - Dockerfile.dev es una imágen báse que se utiliza durante el desarrollo y debe utilizarse siempre en conjunto con el docker-compose.yaml. Es necesario realizar los pasos previos para configurar el proyecto durante el proceso de desarrollo (copiar el archivo .env.example a .env, npm install, composer install, php artisan key:generate, etc), esto dentro de la máquina virtual que está corriendo el proyecto: `docker exec -it {nombre_del_contenedor} bash` o seleccionando en contenedor en el Docker Desktop en la pestaña Terminal.
    - Dockerfile es la imágen de producción y contiene los comandos necesarios para generar la imágen del proyecto en productivo.
-   Los puertos por defecto son:
    - http://localhost:8000 sigma-web-interno
    - http://localhost:8010 servicio-timbrado-php
-   Para comunicar los servicios, debes utilizar el nombre del servicio y el puerto original ej: Una llamada desde sigma-web-interno debería ser http://api_facturacion:80 o http://api_facturacion (esto debido al nombre que se le dio al servicio en el docker-compose.yaml) 
-   Se han removido los puertos de mapeo de las BDs dejandolas internas para evitar colisiones, pero es posible agregar un servicio de phpMyAdmin o simplemente mapear los puertos de las BDs (Recuerda mapear el puerto externo de ambas BDs a un puerto diferente en cada archivo YAML)

Documentacion imagen utilizada: https://dockerfile.readthedocs.io/en/latest/content/DockerImages/dockerfiles/php-apache.html
---
[Jorge Edo. Hernández](https://github.com/jorgehernandezch)  
_Ingeniero y Desarrollador Web_
