# Utilisation de l'image officielle Node.js
FROM node:16

# Définir le répertoire de travail dans le container
WORKDIR /app

# Copier les fichiers du projet dans le container
COPY . .

# Installer les dépendances
RUN npm install

# Exposer le port sur lequel l'application écoute
EXPOSE 3000

# Commande pour démarrer l'application
CMD ["npm", "start"]
