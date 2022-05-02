.env: .env.example
	cp .env.example $@

.PHONY: run
run:
	docker-compose up --build

.PHONY: run-dev
run-dev:
	docker-compose -f docker-compose.dev.yml up -d
	docker-compose exec cmd /bin/sh
