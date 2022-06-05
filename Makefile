DOCKER_COMPOSE  = docker compose
EXEC_YARN = $(DOCKER_COMPOSE) exec php yarn
EXEC_PHP = $(DOCKER_COMPOSE) exec php
SYMFONY = $(EXEC_PHP) bin/console
COMPOSER = $(EXEC_PHP) composer

##
---------------------------- : ##
----- PROJECT & DOCKER ----- : ##
---------------------------- : ##

build:  ## Build docker
build:
	@$(DOCKER_COMPOSE) pull --parallel --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull

build-nocache: ## Build docker without cache
build-nocache:
	@$(DOCKER_COMPOSE) pull --parallel --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull --no-cache

start: ## Start the project
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
stop:
	$(DOCKER_COMPOSE) stop

kill: ## Kill all containers & volumes
kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

clean: ## Stop the project and remove generated files
clean: kill
	docker volume rm $(docker volume ls -q)
	rm -rf .env vendor var/cache/* var/log/* public/build/*

reset: ## Stop and start a fresh install of the project
reset: kill install

install: ## Install and start the project
install:  build start db front-install front-build-dev

install-nocache: ## Install and start the project without cache
install-nocache: build-nocache start db front-install front-build-dev

no-docker: ## Remove docker's var
no-docker:
	$(eval DOCKER_COMPOSE := \#)
	$(eval EXEC_PHP := )


.PHONY: build build-nocache install-nocache kill install reset start stop clean no-docker deploy install-nocache


##
---------------------------- : ##
---------- UTILS ----------- : ##
---------------------------- : ##

fixture: ## Reset database using fixtures
fixture:
	$(SYMFONY) hautelook:fixtures:load --no-interaction --purge-with-truncate

db: ## Reset the database and init data commands
db: flush vendor
	git submodule init
	git submodule update
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:migration:migrate --no-interaction

fixtures:
	$(SYMFONY) hautelook:fixtures:load --no-interaction --purge-with-truncate

db-update: ## Update database with --force
db-update: flush vendor
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:schema:update --dump-sql
	$(SYMFONY) doctrine:schema:update --force --no-interaction

db-validate-schema: ## Validate the doctrine ORM mapping
db-validate-schema: vendor
	$(SYMFONY) doctrine:schema:validate

clear: ## clear cache
clear: vendor
	rm -rf var/cache/*
	rm -rf var/logs/*
	$(SYMFONY) cache:clear --env=dev

flush: ## Flush db query / metadata / result
flush: vendor
	-$(SYMFONY) doctrine:cache:clear-query
	-$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:cache:clear-result

console: ## Console symfony (bin/console)
console: vendor
	$(SYMFONY) $(filter-out $@,$(MAKECMDGOALS))


liip-cache-clear: ## Clear and warmup liipimagine cache
	$(SYMFONY) liip:imagine:cache:remove

##
---------------------------- : ##
-------- Frontend ---------- : ##
---------------------------- : ##

front-install: ## Install front dependencies with yarn
front-install:
	$(EXEC_YARN) install

front-build-dev: ## Build dev
front-build-dev:
	$(EXEC_YARN) encore dev

front-watch: ## Watch
front-watch:
	$(EXEC_YARN) encore dev --watch

front-build-prod: ## Build prod
front-build-prod:
	$(EXEC_YARN) encore production


##
---------------------------- : ##
----------- API ------------ : ##
---------------------------- : ##


#gen-jwt: ## Generate JWT public & private key on docker
#gen-jwt:
#	$(EXEC_PHP) sh -c 'set -e;mkdir -p config/jwt;echo $(JWT_PASSPHRASE) | openssl genpkey -out config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096;echo $(JWT_PASSPHRASE) | openssl pkey -in config/jwt/private.pem -passin stdin -out config/jwt/public.pem -pubout'


.PHONY: db clear flush console

# Tests

# rules based on files
composer.lock: composer.json
	rm -rf var/cache/*
	rm -rf var/logs/*
	$(COMPOSER) config --global process-timeout 2000
	$(COMPOSER) clearcache
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	rm -rf var/cache/*
	rm -rf var/logs/*
	$(COMPOSER) config --global process-timeout 2000
	$(COMPOSER) clearcache
	$(COMPOSER) install

#.DEFAULT_GOAL := help
#help:
#	@IFS=$$'\n' ; \
#	help_lines=(`fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##/:/'`); \
#    printf "\033[32m %s\n" ""; \
#    printf "%-30s %s\n" ""; \
#    printf "%-30s %s\n" "____________________________________________________"; \
#	printf "%-30s %s\n" "|     __  __            _____   _______ __     __  |"; \
#    printf "%-30s %s\n" "|    |  \/  |    /\    |  __ \ |__   __|\ \   / /  |"; \
#    printf "%-30s %s\n" "|    | \  / |   /  \   | |__) |   | |    \ \_/ /   |"; \
#    printf "%-30s %s\n" "|    | |\/| |  / /\ \  |  _  /    | |     \   /    |"; \
#    printf "%-30s %s\n" "|    | |  | | / ____ \ | | \ \    | |      | |     |"; \
#    printf "%-30s %s\n" "|    |_|  |_|/_/    \_\|_|  \_\   |_|      |_|     |"; \
#    printf "%-30s %s\n" "|                                                  |"; \
#    printf "%-30s %s\n" "____________________________________________________"; \
#	printf "%-30s %s\n" ""; \
#	for help_line in $${help_lines[@]}; do \
#		IFS=$$':' ; \
#		help_split=($$help_line) ; \
#		help_command=`echo $${help_split[0]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
#		help_info=`echo $${help_split[2]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
#		printf '\033[36m'; \
#		printf "%-30s %s" $$help_command ; \
#		printf '\033[0m'; \
#		printf "%s\n" $$help_info; \
#	done
#.PHONY: help
