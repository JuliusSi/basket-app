#Variables
DOCKER_DIR=.docker

# Commands
up:
	cd ${DOCKER_DIR} && docker-compose build && docker-compose up -d

down:
	cd ${DOCKER_DIR} && docker-compose down

start: copy_env_file copy_seeder_config composer_install npm_install db_refresh generate_translations npm_run_dev

refresh: composer_update npm_update generate_translations cache_clear npm_run_prod

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
	cd ${DOCKER_DIR} && docker-compose run --rm npm i weekstart

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

notify_about_weather_for_basketball:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan weatherForBasketBall:notify

migrations_migrate:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan migrate

migrations_migrate_force:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan migrate --force

db_seed:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan db:seed

seed_courts:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan db:seed --class=BasketballCourtsSeeder

db_refresh:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan migrate:refresh --seed

log_clear:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan log:clear

cache_clear:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan cache:clear

run_tests:
	cd ${DOCKER_DIR} && docker-compose run --rm artisan test

copy_env_file:
	cp .env.example .env

copy_seeder_config:
	cp config/seeder-example.php config/seeder.php
	cp config/weather-example.php config/weather.php
