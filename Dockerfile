FROM gabrieltva/php-fpm-node:latest

COPY . /var/www

# Instala dependecias do PHP composer
RUN composer install

# Instala dependencias do Node e builda aplicação do frontend
RUN npm install
RUN npm run build

# Permissões nos diretorios do Laravel
RUN chown -R www-data:www-data /var/www/storage
RUN chown -R www-data:www-data /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Comandos para gerar Key do Laravel
RUN php artisan key:generate

EXPOSE 80