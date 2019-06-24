chmod +x wait-for-it.sh
./wait-for-it.sh db:3306 --timeout=120 --strict -- php artisan migrate
php artisan key:generate
service php7.2-fpm start && nginx -g "daemon off;"
