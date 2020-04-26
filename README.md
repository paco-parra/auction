Add 127.0.0.1       local.eactivos.com to etc/hosts

Instalar vendors 
composer install

Iniciar Docker
cd docker
docker-compose up -d

//Run application

//Build schema && run fixtures
docker-compose run --rm docker-php-cli /var/www/bin/console doctrine:schema:update --force
docker-compose run --rm docker-php-cli /var/www/bin/console doctrine:fixtures:load

//Run yarn build to compile assets
docker-compose run --rm docker-encore yarn build 


Register user
curl -X POST \
   http://local.eactivos.com:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "username":"test@test.com",
    "password":"12345",
    "email":"test@test.com"
  }' 

Obtener Token de usuario administrador (Necesario para obtener información de la API)
curl -X POST \
  http://local.eactivos.com:8080/api/auth/login \
  -H 'Content-Type: application/json' \
  -d '{
    "username": "admin@admin.com",
    "password": "12345"
}'