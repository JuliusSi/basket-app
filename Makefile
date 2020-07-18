make up:
	cd .docker && docker-compose build && docker-compose up -d

make down:
	docker stop $(docker ps -a -q)
	docker rm $(docker ps -a -q)
	docker rmi $(docker images -a -q)

make composer install:
	cd .docker && docker-compose run --rm composer install

make composer require:
	cd .docker && docker-compose run --rm composer require ${package}

make artisan:
	cd .docker && docker-compose run --rm artisan ${action}

make npm run dev:
	cd .docker && docker-compose run --rm npm run dev
