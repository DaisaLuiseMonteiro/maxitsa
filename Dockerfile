# Dockerfile pour Render
FROM php:8.3-fpm

# Variables d'environnement pour Render
ENV DEBIAN_FRONTEND=noninteractive

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libpq-dev \
    libzip-dev \
    zip unzip \
    git curl \
    gettext-base \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copier Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application
COPY . .

# Corriger les chemins relatifs
RUN php fix-paths-for-render.php || echo "Script de correction non trouvé"

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Créer le fichier .env avec les variables correctes
RUN echo "DB_USER=\${DB_USER}" > .env && \
    echo "DB_PASSWORD=\${DB_PASSWORD}" >> .env && \
    echo "APP_URL=\${APP_URL}" >> .env && \
    echo "DSN=\${DSN}" >> .env && \
    echo "TWILIO_SID=\${TWILIO_SID}" >> .env && \
    echo "TWILIO_TOKEN=\${TWILIO_TOKEN}" >> .env && \
    echo "TWILIO_FROM=\${TWILIO_FROM}" >> .env && \
    echo "IMG_DIR=/var/www/html/public/uploads" >> .env

# Copier la configuration nginx pour Render ou utiliser la configuration existante
COPY nginx.render.conf /etc/nginx/sites-available/default || COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Créer les répertoires nécessaires et configurer les permissions
RUN mkdir -p /var/run/php /var/log/supervisor /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 777 /var/www/html/public/uploads

# Exposer le port
EXPOSE 80

# Script de démarrage pour Render
RUN cat > /start.sh << 'EOF'
#!/bin/bash
set -e

# Configuration du port pour nginx - Render utilise PORT
if [ ! -z "$PORT" ]; then
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/sites-available/default
    sed -i "s/listen \${PORT:-80};/listen $PORT;/g" /etc/nginx/sites-available/default
fi

# Exécuter les migrations si nécessaire
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php migrations/Migration.php || echo "Migration failed"
    php seeders/Seeder.php || echo "Seeder failed"
fi

# Démarrer supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF

RUN chmod +x /start.sh

CMD ["/start.sh"]