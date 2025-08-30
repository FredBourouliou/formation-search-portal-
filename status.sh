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
echo -e "${BLUE}║          📊 Status des services Emfor POC        ║${NC}"
echo -e "${BLUE}╚══════════════════════════════════════════════════╝${NC}"
echo ""

# Fonction pour vérifier un port
check_service() {
    local port=$1
    local name=$2
    local url=$3
    
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null 2>&1; then
        echo -e "${GREEN}✅ $name${NC} : En cours d'exécution sur le port $port"
        if [ -n "$url" ]; then
            echo -e "   ${BLUE}➜${NC} Accès : ${BLUE}$url${NC}"
        fi
        
        # Test de santé pour l'API
        if [ "$port" = "$API_PORT" ]; then
            if curl -s http://localhost:$API_PORT/health | grep -q "ok" 2>/dev/null; then
                echo -e "   ${GREEN}✓${NC} Health check : OK"
            else
                echo -e "   ${YELLOW}⚠${NC} Health check : Non disponible"
            fi
        fi
    else
        echo -e "${RED}❌ $name${NC} : Arrêté (port $port libre)"
    fi
}

# Vérification des services
check_service $API_PORT "API Symfony" "http://localhost:$API_PORT"
echo ""
check_service $FRONTEND_PORT "Frontend React" "http://localhost:$FRONTEND_PORT"

# Vérification de la base de données
echo ""
echo -e "${BLUE}💾 Base de données :${NC}"
if [ -f "api/var/data.db" ]; then
    SIZE=$(du -h api/var/data.db | cut -f1)
    echo -e "   ${GREEN}✓${NC} SQLite : api/var/data.db ($SIZE)"
    
    # Compter les formations
    if command -v sqlite3 >/dev/null 2>&1; then
        COUNT=$(sqlite3 api/var/data.db "SELECT COUNT(*) FROM formations;" 2>/dev/null || echo "?")
        echo -e "   ${GREEN}✓${NC} Formations en base : $COUNT"
    fi
else
    echo -e "   ${RED}✗${NC} Base de données non trouvée"
fi

# Vérification des processus enregistrés
echo ""
if [ -f "$PID_FILE" ]; then
    echo -e "${BLUE}📋 Processus enregistrés :${NC}"
    while read -r pid; do
        if kill -0 "$pid" 2>/dev/null; then
            PROCESS=$(ps -p $pid -o comm= 2>/dev/null || echo "inconnu")
            echo -e "   ${GREEN}✓${NC} PID $pid : $PROCESS"
        else
            echo -e "   ${RED}✗${NC} PID $pid : Processus terminé"
        fi
    done < "$PID_FILE"
else
    echo -e "${YELLOW}ℹ${NC} Aucun fichier PID trouvé (.emfor.pids)"
fi

# Logs disponibles
echo ""
echo -e "${BLUE}📄 Logs disponibles :${NC}"
if [ -f "api.log" ]; then
    echo -e "   ${GREEN}✓${NC} api.log ($(wc -l < api.log) lignes)"
else
    echo -e "   ${YELLOW}○${NC} api.log non disponible"
fi

if [ -f "frontend.log" ]; then
    echo -e "   ${GREEN}✓${NC} frontend.log ($(wc -l < frontend.log) lignes)"
else
    echo -e "   ${YELLOW}○${NC} frontend.log non disponible"
fi

echo ""
echo -e "${BLUE}💡 Commandes disponibles :${NC}"
echo -e "   ${GREEN}./start.sh${NC}   - Démarrer tous les services"
echo -e "   ${GREEN}./stop.sh${NC}    - Arrêter tous les services"
echo -e "   ${GREEN}./status.sh${NC}  - Voir ce status"
echo ""