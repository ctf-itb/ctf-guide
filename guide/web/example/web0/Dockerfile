FROM php:7.0-apache
RUN docker-php-ext-install mysqli
RUN chown -R root:root /var/www/html
COPY ./src/ /var/www/html