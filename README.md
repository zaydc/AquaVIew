<div align="center">
  <br />
  <h1 align="center">🌊 AquaView</h1>
  
  <p align="center">
    <strong>Comprendre la désoxygénation des océans</strong>
  </p>

  <p align="center">
    Une plateforme interactive pour surveiller, analyser et sensibiliser<br>au phénomène invisible qui menace l'équilibre de notre planète.
  </p>

  <p align="center">
    <a href="#-fonctionnalités"><strong>Fonctionnalités</strong></a> ·
    <a href="#-stack-technique"><strong>Tech Stack</strong></a> ·
    <a href="#-installation"><strong>Installation</strong></a> ·
    <a href="#-architecture"><strong>Architecture</strong></a>
  </p>
  
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/Architecture-MVC-orange?style=for-the-badge" alt="MVC">
    <img src="https://img.shields.io/badge/Data-Monitoring-blue?style=for-the-badge" alt="Data">
    <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
  </p>
  <br />
</div>

---

**AquaView** est une application web conçue pour visualiser les données relatives à la baisse des niveaux d'oxygène dans les océans. Le projet combine une approche scientifique rigoureuse avec une interface utilisateur moderne et immersive.

## ✨ Fonctionnalités

* **📊 Analyse en Temps Réel :** Tableau de bord interactif affichant les taux d'oxygène (mg/L), la température et d'autres métriques critiques.
* **🗺️ Visualisation Avancée :** Cartes interactives avec marqueurs de qualité, graphiques dynamiques (Chart.js), et tableaux de données détaillés.
* **📈 Analyses Multiples :** Support de 4 métriques océaniques (Oxygène dissous, Température, Salinité, pH) avec filtres temporels personnalisés.
* **🌍 Sensibilisation :** Section éducative ("En savoir plus") expliquant les causes et conséquences de la désoxygénation.
* **🔐 Espace Membre :** Système complet d'authentification (Inscription/Connexion) avec profil utilisateur et historique d'analyses.
* **💾 Export de Données :** Exportation des résultats d'analyse en multiple formats (CSV, JSON, PDF).
* **📱 Design Responsive :** Une interface fluide adaptée aux mobiles et desktops (style *Glassmorphism*).
* **🔄 Gestion d'Erreurs Robuste :** Validation des données et gestion élégante des erreurs pour une expérience utilisateur optimale.

## 🛠 Stack Technique

Ce projet repose sur une architecture **MVC (Modèle-Vue-Contrôleur)** native en PHP, sans framework lourd, garantissant performance et maîtrise du code.

* **Backend :** PHP 8 (POO rigoureuse), MySQL.
* **Frontend :** HTML5, CSS3 (Design moderne type Tailwind/Custom CSS), JavaScript (Chart.js, Leaflet).
* **Structure :** Architecture MVC personnalisée avec Autoloader PSR-4.
* **APIs :** RESTful API pour les analyses et exportations de données.
* **Sécurité :** Validation des entrées, hashage des mots de passe, gestion de sessions sécurisée.
* **Outils :** Git, Teams.

## 📂 Architecture du Projet

La structure du code est organisée pour séparer la logique métier de l'affichage :

```text
📁 src/
├── 📂 Config/          # Configuration de la BDD (Conf.php)
├── 📂 Controller/      # Logique de contrôle (Utilisateur, Export, etc.)
├── 📂 Lib/             # Utilitaires & Autoloader (GeoHelper, MetricHelper, TimeHelper)
├── 📂 Model/           # Accès aux données
│   ├── 📂 DataObject/  # Objets métiers (User, OceanData)
│   └── 📂 Repository/  # Requêtes SQL (UtilisateurRepository, OceanDataRepository, etc.)
└── 📂 View/            # Templates HTML/PHP
    ├── 📂 components/  # Navbar, Footer, éléments réutilisables
    ├── 📂 home/        # Pages principales (Accueil, Analyse, Équipe)
    └── 📂 utilisateur/ # Pages de gestion de compte (Profil, Downloads)

📁 web/
├── 📂 api/            # Endpoints API REST
│   ├── analyse.php      # API d'analyse des données
│   ├── date-range.php  # API des plages de dates
│   ├── export.php      # API d'exportation
│   ├── login.php       # API d'authentification
│   └── register.php   # API d'inscription
└── frontController.php # Point d'entrée principal de l'application

## 🚀 Dernières Améliorations

### Version Actuelle : v2.0

**Corrections et Optimisations :**
- ✅ **Redirections améliorées** : Configuration des fichiers `.htaccess` pour un routage propre
- ✅ **Gestion des erreurs robuste** : Correction des erreurs Chart.js et JavaScript
- ✅ **Validation des données** : Protection contre les valeurs invalides dans les graphiques
- ✅ **Expérience utilisateur** : Messages d'erreur clairs et gestion élégante des cas limites

**Nouvelles Fonctionnalités :**
- 🎯 **Analyse multi-métriques** : Support complet de 4 indicateurs océaniques
- 📊 **Visualisations avancées** : Graphiques dynamiques et cartes interactives
- 💾 **Export multi-formats** : CSV, JSON, PDF pour les analyses
- 👤 **Espace utilisateur** : Profils personnalisés avec historique
- 🔄 **API RESTful** : Endpoints structurés pour les données

---

## 🔧 Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/zaydc/AquaVIew.git
   cd AquaVIew
   ```

2. **Configuration de la base de données**
   - Importer le fichier `aquaview.sql` dans MySQL
   - Configurer les accès dans `src/Config/Conf.php`

3. **Configuration du serveur web**
   - Assurez-vous que le module `mod_rewrite` Apache est activé
   - Pointez le document root vers le dossier du projet

4. **Lancement**
   ```bash
   # Serveur de développement PHP
   php -S localhost:8000 -t web/
   ```

---

**AquaView** - Protégeons nos océans, une donnée à la fois. 🌊🔬
