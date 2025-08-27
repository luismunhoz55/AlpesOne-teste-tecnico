#!/bin/bash

SSH_USER="ubuntu"

EC2_HOST="seu_ip_ou_dominio.com"

# Caminho completo do projeto na sua instância
PROJECT_DIR="/var/www/AlpesOne-teste-tecnico"

SSH_KEY_PATH="/caminho/da/sua/chave.pem"

BRANCH="main"

echo "========================================"
echo "Iniciando o Deploy"
echo "========================================"

ssh -i "$SSH_KEY_PATH" "$SSH_USER@$EC2_HOST" -t "
    cd $PROJECT_DIR

    git fetch origin
    git reset --hard origin/$BRANCH

    composer install --no-dev --optimize-autoloader

    php artisan cache:clear

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    php artisan migrate --force

    sudo systemctl restart php8.3-fpm

    echo 'Deploy concluído!'
"
echo "========================================"
echo "Script de Deploy Finalizado"
echo "========================================"
