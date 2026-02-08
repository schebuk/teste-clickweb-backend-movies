# Versão SIMPLES - sem arquivos .docker/
FROM php:8.2-apache

# Atualizar e instalar dependências básicas
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

# Configurar Apache DIRETAMENTE no Dockerfile
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código
COPY . /var/www/html/

WORKDIR /var/www/html

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
