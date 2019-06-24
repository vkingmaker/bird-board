FROM ubuntu:18.04

WORKDIR /var/www/html

RUN apt update \
    && apt install -y nginx \
    && apt install -y php-fpm php-mysql php7.2-gd php7.2-intl php7.2-xsl php-mbstring php7.2-zip php7.2-sqlite3 \
    && apt install -y zip unzip \
    && apt install -y ca-certificates \
    && apt install -y nodejs \
    && apt install -y npm \
    && apt install -y git

# installing composer

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') ===  '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

COPY . .
RUN composer install --no-interaction
RUN npm install
RUN npm run prod

RUN chown -R $USER:www-data storage
RUN chown -R $USER:www-data bootstrap/cache

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf


# Sets the environment variable for production
COPY ./.env.prod /var/www/html/.env


EXPOSE 80

CMD ["bash", "start.sh"]
