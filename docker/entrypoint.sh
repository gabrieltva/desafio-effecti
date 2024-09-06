echo "Aguardando o banco de dados estar disponível..."
sleep 10

php artisan migrate:fresh --seed --force
php artisan serve --host=0.0.0.0 --port=80