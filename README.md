# AquaView – Base Clean

## 🎯 Objectif
Cette branche fournit une base propre pour développer
des fonctionnalités en Vue.js et PHP dans un cadre pédagogique (SAE).

## 🧠 Règles de travail
- Ne jamais développer directement sur cette branche
- Créer une branche par fonctionnalité :
  feature/nom-feature

## 🛠️ Créer une feature – Guide rapide

### 1️⃣ Backend (PHP)
- Créer un fichier dans backend/api
- Se connecter à la base
- Retourner du JSON

### 2️⃣ Frontend (Vue)
- Créer une vue ou un composant
- Appeler l’API avec fetch
- Afficher les données

### 3️⃣ Git
```bash
git checkout base-clean
git pull
git checkout -b feature/ma-feature
