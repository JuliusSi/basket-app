up:
	cd .docker && docker-compose build && docker-compose up -d

down:
	cd .docker &&
	docker stop $(docker ps -a -q)
	docker rm $(docker ps -a -q)
	docker rmi $(docker images -a -q)

composer_install:
	cd .docker && docker-compose run --rm composer install

composer_require:
	cd .docker && docker-compose run --rm composer require ${package}

artisan:
	cd .docker && docker-compose run --rm artisan ${action}

npm_install:
	cd .docker && docker-compose run --rm npm install

npm_run_dev:
	cd .docker && docker-compose run --rm npm run dev

npm_run_watch:
	cd .docker && docker-compose run --rm npm run watch
