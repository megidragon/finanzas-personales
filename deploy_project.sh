sudo docker-compose up -d

sleep 5

cp .env.example .env
sudo docker-compose exec web chgrp -R www-data storage bootstrap/cache
sudo docker-compose exec web chmod -R ug+rwx storage bootstrap/cache
sudo docker-compose exec web composer install
sudo docker-compose exec web php artisan key:generate
sudo docker-compose exec web php artisan migrate:fresh --seed
sudo docker-compose exec web php artisan passport:install