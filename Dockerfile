FROM gabrieltva/php-fpm-node:latest

VOLUME /var/www

# Continue com os comandos normais
COPY . /var/www
WORKDIR /var/www

# Copia o arquivo de configuração do ambiente
RUN cp .env.example .env

# Instala dependências do PHP e Node.js
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Gera a chave do Laravel
RUN php artisan key:generate

EXPOSE 80