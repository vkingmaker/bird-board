chmod +x wait-for-it.sh
./wait-for-it.sh ${DB_HOST}:${DB_PORT} --timeout=60 --strict -- php artisan migrate --force
# chown -R $USER:www-data storage \
#     && chown -R $USER:www-data bootstrap/cache \
#     && chmod -R 775 storage \
#     && chmod -R 775 bootstrap/cache
php artisan config:cache && php artisan route:cache
service php7.2-fpm start && nginx -g "daemon off;"
