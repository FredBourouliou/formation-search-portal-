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

echo -e "${YELLOW}🛑 Arrêt des services Emfor POC...${NC}"
echo ""

# Arrêt des processus enregistrés
if [ -f "$PID_FILE" ]; then
    echo -e "${BLUE}📋 Arrêt des processus enregistrés...${NC}"
    while read -r pid; do
        if kill -0 "$pid" 2>/dev/null; then
            kill "$pid" 2>/dev/null
            echo -e "${GREEN}✓${NC} Processus $pid arrêté"
        fi
    done < "$PID_FILE"
    rm -f "$PID_FILE"
fi

# Arrêt des processus sur les ports (au cas où)
echo -e "${BLUE}🔍 Recherche de processus sur les ports...${NC}"

# Port API
if lsof -Pi :$API_PORT -sTCP:LISTEN -t >/dev/null 2>&1; then
    echo -e "${YELLOW}  Arrêt des processus sur le port $API_PORT (API)...${NC}"
    lsof -ti:$API_PORT | xargs kill 2>/dev/null
    echo -e "${GREEN}✓${NC} Port $API_PORT libéré"
fi

# Port Frontend
if lsof -Pi :$FRONTEND_PORT -sTCP:LISTEN -t >/dev/null 2>&1; then
    echo -e "${YELLOW}  Arrêt des processus sur le port $FRONTEND_PORT (Frontend)...${NC}"
    lsof -ti:$FRONTEND_PORT | xargs kill 2>/dev/null
    echo -e "${GREEN}✓${NC} Port $FRONTEND_PORT libéré"
fi

# Nettoyage des fichiers de log
if [ -f "api.log" ] || [ -f "frontend.log" ]; then
    echo ""
    echo -e "${BLUE}🗑  Nettoyage des logs...${NC}"
    rm -f api.log frontend.log
    echo -e "${GREEN}✓${NC} Logs supprimés"
fi

echo ""
echo -e "${GREEN}✅ Tous les services Emfor POC sont arrêtés${NC}"
echo ""