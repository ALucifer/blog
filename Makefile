ifeq (, $(shell which docker-compose))
	DOCKER_COMPOSE ?= docker compose
else
	DOCKER_COMPOSE ?= docker-compose
endif

DCR ?= $(DOCKER_COMPOSE) run --rm

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

build:
	$(DOCKER_COMPOSE) build --parallel --pull

destroy: ## Fully destroy current docker-compose services by stopping them and removing local images, docker managed volumes and docker-compose.override.yaml file.
	$(DOCKER_COMPOSE) down --remove-orphans --volumes --rmi local

bash:
	$(DCR) php bash
