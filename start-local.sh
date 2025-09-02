#!/bin/bash

echo "🚀 Démarrage d'Emfor POC en mode local..."

# Vérification des prérequis
command -v php >/dev/null 2>&1 || { echo "❌ PHP n'est pas installé" >&2; exit 1; }
command -v node >/dev/null 2>&1 || { echo "❌ Node.js n'est pas installé" >&2; exit 1; }
command -v composer >/dev/null 2>&1 || COMPOSER="php composer.phar"

# Installation Composer si nécessaire
if [ -z "$COMPOSER" ]; then
    COMPOSER="composer"
else
    if [ ! -f "composer.phar" ]; then
        echo "📦 Installation de Composer..."
        curl -sS https://getcomposer.org/installer | php
    fi
fi

# Backend API
echo "📚 Installation du backend..."
cd api
$COMPOSER install --no-interaction

echo "💾 Configuration de la base de données..."
if [ ! -f "var/data.db" ]; then
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
else
    echo "✅ Base de données déjà configurée"
fi

echo "🔥 Démarrage de l'API sur http://localhost:8080..."
php -S 0.0.0.0:8080 -t public &
API_PID=$!

# Frontend
cd ../frontend
echo "⚛️ Installation du frontend..."
npm install

echo "🎨 Démarrage du frontend sur http://localhost:5173..."
npm run dev &
FRONTEND_PID=$!

echo ""
echo "✅ Emfor POC est démarré !"
echo ""
echo "📍 Accès:"
echo "   - Frontend: http://localhost:5173"
echo "   - API: http://localhost:8080"
echo ""
echo "Pour arrêter : Ctrl+C"
echo ""

# Attente et nettoyage
trap "echo '🛑 Arrêt des services...' && kill $API_PID $FRONTEND_PID 2>/dev/null" EXIT
wait