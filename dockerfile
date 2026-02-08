FROM php:8.2-apache

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd xml \
    && a2enmod rewrite

# Configurar Apache para mostrar erros PHP
RUN echo 'display_errors = On' >> /usr/local/etc/php/conf.d/errors.ini \
    && echo 'display_startup_errors = On' >> /usr/local/etc/php/conf.d/errors.ini \
    && echo 'error_reporting = E_ALL' >> /usr/local/etc/php/conf.d/errors.ini

# Configurar Apache
RUN echo '<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        FallbackResource /index.php\n\
    </Directory>\n\
    ErrorLog /proc/self/fd/2\n\
    CustomLog /proc/self/fd/1 combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Configurar Laravel (FORÇAR .env de produção)
RUN if [ ! -f .env ]; then \
    cp .env.example .env; \
    echo "APP_ENV=production" >> .env; \
    echo "APP_DEBUG=true" >> .env; \
    echo "APP_KEY=" >> .env; \
    fi

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Criar link de storage
RUN php artisan storage:link || true

EXPOSE 80
CMD ["apache2-foreground"]
