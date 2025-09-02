# Emfor Frontend

Application React 18 avec Vite pour la recherche de formations.

## Stack technique

- React 18
- TypeScript
- Vite 5
- Tailwind CSS
- Leaflet (via React Leaflet)
- TanStack Query (React Query)

## Développement

```bash
# Installation des dépendances
npm install

# Lancer le serveur de développement
npm run dev

# Build pour production
npm run build

# Preview du build
npm run preview
```

## Configuration

Variables d'environnement (`.env`):

```env
VITE_API_BASE_URL=http://localhost:8080
```

## Fonctionnalités

- **Recherche multicritères** : mot-clé, département, modalité
- **Pagination** : navigation entre les pages de résultats
- **Carte interactive** : visualisation géographique avec Leaflet
- **Synchronisation liste/carte** : interaction bidirectionnelle
- **Debounce** : optimisation des requêtes de recherche (400ms)
- **États UI** : loading, empty, error avec retry
- **Responsive** : adapté mobile/desktop
- **Accessible** : ARIA labels et navigation clavier

## Structure

```
src/
├── api/             # Client API
├── components/      # Composants React
├── hooks/          # Custom hooks
├── types.ts        # Types TypeScript
├── App.tsx         # Composant principal
└── main.tsx        # Point d'entrée
```

## Composants

- `Filters` : Formulaire de filtres
- `ResultsList` : Liste des formations
- `MapView` : Carte Leaflet
- `Pagination` : Navigation pages
- `Loading/EmptyState/ErrorState` : États UI

## API

Le client API utilise Fetch natif avec gestion d'erreurs et typage TypeScript complet.