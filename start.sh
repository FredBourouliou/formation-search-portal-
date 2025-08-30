#!/bin/bash

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
API_PORT=8080
FRONTEND_PORT=5173
PID_FILE=".emfor.pids"

echo -e "${BLUE}╔══════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║       🚀 Emfor POC - Démarrage Automatique       ║${NC}"
echo -e "${BLUE}╚══════════════════════════════════════════════════╝${NC}"
echo ""

# Fonction de nettoyage
cleanup() {
    echo ""
    echo -e "${YELLOW}🛑 Arrêt des services...${NC}"
    
    if [ -f "$PID_FILE" ]; then
        while read -r pid; do
            if kill -0 "$pid" 2>/dev/null; then
                kill "$pid" 2>/dev/null
                echo -e "${GREEN}✓${NC} Processus $pid arrêté"
            fi
        done < "$PID_FILE"
        rm -f "$PID_FILE"
    fi
    
    # Arrêt des processus PHP et Node orphelins sur les ports
    lsof -ti:$API_PORT | xargs -r kill 2>/dev/null
    lsof -ti:$FRONTEND_PORT | xargs -r kill 2>/dev/null
    
    echo -e "${GREEN}✅ Services arrêtés${NC}"
    exit 0
}

# Gestion des signaux
trap cleanup EXIT INT TERM

# Vérification si les services tournent déjà
check_port() {
    lsof -Pi :$1 -sTCP:LISTEN -t >/dev/null
}

if check_port $API_PORT; then
    echo -e "${RED}❌ Le port $API_PORT est déjà utilisé (API)${NC}"
    echo "   Arrêtez d'abord le service existant ou utilisez ./stop.sh"
    exit 1
fi

if check_port $FRONTEND_PORT; then
    echo -e "${RED}❌ Le port $FRONTEND_PORT est déjà utilisé (Frontend)${NC}"
    echo "   Arrêtez d'abord le service existant ou utilisez ./stop.sh"
    exit 1
fi

# Vérification des prérequis
echo -e "${BLUE}📋 Vérification des prérequis...${NC}"

command -v php >/dev/null 2>&1 || { 
    echo -e "${RED}❌ PHP n'est pas installé${NC}" >&2
    echo "   Installation : brew install php (macOS) ou apt install php (Linux)"
    exit 1
}

command -v node >/dev/null 2>&1 || { 
    echo -e "${RED}❌ Node.js n'est pas installé${NC}" >&2
    echo "   Installation : brew install node (macOS) ou apt install nodejs (Linux)"
    exit 1
}

# Détection de Composer
if command -v composer >/dev/null 2>&1; then
    COMPOSER="composer"
elif [ -f "composer.phar" ]; then
    COMPOSER="php composer.phar"
else
    echo -e "${YELLOW}📦 Installation de Composer...${NC}"
    curl -sS https://getcomposer.org/installer | php
    COMPOSER="php composer.phar"
fi

# Versions
PHP_VERSION=$(php -r "echo PHP_VERSION;")
NODE_VERSION=$(node -v)
echo -e "${GREEN}✓${NC} PHP $PHP_VERSION"
echo -e "${GREEN}✓${NC} Node.js $NODE_VERSION"
echo -e "${GREEN}✓${NC} Composer disponible"
echo ""

# Backend API
echo -e "${BLUE}🔧 Configuration du Backend API...${NC}"
cd api || exit 1

# Installation des dépendances si nécessaire
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}📦 Installation des dépendances PHP...${NC}"
    $COMPOSER install --no-interaction --prefer-dist --optimize-autoloader
else
    echo -e "${GREEN}✓${NC} Dépendances PHP déjà installées"
fi

# Base de données
if [ ! -f "var/data.db" ]; then
    echo -e "${YELLOW}💾 Création de la base de données...${NC}"
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
    echo -e "${GREEN}✓${NC} Base de données créée avec fixtures"
else
    echo -e "${GREEN}✓${NC} Base de données existante"
    echo -e "${YELLOW}💡 Pour recharger les fixtures : cd api && php bin/console doctrine:fixtures:load${NC}"
fi

# Cache Symfony
echo -e "${YELLOW}🔄 Nettoyage du cache Symfony...${NC}"
php bin/console cache:clear --no-warmup

# Démarrage de l'API
echo -e "${BLUE}🚀 Démarrage de l'API sur http://localhost:$API_PORT...${NC}"
php -S 0.0.0.0:$API_PORT -t public > ../api.log 2>&1 &
API_PID=$!
echo $API_PID >> "../$PID_FILE"

# Attente du démarrage de l'API
sleep 2
if ! kill -0 $API_PID 2>/dev/null; then
    echo -e "${RED}❌ Échec du démarrage de l'API${NC}"
    cat ../api.log
    exit 1
fi

# Test de l'API
if curl -s http://localhost:$API_PORT/health | grep -q "ok"; then
    echo -e "${GREEN}✓${NC} API opérationnelle"
else
    echo -e "${YELLOW}⚠️  L'API démarre...${NC}"
fi

# Frontend
echo ""
echo -e "${BLUE}🎨 Configuration du Frontend...${NC}"
cd ../frontend || exit 1

# Installation des dépendances si nécessaire
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}📦 Installation des dépendances Node.js...${NC}"
    npm install
else
    echo -e "${GREEN}✓${NC} Dépendances Node.js déjà installées"
fi

# Démarrage du frontend
echo -e "${BLUE}🚀 Démarrage du Frontend sur http://localhost:$FRONTEND_PORT...${NC}"
npm run dev -- --host 0.0.0.0 > ../frontend.log 2>&1 &
FRONTEND_PID=$!
echo $FRONTEND_PID >> "../$PID_FILE"

# Attente du démarrage
sleep 5

if ! kill -0 $FRONTEND_PID 2>/dev/null; then
    echo -e "${RED}❌ Échec du démarrage du Frontend${NC}"
    cat ../frontend.log
    exit 1
fi

echo ""
echo -e "${GREEN}╔══════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║           ✅ Emfor POC est opérationnel !        ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}📍 Accès aux services :${NC}"
echo -e "   ${GREEN}➜${NC} Frontend (React) : ${BLUE}http://localhost:$FRONTEND_PORT${NC}"
echo -e "   ${GREEN}➜${NC} API (Symfony)    : ${BLUE}http://localhost:$API_PORT${NC}"
echo -e "   ${GREEN}➜${NC} Health Check     : ${BLUE}http://localhost:$API_PORT/health${NC}"
echo ""
echo -e "${YELLOW}📝 Commandes utiles :${NC}"
echo -e "   ${GREEN}•${NC} Voir les logs API      : tail -f api.log"
echo -e "   ${GREEN}•${NC} Voir les logs Frontend : tail -f frontend.log"
echo -e "   ${GREEN}•${NC} Arrêter les services   : ./stop.sh ou Ctrl+C"
echo -e "   ${GREEN}•${NC} Recharger les fixtures : cd api && php bin/console doctrine:fixtures:load"
echo ""
echo -e "${YELLOW}⏸  Appuyez sur Ctrl+C pour arrêter tous les services${NC}"
echo ""

# Attente infinie
while true; do
    sleep 1
    
    # Vérification que les processus tournent toujours
    if ! kill -0 $API_PID 2>/dev/null; then
        echo -e "${RED}⚠️  L'API s'est arrêtée de manière inattendue${NC}"
        break
    fi
    
    if ! kill -0 $FRONTEND_PID 2>/dev/null; then
        echo -e "${RED}⚠️  Le Frontend s'est arrêté de manière inattendue${NC}"
        break
    fi
done

cleanup