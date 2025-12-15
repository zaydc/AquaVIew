# 🎨 Guide Rapide - Frontend AquaView

## 🚀 Démarrage Rapide

### 1️⃣ Installation
```bash
cd frontend
npm install
```

### 2️⃣ Lancer le serveur de développement
```bash
npm run dev
```

Le site sera disponible sur: **http://localhost:5173/**

### 3️⃣ Build pour la production
```bash
npm run build
```

---

## 📁 Structure du Projet

```
frontend/
├── src/
│   ├── pages/
│   │   └── HomePage.vue       (✨ Page d'accueil principale)
│   ├── components/
│   │   └── icons/             (6 icônes SVG réutilisables)
│   ├── router/
│   │   └── index.js           (Configuration des routes)
│   ├── assets/
│   │   ├── main.css           (Styles Tailwind v4)
│   │   └── logo.svg           (Logo du projet)
│   ├── App.vue                (Composant racine)
│   └── main.js                (Point d'entrée)
├── public/
│   └── favicon.ico
├── index.html                 (Template HTML)
├── vite.config.js             (Config Vite)
├── tailwind.config.js         (Config Tailwind CSS)
├── postcss.config.js          (Config PostCSS)
└── package.json
```

---

## ✨ Fichiers Clés

### `src/pages/HomePage.vue`
La page d'accueil complète avec:
- ✅ Fond d'image animé (Unsplash)
- ✅ Overlay dégradé
- ✅ 6 particules flottantes
- ✅ Navbar avec logo et menu
- ✅ Titre avec gradient texte
- ✅ Boutons d'appel à l'action
- ✅ Animations coordonnées

### `src/router/index.js`
Configuration du routeur:
```javascript
{
  path: "/",
  component: HomePage,
  name: "home"
}
```

Pour ajouter une nouvelle page:
1. Créer `src/pages/NewPage.vue`
2. Ajouter la route dans `src/router/index.js`

---

## 🎨 Personnalisation

### Changer les Couleurs
Modifier `tailwind.config.js`:
```javascript
theme: {
  colors: {
    // Ajouter/modifier les couleurs ici
  }
}
```

### Ajouter des Fonts
Dans `src/assets/main.css`:
```css
@import url('https://fonts.googleapis.com/css2?family=...');
```

### Créer un Nouveau Composant
```vue
<!-- src/components/MyComponent.vue -->
<script setup>
// Logique du composant
</script>

<template>
  <div>
    <!-- Template -->
  </div>
</template>

<style scoped>
/* Styles locaux */
</style>
```

---

## 📱 Responsive Design

Le projet utilise Tailwind CSS avec breakpoints:
- **mobile**: par défaut
- **sm**: >= 640px
- **md**: >= 768px (utilisé pour la navbar)
- **lg**: >= 1024px
- **xl**: >= 1280px

Exemple:
```html
<div class="text-base md:text-lg lg:text-xl">
  Texte responsive
</div>
```

---

## 🔧 Scripts npm

```bash
npm run dev       # Serveur de développement (HMR activé)
npm run build     # Build optimisé pour la production
npm run preview   # Préview du build
npm run lint      # Vérifier le code (ESLint)
npm run format    # Formater le code (Prettier)
```

---

## 🌐 Variables d'Environnement

Pour ajouter des variables d'environnement:

1. Créer un fichier `.env.local`
2. Ajouter vos variables (préfixe `VITE_`):
```
VITE_API_URL=http://aquaview/api
VITE_APP_TITLE=AquaView
```

3. Utiliser dans le code:
```javascript
console.log(import.meta.env.VITE_API_URL)
```

---

## 🚀 Déploiement

### Build pour Production
```bash
npm run build
```

Cela crée un dossier `dist/` prêt à être déployé.

### Options de Déploiement
- Vercel
- Netlify
- GitHub Pages
- Votre serveur

---

## 🐛 Debugging

### Vue DevTools
Installer l'extension [Vue.js DevTools](https://devtools.vuejs.org/)

### ESLint
Pour linter:
```bash
npm run lint
```

### Network Tab
Ouvrir la console du navigateur (F12) et vérifier l'onglet "Network"

---

## 📚 Ressources

- [Vue 3 Documentation](https://vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Vite Documentation](https://vite.dev/)
- [Vue Router](https://router.vuejs.org/)

---

## ✅ Checklist pour Nouvelle Feature

- [ ] Créer une branche `feature/nom-feature`
- [ ] Créer la page dans `src/pages/`
- [ ] Ajouter la route dans `src/router/index.js`
- [ ] Ajouter un lien dans la navbar
- [ ] Tester localement: `npm run dev`
- [ ] Vérifier le responsive
- [ ] Linter: `npm run lint`
- [ ] Commit et push
- [ ] Créer une Pull Request

---

## 💡 Tips & Tricks

### HMR (Hot Module Replacement)
Le code se met à jour automatiquement lors de modifications!

### Style Scoped
```vue
<style scoped>
/* Ces styles ne s'appliquent qu'à ce composant */
</style>
```

### Computed Properties
```javascript
const greeting = computed(() => {
  return `Bonjour ${name.value}`
})
```

### Watchers
```javascript
watch(variable, (newVal, oldVal) => {
  console.log(`${oldVal} → ${newVal}`)
})
```

---

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/amazing`)
3. Commit les changements (`git commit -m 'Add amazing feature'`)
4. Push vers la branche (`git push origin feature/amazing`)
5. Ouvrir une Pull Request

---

**Version:** 1.0.0  
**Dernière mise à jour:** 15 décembre 2025  
**Status:** ✅ Prêt à l'emploi
