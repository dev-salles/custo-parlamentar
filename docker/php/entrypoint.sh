#!/bin/sh

# Define que o script deve sair imediatamente se um comando falhar
set -e

echo "Iniciando o script de entrypoint..."

# Aguarda o banco de dados estar disponível usando o script compatível com sh
echo "Aguardando o banco de dados MySQL estar pronto..."
/usr/local/bin/wait-for-db.sh mysql_db 3306 -- echo "MySQL está pronto!"

# Executa as migrações do Laravel
echo "Executando as migrações do Laravel..."
php artisan migrate --force

# Executa composer install se a pasta vendor não existir
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Pasta 'vendor' não encontrada. Executando composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "Pasta 'vendor' já existe. Pulando composer install."
fi

# Executa import:deputados se a tabela estiver vazia
echo "--- Verificação de Deputados ---"
echo "Verificando contagem inicial da tabela 'deputados'..."
DEPUTADOS_COUNT=$(php artisan db:seed --class="CheckDeputadosTableSeeder" --force | tail -n 1)
echo "Contagem inicial de deputados: '$DEPUTADOS_COUNT'"

# Processa o job de importação de deputados imediatamente
if [ "$DEPUTADOS_COUNT" = "0" ]; then
    echo "Tabela de deputados vazia. Despachando job de importação..."
    php artisan import:deputados # Despacha o job
    echo "Job para processar deputados despachado. Processando fila para conclusão..."  
    php artisan queue:work --once --stop-when-empty --timeout=300 --tries=1 --queue=default --verbose
    sleep 5
    echo "Processamento da fila para importação de deputados concluído."

    # Verifica a contagem de deputados novamente após o processamento da fila
    echo "Verificando contagem de deputados APÓS processamento da fila..."
    DEPUTADOS_COUNT_AFTER_QUEUE=$(php artisan db:seed --class="CheckDeputadosTableSeeder" --force | tail -n 1)
    echo "Contagem de deputados após fila: '$DEPUTADOS_COUNT_AFTER_QUEUE'"

    if [ "$DEPUTADOS_COUNT_AFTER_QUEUE" = "0" ]; then
        echo "ERRO CRÍTICO: A importação de deputados via fila falhou ou não populou a tabela."
        echo "Verifique os logs do worker acima para erros do job."
        exit 1 # Sai com erro para indicar falha na importação crítica
    else
        echo "Importação de deputados concluída com sucesso (via fila)."
    fi
else
    echo "Dados de deputados já existem no banco. Pulando importação de deputados."
fi

# Executa import:despesas-deputados se a tabela estiver vazia
echo "--- Verificação de Despesas ---"
echo "Verificando contagem inicial da tabela 'despesas'..."
DESPESAS_COUNT=$(php artisan db:seed --class="CheckDespesasDeputadosTableSeeder" --force 2>/dev/null | tail -n 1)
echo "Contagem inicial de despesas: '$DESPESAS_COUNT'"

# Verifica se a contagem é '0' OU se a string está vazia
if [ "$DESPESAS_COUNT" = "0" ] || [ -z "$DESPESAS_COUNT" ]; then
    echo "Tabela de despesas de deputados vazia ou a contagem retornou vazia. Importando dados de despesas de deputados..."
    php artisan import:despesas-deputados
else
    echo "Dados de despesas de deputados já existem no banco. Pulando importação de despesas de deputados."
fi

# Inicia o Supervisor, que gerenciará o PHP-FPM e o queue:work
echo "Iniciando Supervisor..."
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
