# docker/nginx/Dockerfile
FROM nginx:stable-alpine

# Remove a configuração padrão do Nginx
RUN rm /etc/nginx/conf.d/default.conf

# Copia o seu arquivo de configuração personalizado
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia os arquivos da sua aplicação Laravel para o servidor web do Nginx.
# O Nginx precisa ter acesso aos arquivos estáticos (CSS, JS, imagens) e ao public/index.php.
# Note: Isso irá duplicar seus arquivos Laravel dentro do container Nginx, mas é o padrão.
COPY . /var/www/html

# Define as permissões para a pasta da aplicação.
# O usuário padrão do Nginx (nginx) precisa de permissão de leitura nos arquivos.
RUN chown -R nginx:nginx /var/www/html && \
    chmod -R 777 /var/www/html

# Expõe a porta 80, que é a porta HTTP padrão para o Nginx.
EXPOSE 80

# Comando para iniciar o Nginx e mantê-lo em primeiro plano (necessário para Docker/Render).
CMD ["nginx", "-g", "daemon off;"]