test:
	./scripts/test.sh
build\:prod:
	git push dokku master
build\:dev:
	docker-compose up -d --build
