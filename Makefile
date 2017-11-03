SHELL = /bin/sh

DOCKER ?= $(shell which docker)
VOLUME := /srv
IMAGE ?= graze/php-alpine:test
DOCKER_RUN := ${DOCKER} run --rm -t -v $$(pwd):${VOLUME} -w ${VOLUME} ${IMAGE}

.PHONY: build build-update composer-% clean help
.PHONY: test lint lint-fix test-unit test-coverage

.SILENT: help


build: ## Download the dependencies then build the image :rocket:.
	make 'composer-install --prefer-dist --optimize-autoloader'

build-update: ## Update all dependencies
	make 'composer-update --prefer-dist --optimize-autoloader ${PREFER_LOWEST}'

composer-%: ## Run a composer command, `make "composer-<command> [...]"`.
	${DOCKER} run -t --rm \
        -v $$(pwd):/app \
        -v ~/.composer:/tmp \
        composer --ansi --no-interaction $* $(filter-out $@,$(MAKECMDGOALS))

# Testing

test: ## Run the unit and integration testsuites.
test: lint test-unit

lint: ## Run phpcs against the code.
	${DOCKER_RUN} vendor/bin/phpcs -p --warning-severity=0 src/ tests/

lint-fix: ## Run phpcsf and fix possible lint errors.
	${DOCKER_RUN} vendor/bin/phpcbf -p src/ tests/

test-unit: ## Run the unit testsuite.
	${DOCKER_RUN} vendor/bin/phpunit --testsuite unit

test-matrix: ## Run the unit tests against multiple targets.
	${MAKE} IMAGE="php:5.6-alpine" test
	${MAKE} IMAGE="php:7.0-alpine" test
	${MAKE} IMAGE="php:7.1-alpine" test
	${MAKE} IMAGE="hhvm/hhvm:latest" test

test-coverage: ## Run all tests and output coverage to the console.
	${DOCKER_RUN} phpdbg7 -qrr vendor/bin/phpunit --coverage-text

clean: ## Stop running containers and clean up an images.
	rm -rf vendor/

help: ## Show this help message.
	echo "usage: make [target] ..."
	echo ""
	echo "targets:"
	fgrep --no-filename "##" $(MAKEFILE_LIST) | fgrep --invert-match $$'\t' | sed -e 's/## / - /'
