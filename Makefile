# Commands
up:
	cd .docker && docker-compose build && docker-compose up -d && docker-compose run --rm composer install && docker-compose run --rm npm install

down:
	cd .docker && docker-compose down

delete:
	docker stop $$(docker ps -a -q) && docker rm $$(docker ps -a -q) && docker rmi $$(docker images -a -q)

composer_install:
	cd .docker && docker-compose run --rm composer install

composer_require:
	cd .docker && docker-compose run --rm composer require ${package}

composer_update:
	cd .docker && docker-compose run --rm composer update

artisan:
	cd .docker && docker-compose run --rm artisan ${action}

npm_install:
	cd .docker && docker-compose run --rm npm install

npm_update:
	cd .docker && docker-compose run --rm npm update

npm_run_dev:
	cd .docker && docker-compose run --rm npm run dev

npm_run_watch:
	cd .docker && docker-compose run --rm npm run watch

npm_run_prod:
	cd .docker && docker-compose run --rm npm run prod

schedule_run:
	cd .docker && docker-compose run --rm artisan schedule:run

migrations_refresh:
	cd .docker && docker-compose run --rm artisan migrate:refresh

notify:
	cd .docker && docker-compose run --rm artisan weatherForBasketBall:notify
