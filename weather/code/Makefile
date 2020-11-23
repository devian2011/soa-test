
all: install

.PHONY: install
install:
	composer install
	./bin/console doctrine:migrations:migrate -n
	./bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction

.PHONY: test
test:
	./bin/console doctrine:schema:drop --force --full-database --env=test
	./bin/console doctrine:schema:create --env=test
	./bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction --env=test
	./bin/phpunit