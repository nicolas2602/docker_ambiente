FROM php:8.1.18-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apachectl restart 

EXPOSE 80