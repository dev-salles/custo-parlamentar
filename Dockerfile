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

# Limpa o cache do apk imediatamente após a instalação para reduzir o tamanho da imagem
RUN rm -rf /var/cache/apk/*

# Instalar a extensão pdo_mysql 
RUN docker-php-ext-install pdo pdo_mysql    

# Instalar o composer no meu container 
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Este script verifica a conexão com o banco de dados antes de continuar
RUN echo '#!/bin/sh' > /usr/local/bin/wait-for-db.sh && \
    echo 'host="$1"' >> /usr/local/bin/wait-for-db.sh && \
    echo 'port="$2"' >> /usr/local/bin/wait-for-db.sh && \
    echo 'shift 2' >> /usr/local/bin/wait-for-db.sh && \
    echo 'cmd="$@"' >> /usr/local/bin/wait-for-db.sh && \
    echo '' >> /usr/local/bin/wait-for-db.sh && \
    echo 'until nc -z "$host" "$port"; do' >> /usr/local/bin/wait-for-db.sh && \
    echo '  echo "Aguardando o banco de dados em $host:$port..."' >> /usr/local/bin/wait-for-db.sh && \
    echo '  sleep 1' >> /usr/local/bin/wait-for-db.sh && \
    echo 'done' >> /usr/local/bin/wait-for-db.sh && \
    echo 'echo "Banco de dados em $host:$port está pronto!"' >> /usr/local/bin/wait-for-db.sh && \
    echo 'exec $cmd' >> /usr/local/bin/wait-for-db.sh && \
    chmod +x /usr/local/bin/wait-for-db.sh

# Copia o script de entrypoint e o torna executável
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copia a configuração do Supervisor
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Remove as dependências de compilação para reduzir o tamanho final da imagem
RUN apk del autoconf g++ make

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copia todos os arquivos da sua aplicação para o diretório de trabalho do container
COPY . /var/www/html

# Criando pastas storage e bootstrap/cache
RUN mkdir -p /var/www/html/storage /var/www/html/storage/logs /var/www/html/bootstrap/cache 

# Cria o diretório para os logs do Supervisor e o diretório /var/run
RUN mkdir -p /var/log/supervisor /var/run

# Cria o diretório para os logs do Supervisor
RUN mkdir -p /var/log/supervisor

# Define o usuário 'www-data' como proprietário dos diretórios
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/log/supervisor /var/run

# Define permissões de gravação para o grupo 
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/log/supervisor /var/run

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Isso é importante para que os processos PHP não rodem como root
USER www-data

# Expõe a porta 9000
EXPOSE 9000

# Define o script de entrypoint como o ponto de entrada do contêiner
ENTRYPOINT ["/bin/sh", "/usr/local/bin/entrypoint.sh"]
