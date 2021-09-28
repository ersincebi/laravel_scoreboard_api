all: build install

build:
	@docker-compose build
	@docker-compose up -d
	@docker ps
install:
	@docker-compose exec -T php composer install
	# @docker-compose exec -T mysql mysql -u root -p laravel < ./docker/mysql/laravel.sql
clean:
	@docker-compose down
	@docker system prune -af
	@docker volume prune -f
