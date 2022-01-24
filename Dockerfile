FROM php:7.4.3-alpine

WORKDIR /app

# Upgrade
RUN apk update \
  && apk upgrade -U -a \
  # Install mongo
  && apk add build-base autoconf curl-dev openssl-dev --no-cache \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb

EXPOSE 8080
CMD php -S 0.0.0.0:8080 public/index.php