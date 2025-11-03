FROM dunglas/frankenphp:php8.4-alpine

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# add additional extensions here:
RUN install-php-extensions \
    gd \
    intl \
    pcntl \
    zip

COPY . /app