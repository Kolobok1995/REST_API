init:
	sudo docker-compose run rest-node-cli npm update;
	sudo docker-compose run rest-composer composer install;
	sudo cp .env.example .env;
	sudo docker-compose up -d;
	sudo docker-compose run rest-php-fpm php artisan migrate;
	sudo chmod -R 777 .;
	sudo docker-compose run rest-node-cli npm run build;
