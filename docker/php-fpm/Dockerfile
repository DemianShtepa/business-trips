FROM php:8.1.12-fpm-alpine

RUN set -xe;\
    apk update;\
    apk add --no-cache shadow;\
    apk add --no-cache git;\
    apk add --no-cache postgresql-dev;\
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');";

RUN mv composer.phar /usr/local/bin/composer;

RUN set -xe; \
    usermod -u 1000  www-data;\
    groupmod -g 1000 www-data;

RUN set -xe;\
    docker-php-ext-install pdo;\
    docker-php-ext-install pdo_pgsql;\
    docker-php-ext-install pgsql;

