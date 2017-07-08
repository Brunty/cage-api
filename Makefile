test:
	./scripts/cigar.sh && ./scripts/phpunit.sh
build\:prod:
	git push dokku master
build\:dev:
	docker-compose up -d --build
