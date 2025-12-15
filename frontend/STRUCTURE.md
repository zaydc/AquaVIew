# Structure du Frontend - AquaView

## 📁 Organisation des Dossiers

```
src/
├── pages/              # Pages principales de l'application
│   └── HomePage.vue    # Page d'accueil
├── components/         # Composants Vue réutilisables
│   └── common/         # Composants partagés
│       └── Navbar.vue  # Barre de navigation
│   └── icons/          # Icônes (à garder pour plus tard)
├── router/             # Configuration du routeur
│   └── index.js        # Routes de l'application
├── layouts/            # Layouts réutilisables (pour plus tard)
├── assets/             # Ressources statiques (CSS, images)
├── App.vue             # Composant racine
└── main.js             # Point d'entrée
```

## 🎯 Conventions

### Pages (`src/pages/`)
- **Utilisation** : Components principaux correspondant à des routes
- **Nommage** : `HomePage.vue`, `DashboardPage.vue`, `SettingsPage.vue`
- **Contenu** : Logique métier, état complexe
- **Exemple** : `HomePage.vue` - Page d'accueil avec hero section

### Composants (`src/components/`)

#### `components/common/`
- **Utilisation** : Composants réutilisables à travers l'app
- **Exemples** :
  - `Navbar.vue` - Barre de navigation
  - `Footer.vue` - Pied de page
  - `Button.vue` - Bouton réutilisable
  - `Modal.vue` - Modal générique

#### `components/icons/`
- **Utilisation** : Petites icônes SVG
- **Exemples** : `IconCommunity.vue`, `IconDocumentation.vue`

## 🚀 Ajouter une Nouvelle Page

1. **Créer le fichier page** : `src/pages/NewPage.vue`
2. **Ajouter la route** dans `src/router/index.js` :
   ```javascript
   {
     path: "/nouvelle-page",
     component: NewPage,
     name: "newPage"
   }
   ```
3. **Lier depuis la Navbar** : Ajouter un lien dans `src/components/common/Navbar.vue`

## 🎨 Styles

- **Framework** : Tailwind CSS
- **Localisation** : Classes Tailwind inline + `<style scoped>`
- **Variables globales** : `src/assets/main.css`

## 📦 Dépendances Principales

- **Vue 3** - Framework front-end
- **Vue Router 4** - Routeur
- **Tailwind CSS** - Framework CSS (via Vite)
- **Leaflet** - Cartes interactives
- **Chart.js** - Graphiques
- **Cesium** - Visualisation 3D géospatiale

## 💡 Bonnes Pratiques

✅ **À Faire**
- Garder les pages simples et modulaires
- Créer des composants réutilisables dans `components/common/`
- Utiliser les `<script setup>` pour la syntaxe moderne
- Passer les props pour la réutilisabilité

❌ **À Éviter**
- Duplicater du code entre pages
- Mettre de la logique métier complexe directement dans les composants
- Styles inline au lieu de classes Tailwind
