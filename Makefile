.PHONY: build
build: .env
	composer install --no-dev
	if grep -q "^APP_KEY=$$" .env; then \
		php artisan key:generate; \
	fi

.env:
	cp .env.example $@
