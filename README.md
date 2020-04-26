Add 127.0.0.1       local.eactivos.com to etc/hosts

Iniciar Docker
cd docker
docker-compose up -d

Iniciar la aplicación
cd docker
//access php cli container to create schema and load fixtures
docker exec -it docker_docker-php-cli_1 bash 
cd /var/www/
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load


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