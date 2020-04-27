# INSTALLATION 

Add to etc/hosts
127.0.0.1 local.eactivos.com

##Git repository


Install vendors 
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

//Install assets for sonata admin
bin/console assets:install 

Register user
curl -X POST \
   http://local.eactivos.com:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "username":"test@test.com",
    "password":"12345",
    "email":"test@test.com"
  }' 

Obtain token of administrator user (Necessary to obtain information from API)
curl -X POST \
  http://local.eactivos.com:8080/api/auth/login \
  -H 'Content-Type: application/json' \
  -d '{
    "username": "admin@admin.com",
    "password": "12345"
}'

Obtain all auctions, lots and bids
curl -X GET \
  http://local.eactivos.com:8080/api/v1/auctions/all \
  -H 'Authorization: Bearer {JWT_EY}' \
  -H 'Content-Type: application/json' \
  
Obtain all users and their bids
  curl -X GET \
    http://local.eactivos.com:8080/api/v1/users/all \
    -H 'Authorization: Bearer {JWT_EY}' \
    -H 'Content-Type: application/json' \

Obtain all bids made by specific user
curl -X GET \
  http://local.eactivos.com:8080/api/v1/user/{user_id}/bids \
  -H 'Authorization: Bearer {JWT_EY}' \
  -H 'Content-Type: application/json' \