#Variables
DOCKER_DIR=.docker

# Commands
up:
	cd ${DOCKER_DIR} && docker-compose build && docker-compose up -d && docker-compose run --rm composer install && docker-compose run --rm npm install

down:
	cd ${DOCKER_DIR} && docker-compose down

refresh:
	cd ${DOCKER_DIR} && docker-compose run --rm composer update && docker-compose run --rm artisan lang:js --no-lib && docker-compose run --rm npm install

delete:
	docker stop $$(docker ps -a -q) && docker rm $$(docker ps -a -q) && docker rmi $$(docker images -a -q)

composer_install:
	cd ${DOCKER_DIR} && docker-compose run --rm composer install

composer_require:
	cd ${DOCKER_DIR} && docker-compose run --rm composer require ${package}

composer_update:
	cd ${DOCKER_DIR} && docker-compose run --rm composer update

artisan_run:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan ${action}

npm_install:
	cd ${DOCKER_DIR} && docker-compose run --rm npm install

npm_run_dev:
	cd ${DOCKER_DIR} && docker-compose run --rm npm run dev

npm_run_watch:
	cd ${DOCKER_DIR} && docker-compose run --rm npm run watch

npm_run_prod:
	cd ${DOCKER_DIR} && docker-compose run --rm npm run prod

schedule_run:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan schedule:run

migrations_refresh:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan migrate:refresh

generate_translations:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan lang:js --no-lib

notify:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan weatherForBasketBall:notify
