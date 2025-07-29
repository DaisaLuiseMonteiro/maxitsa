# Guide de déploiement sur Render

## Fichiers nécessaires pour le déploiement

1. **Dockerfile.render** - Dockerfile optimisé pour Render
2. **nginx.render.conf** - Configuration nginx pour Render
3. **render.yaml** - Configuration automatique du déploiement
4. **fix-paths-for-render.php** - Script de correction des chemins

## Étapes de déploiement

### 1. Préparer le projet

```bash
# Corriger les chemins relatifs
php fix-paths-for-render.php

# Vérifier que tous les fichiers nécessaires sont présents
ls Dockerfile.render nginx.render.conf render.yaml
```

### 2. Configurer les variables d'environnement sur Render

Dans le dashboard Render, configurer :

```
DB_USER=maxitsa_user
DB_PASSWORD=[généré automatiquement]
DSN=pgsql:host=[host_db];port=5432;dbname=maxitsa
APP_URL=https://[votre-app].onrender.com
TWILIO_SID=[optionnel]
TWILIO_TOKEN=[optionnel]
TWILIO_FROM=[optionnel]
RUN_MIGRATIONS=true
```

### 3. Configuration du service

1. **Type de service** : Web Service
2. **Environment** : Docker
3. **Dockerfile Path** : `./Dockerfile.render`
4. **Build Command** : (laisser vide)
5. **Start Command** : `/start.sh`

### 4. Base de données

1. Créer un service PostgreSQL sur Render
2. Récupérer les variables de connexion
3. Configurer la variable DSN avec les bonnes valeurs

## Résolution des problèmes

### Erreur "File not found"

**Cause** : Chemins relatifs incorrects ou configuration nginx

**Solutions** :
1. Vérifier que `fix-paths-for-render.php` a été exécuté
2. Vérifier les logs nginx
3. S'assurer que le port est correctement configuré

### Erreur de connexion à la base de données

**Cause** : Variables d'environnement incorrectes

**Solutions** :
1. Vérifier la variable DSN
2. S'assurer que la base PostgreSQL est accessible
3. Vérifier les credentials

### Erreur de permissions

**Cause** : Permissions de fichiers

**Solutions** :
1. Vérifier que www-data a les bonnes permissions
2. Vérifier que le dossier uploads existe

## Test local du Dockerfile

```bash
# Construire l'image
docker build -f Dockerfile.render -t maxitsa-render .

# Tester localement
docker run -p 8080:80 \
  -e DB_USER=user \
  -e DB_PASSWORD=password \
  -e DSN="pgsql:host=postgres_db;port=5432;dbname=maxitsa" \
  -e APP_URL=http://localhost:8080 \
  -e RUN_MIGRATIONS=false \
  maxitsa-render
```

## Commandes utiles

```bash
# Voir les logs de l'application
render logs [service-name]

# Redéployer
git push origin main

# Exécuter les migrations manuellement
render shell [service-name]
php migrations/Migration.php
```
