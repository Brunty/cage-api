test:
	vendor/bin/cigar && vendor/bin/phpunit
deploy:
	git push dokku master
install:
	composer install
