#Variables
DOCKER_DIR=.docker

# Commands
up:
	cd ${DOCKER_DIR} && docker-compose build && docker-compose up -d && docker-compose run --rm composer install --ignore-platform-reqs && docker-compose run --rm npm install

down:
	cd ${DOCKER_DIR} && docker-compose down

refresh:
	cd ${DOCKER_DIR} && docker-compose run --rm composer update && docker-compose run --rm artisan lang:js --no-lib && docker-compose run --rm npm install

delete:
	docker stop $$(docker ps -a -q) && docker rm $$(docker ps -a -q) && docker rmi $$(docker images -a -q)

composer_install:
	cd ${DOCKER_DIR} && docker-compose run --rm composer install --ignore-platform-reqs

composer_require:
	cd ${DOCKER_DIR} && docker-compose run --rm composer require ${package}

composer_update:
	cd ${DOCKER_DIR} && docker-compose run --rm composer update --ignore-platform-reqs

artisan_run:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan ${action}

npm_install:
	cd ${DOCKER_DIR} && docker-compose run --rm npm install

npm_run_dev:
	cd ${DOCKER_DIR} && docker-compose run --rm npm run dev

npm_update:
	cd ${DOCKER_DIR} && docker-compose run --rm npm update

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

migrations_migrate:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan migrate

db_seed:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan db:seed

db_refresh: migrations_refresh db_seed

log_clear:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan log:clear
