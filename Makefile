test:
	./scripts/cigar.sh && ./scripts/phpunit.sh
build\:prod:
	git push dokku master
build\:dev:
	docker-compose up -d --build
install:
	docker-compose exec -T php composer install
