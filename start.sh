#!/bin/bash

chmod +x wait-for-it.sh
php artisan config:cache && php artisan route:cache
echo 'Waiting for Mysql to be available'
maxTries=10
while [ ${maxTries} -gt 0 ] && ! mysql -h ${DB_HOST} -P ${DB_PORT} -u ${DB_USERNAME} -p${DB_PASSWORD} -e exit; do
    sleep 15
done
echo
if [ ${maxTries} -le 0 ]; then
    echo >&2 'error: unable to contact Mysql after 10 tries'
    exit 1
fi
php artisan migrate --force
service php7.2-fpm start && nginx -g "daemon off;"
