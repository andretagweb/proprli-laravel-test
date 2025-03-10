FROM php:8.2-fpm

# Instalar dependências do sistema operacional necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    nano \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo_mysql

# Instalar extensão Redis corretamente
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer dentro do container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do Laravel para dentro do container
COPY . .

# Instalar dependências do Laravel dentro do container
RUN composer install --no-dev --prefer-dist

# Definir permissões para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta do PHP-FPM
EXPOSE 9000

# Comando padrão ao iniciar o container
CMD ["php-fpm"]
