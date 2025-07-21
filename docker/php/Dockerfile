# docker/php/Dockerfile
FROM php:8.3-fpm-alpine

# Instala as dependências de sistema e extensões PHP necessárias para Laravel
RUN apk add --no-cache \
    curl \
    libzip-dev \
    sqlite-dev \
    mysql-client \
    git \
    supervisor \
    # Dependências de compilação
    autoconf \
    g++ \
    make \
    # Outras dependências comuns
    libxml2-dev \
    icu-dev 

# Instalar a extensão pdo_mysql 
RUN docker-php-ext-install pdo pdo_mysql    


# Instalar o composer no meu container 
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk update && apk add --no-cache curl libzip-dev sqlite-dev g++ make libxml2-dev icu-dev

# Limpa dependências de construção para reduzir o tamanho final da imagem
RUN apk del autoconf g++ make

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Expõe a porta 9000
EXPOSE 9000

# Define o comando padrão para iniciar o PHP-FPM
CMD ["php-fpm"]