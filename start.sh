chmod +x wait-for-it.sh
php artisan config:cache && php artisan route:cache
./wait-for-it.sh ${DB_HOST}:${DB_PORT} --timeout=60 --strict -- php artisan migrate --force
service php7.2-fpm start && nginx -g "daemon off;"
