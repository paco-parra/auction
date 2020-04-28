# EXPLICACIÓN
Se ha desarrollado la aplicación bajo el Framework Symfony versión 4.4

### Bundles principales utilizados:
* FOSUserBundle
* Sonata Admin Bundle
* FOSRestBundle
* JWT Authentication 
* Doctrine
* Webpack Encore
* Twig
* PHPUnit

### Docker containers
* PHP-FPM
* PHP-CLI
* NGINX 
* MySql database
* Encore

### La aplicación consta de:
* Un sistema de login y resgitro 
* Una homepage en la que se muestran las últimas 3 subastas publicadas acompañadas de un botón/link que te envía a un listado de todas las subastas disponibles
* Un listado de todas las subastas disponibles (cuya fecha de expiración es mayor a la fecha actual, en el caso de que haya expirado no saldrían)
* Un listado de los Lotes que componen la subasta con su precio y el precio inicial (en el caso de que aún no  tenga una puja) o el precio de la última puja.
* Una vista en detalle del lote, aparecerá a la izquierda una galería con la imágenes de todos los productos que contiene el lote, a la derecha información 
relacionada con el lote (título, precio, mayor puja y disponibilidad), y un botón para realizar una puja (sólo si está la sesión iniciada), y debajo de la galería la descripción del lote y un listado
de los productos que contiene.
* Un listado de los lotes sobre los que un usuario a realizado pujas, el link aparece en el header una vez la sesión está iniciada
* Una función para hacer una puja sobre un lote, esta función tiene algunas restricciones
    * Si la última puja es tuya no te permite realizar una nueva y muestra un error
    * No puedes realizar una puja de un importe menor que la anterior
    * No permite nulo
    * Valor mayor a 0
* Un backoffice en el que se puede crear/editar/ver subastas, lotes y pujas
* Test de varias funciones de la plataforma con PHPUnit

## Git repository
https://github.com/paco-parra/eactivos-test

# INSTALLATION 

Add to etc/hosts in localhost
127.0.0.1 local.eactivos.com

### Install vendors 

```bash
composer install
```

### Run Docker

```bash
cd docker
docker-compose up -d
```

### Build schema && run fixtures

```bash
* docker-compose run --rm docker-php-cli /var/www/bin/console doctrine:schema:update --force
* docker-compose run --rm docker-php-cli /var/www/bin/console doctrine:fixtures:load
```

### Run yarn build to compile assets

```bash
docker-compose run --rm docker-encore yarn build 
```

### Install assets for sonata admin
```bash
bin/console assets:install 
```

#Access to Backoffice 
http://local.eactivos.com:8080/admin/
User: admin@admin.com
Password: 12345

# API ENDPOINTS
### Register user
```bash
curl -X POST \
   http://local.eactivos.com:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "username":"test@test.com",
    "password":"12345",
    "email":"test@test.com"
  }' 
```

### Obtain token of administrator user (Necessary to obtain information from API)
```bash
curl -X POST \
  http://local.eactivos.com:8080/api/auth/login \
  -H 'Content-Type: application/json' \
  -d '{
    "username": "admin@admin.com",
    "password": "12345"
}'
```

### Obtain all auctions, lots and bids
```bash
curl -X GET \
  http://local.eactivos.com:8080/api/v1/auctions/all \
  -H 'Authorization: Bearer {JWT_EY}' \
  -H 'Content-Type: application/json' \
```
  
### Obtain all users and their bids
```bash
  curl -X GET \
    http://local.eactivos.com:8080/api/v1/users/all \
    -H 'Authorization: Bearer {JWT_EY}' \
    -H 'Content-Type: application/json' \
```

### Obtain all bids made by specific user
```bash
curl -X GET \
  http://local.eactivos.com:8080/api/v1/user/{user_id}/bids \
  -H 'Authorization: Bearer {JWT_EY}' \
  -H 'Content-Type: application/json' \
```

# Run PHPUnit test
```bash
In aaplication root directory
./bin/phpunit
```