PROJECT_NAME:="trip-calc"
WHERE_CD:="docker"
PROJECT_SOURCE_PREFIX:="../src"

include docker/Makefile


ifeq ($(DOCKER_COMPOSE_EXECUTABLE),)
	DOCKER_COMPOSE_EXECUTABLE := "docker-compose"
endif

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

SHORT_COMPOSE := && cd $(WHERE_CD) && $(DOCKER_COMPOSE_EXECUTABLE) -f docker-compose.yml
VARIABLES:= export PROJECT_SOURCE_PREFIX=$(PROJECT_SOURCE_PREFIX) CURRENT_UID=$(CURRENT_UID)
COMPOSE:=$(VARIABLES) $(SHORT_COMPOSE)

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down
	#docker volume rm $(PROJECT_NAME)_nfsmount || true

logs:
	$(COMPOSE) logs

composer:
	$(COMPOSE) run -u $(CURRENT_UID) --entrypoint bash php

cs-check:
	 $(COMPOSE) run -u $(CURRENT_UID) --entrypoint bash php -c "./vendor/bin/phpcs  -s -p -n"

cs-fix:
	 $(COMPOSE) run -u $(CURRENT_UID) --entrypoint bash php -c  "php vendor/bin/phpcbf -p -l"

