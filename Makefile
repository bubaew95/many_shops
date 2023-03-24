up:
	docker-compose up
start:
	docker-compose up --build
f-start:
	docker-compose up -d --build

stop:
	docker-compose stop
c-stop:
	docker-compose stop $(name)

migrations:
	symfony console make:migration

migrate:
	symfony console doctrine:migrations:migrate

