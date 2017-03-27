test:
	./scripts/test.sh
deploy:
    $(MAKE) build:prod
dev:
	$(MAKE) build:dev
build\:dev:
	docker-compose up -d --build
build\:prod:
	git push dokku master
