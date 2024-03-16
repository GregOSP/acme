FROM php:8.2-cli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /app

WORKDIR /app

RUN composer install

# Run PHPUnit tests by default
CMD ["./vendor/bin/phpunit", "tests/"]
