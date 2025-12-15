# 📦 Dépendances du Projet AquaView Frontend

## ✅ État des Dépendances (au 15 décembre 2025)

### Production Dependencies
```json
{
  "vue": "^3.5.25",
  "vue-router": "^4.6.3",
  "cesium": "^1.136.0",
  "chart.js": "^4.5.1",
  "leaflet": "^1.9.4",
  "leaflet-draw": "^1.0.4"
}
```

### Development Dependencies (Essentiels)
```json
{
  "vite": "^7.2.4",
  "@vitejs/plugin-vue": "^6.0.2",
  "tailwindcss": "^4.1.18",
  "@tailwindcss/postcss": "^4.1.0",
  "postcss": "^8.5.6",
  "autoprefixer": "^10.4.23"
}
```

### Development Dependencies (Qualité de Code)
```json
{
  "eslint": "^9.39.1",
  "eslint-plugin-vue": "~10.5.1",
  "@eslint/js": "^9.39.1",
  "@vue/eslint-config-prettier": "^10.2.0",
  "prettier": "3.6.2",
  "globals": "^16.5.0"
}
```

### Development Dependencies (Outils)
```json
{
  "vite-plugin-cesium": "^1.2.23",
  "vite-plugin-vue-devtools": "^8.0.5"
}
```

---

## 🔄 Migration Effectuée

### Tailwind CSS: v3 → v4

#### Avant (v3)
```js
// postcss.config.js
export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}
```

#### Après (v4)
```js
// postcss.config.js
export default {
  plugins: {
    '@tailwindcss/postcss': {},
  },
}
```

#### CSS Import
```css
/* Avant */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Après */
@import "tailwindcss";
```

---

## 📊 Résumé des Packages

| Catégorie | Nombre | Status |
|-----------|--------|--------|
| Dependencies | 6 | ✅ À jour |
| DevDependencies | 16 | ✅ À jour |
| **Total** | **22** | ✅ Audit OK |

### Audit npm
```
audited 323 packages in 5s
found 0 vulnerabilities
```

---

## 🔗 Dépendances Optionnelles (Non Installées)

Ces packages peuvent être utiles pour des fonctionnalités futures:

- **Cesium** ✅ Installé - Visualisation 3D géospatiale
- **Leaflet** ✅ Installé - Cartes interactives
- **Chart.js** ✅ Installé - Graphiques et diagrammes
- **axios** - Client HTTP (si besoin)
- **pinia** - State management (si besoin)
- **vitest** - Testing framework (si besoin)

---

## 🔧 Node.js Requirements

```json
{
  "engines": {
    "node": "^20.19.0 || >=22.12.0"
  }
}
```

**Version actuelle recommandée:** Node 20.x LTS ou 22.x

---

## 📋 Scripts npm Disponibles

```bash
npm run dev      # Démarrer le serveur de développement (Vite)
npm run build    # Build pour la production
npm run preview  # Voir l'aperçu du build
npm run lint     # Linter et fixer le code
npm run format   # Formatter le code avec Prettier
```

---

## 🛡️ Sécurité

- ✅ Aucune vulnérabilité détectée
- ✅ Tous les packages sont à jour
- ✅ npm audit: OK

---

## 💡 Notes de Maintenance

### Mises à Jour Recommandées
- Vérifier régulièrement: `npm outdated`
- Mettre à jour sécurité: `npm audit fix`
- Vérifier les dépendances: `npm ls`

### Installation Propre
```bash
rm -rf node_modules package-lock.json
npm install
```

### Vérifier la Santé du Projet
```bash
npm audit
npm ls --depth=0
npm run lint
```

---

## 📞 Support

En cas de problème avec les dépendances:

1. **Supprimer `node_modules` et `package-lock.json`**
   ```bash
   rm -rf node_modules package-lock.json
   ```

2. **Réinstaller**
   ```bash
   npm install
   ```

3. **Nettoyer le cache Vite**
   ```bash
   rm -rf .vite node_modules/.vite
   ```

4. **Redémarrer le serveur**
   ```bash
   npm run dev
   ```

---

**Dernière mise à jour:** 15 décembre 2025  
**Status:** ✅ Toutes les dépendances optimisées
