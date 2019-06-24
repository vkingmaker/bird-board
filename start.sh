set -o allexport
source "$(pwd)/.env"
set +o allexport

chmod +x wait-for-it.sh
./wait-for-it.sh ${DB_HOST}:${DB_PORT} --timeout=60 --strict -- php artisan migrate --force
php artisan key:generate
service php7.2-fpm start && nginx -g "daemon off;"
