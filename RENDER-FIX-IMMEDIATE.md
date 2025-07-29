# Fix immédiat pour l'erreur "File not found" sur Render

## 🚨 Problème identifié
Vous utilisiez l'ancien Dockerfile qui avait plusieurs problèmes critiques.

## ✅ Solutions appliquées

### 1. Dockerfile corrigé
Le `Dockerfile` principal a été mis à jour avec :
- ✅ Variables d'environnement correctes (`DSN` au lieu de `dsn`)
- ✅ Gestion du port dynamique de Render
- ✅ Script de démarrage `/start.sh` intelligent
- ✅ Correction automatique des chemins relatifs
- ✅ Configuration supervisord correcte

### 2. Variables d'environnement requises sur Render
```bash
DB_USER=maxitsa_user
DB_PASSWORD=[auto-généré par Render]
DSN=pgsql:host=[DATABASE_HOST];port=5432;dbname=maxitsa
APP_URL=https://[votre-app].onrender.com
RUN_MIGRATIONS=true
TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=
```

### 3. Configuration Render
- **Type** : Web Service
- **Environment** : Docker
- **Dockerfile Path** : `./Dockerfile` (maintenant corrigé)
- **Build Command** : (laisser vide)
- **Start Command** : `/start.sh`

## 🔄 Pour redéployer

### Étape 1 : Commit et push
```bash
git add .
git commit -m "Fix Dockerfile for Render deployment"
git push origin main
```

### Étape 2 : Variables d'environnement sur Render
Vérifiez que ces variables sont définies dans votre service Render :
- `DSN` (avec la chaîne de connexion PostgreSQL complète)
- `DB_USER`, `DB_PASSWORD` 
- `RUN_MIGRATIONS=true`

### Étape 3 : Redéploiement automatique
Render va automatiquement redéployer avec le nouveau Dockerfile.

## 🧪 Test en local (optionnel)
```bash
# Tester le nouveau Dockerfile
docker build -t maxitsa-fixed .
docker run -p 8080:80 \
  -e DB_USER=test \
  -e DB_PASSWORD=test \
  -e DSN="pgsql:host=localhost;port=5432;dbname=test" \
  maxitsa-fixed
```

## 📋 Checklist de vérification

- [ ] Variables d'environnement définies sur Render
- [ ] Service PostgreSQL créé et accessible
- [ ] Variable `DSN` avec la bonne chaîne de connexion
- [ ] Code poussé sur Git
- [ ] Déploiement Render en cours

## 🚀 Résultat attendu

Après le redéploiement, l'erreur "File not found" devrait disparaître et vous devriez voir :
1. La page de connexion MAXITSA
2. Possibilité de se connecter avec `sidi@gmail.com` / `Sidi@2024`
3. Accès aux différentes pages de l'application

## 🆘 Si ça ne marche toujours pas

Vérifiez les logs Render :
```bash
render logs [votre-service-name]
```

Vérifiez particulièrement :
1. Le port utilisé par nginx
2. La connexion à la base de données
3. Les permissions des fichiers
