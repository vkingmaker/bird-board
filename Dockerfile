FROM ubuntu:18.04

WORKDIR /var/www/html

RUN apt update \
    && apt install -y ca-certificates zip unzip curl \
    && apt install -y nginx mysql-client \
    && apt install -y php-fpm php-mysql php7.2-gd php7.2-intl php7.2-xsl php-mbstring php7.2-zip php7.2-sqlite3 \
    && apt install -y git \
    && curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt install -y nodejs

# installing composer

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN npm install \
    && npm run prod

RUN chown -R $USER:www-data storage \
    && chown -R $USER:www-data bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache


COPY ./nginx/default.conf /etc/nginx/sites-enabled/default
COPY ./php/info.php /var/www/html/public/info.php

EXPOSE 80

CMD ["bash", "start.sh"]
