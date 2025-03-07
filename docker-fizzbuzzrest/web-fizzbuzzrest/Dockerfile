FROM php:8.3-apache

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install -y apt-utils iputils-ping telnet pv wget g++ git zip vim
RUN docker-php-ext-install intl opcache pdo
RUN pecl install apcu
RUN docker-php-ext-enable apcu

RUN set -eux; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    pecl clear-cache

RUN set -eux; \
    docker-php-source extract; \
    cp /usr/src/php/php.ini-development /usr/local/etc/php/php.ini; \
    cd /usr/local/etc/php; \
    sed -i -e "s|max_execution_time = 30|max_execution_time = 10|" php.ini; \
    sed -i -e "s|memory_limit = 128M|memory_limit = 256M|" php.ini; \
    sed -i -e "s|post_max_size = 8M|post_max_size = 1M|" php.ini; \
    sed -i -e "s|upload_max_filesize = 2M|upload_max_filesize = 1M|" php.ini; \
    sed -i -e "s|;date.timezone =|date.timezone = Europe/Lisbon|" php.ini; \
    sed -i -e "s|;cgi.fix_pathinfo=1|cgi.fix_pathinfo = 0|" php.ini; \
    sed -i -e "s|;realpath_cache_size = 4096k|realpath_cache_size = 4096K|" php.ini; \
    sed -i -e "s|;realpath_cache_ttl = 120|realpath_cache_ttl = 600|" php.ini; \
    docker-php-source delete

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && a2enmod headers \
    && service apache2 restart

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
