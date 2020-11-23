

.PHONY build
build:
	docker network create weather_soa_network
	docker-compose -f ./weather/docker-compose.yml build
	docker-compose -f ./site/docker-compose.yml build
	docker-compose -f ./weather/docker-compose.yml exec site make install
    docker-compose -f ./site/docker-compose.yml exec weather make install

.PHONY run-test
run-test: build
	docker-compose -f ./weather/docker-compose.yml exec site make test
	docker-compose -f ./site/docker-compose.yml exec weather make test

.PHONY start
start: build
	docker-compose -f ./weather/docker-compose.yml up -d
	docker-compose -f ./site/docker-compose.yml up -d

