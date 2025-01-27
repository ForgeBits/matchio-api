FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zlib1g-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permitir execução do Composer como superusuário
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Criar composer.json global
RUN mkdir -p /root/.composer && echo '{}' > /root/.composer/composer.json

# Definir o diretório de trabalho
WORKDIR /var/www/html

CMD ["php-fpm"]
