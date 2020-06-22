# Finanzas personales

> Sistema operativo linux de distribucion debian

### Descripcion
Proyecto de pruebas desarrollado en laravel 7 y php 7.2
El proyecto se levanta mediante docker, o puede levantarse manualmente.

### Pasos de instalacion por docker (Requiere tener instalado docker y docker compose)
- Docker https://docs.docker.com/engine/install/#server
- Docker compose https://docs.docker.com/compose/install/
 
----------------------------------------------------------------------------------------------------------

Correr el comando desde el directorio del proyecto clonado

```sh
chmod +x deploy_project.sh
./deploy_project.sh
```

----------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------

### Pasos de instalacion manual
> Se necesita instalar las librerias php7.2 o superior
> Se necesita instalar las librerias de php mysqli dom zip mbstring sqlite3
> Se necesita instalar mysql5.4 server o superior
> Se necesita tener instalado sqlite3 (Opcionar para realizar los test)
> Se necesita instalar composer https://getcomposer.org/
> (Opcional) Nginx o apache para mantener levantado el proyecto

Desde el directorio del proyecto clonado
```sh
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan passport:install
```

Una vez realizados estos el proyecto esta listo para levantarse mediante
```sh
php artisan serve
```

Para correrlo en servidor se necesita asignar permisos
```sh
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```