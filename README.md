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
* **🌍 Sensibilisation :** Section éducative ("En savoir plus") expliquant les causes et conséquences de la désoxygénation.
* **🔐 Espace Membre :** Système complet d'authentification (Inscription/Connexion) pour les chercheurs ou utilisateurs passionnés.
* **📱 Design Responsive :** Une interface fluide adaptée aux mobiles et desktops (style *Glassmorphism*).

## 🛠 Stack Technique

Ce projet repose sur une architecture **MVC (Modèle-Vue-Contrôleur)** native en PHP, sans framework lourd, garantissant performance et maîtrise du code.

* **Backend :** PHP 8 (POO rigoureuse), MySQL.
* **Frontend :** HTML5, CSS3 (Design moderne type Tailwind/Custom CSS), JavaScript.
* **Structure :** Architecture MVC personnalisée avec Autoloader PSR-4.
* **Outils :** Git, Teams.

## 📂 Architecture du Projet

La structure du code est organisée pour séparer la logique métier de l'affichage :

```text
📁 src/
├── 📂 Config/          # Configuration de la BDD (Conf.php)
├── 📂 Controller/      # Logique de contrôle (Utilisateur, Voiture, etc.)
├── 📂 Lib/             # Utilitaires & Autoloader
├── 📂 Model/           # Accès aux données
│   ├── 📂 DataObject/  # Objets métiers (User, Voiture)
│   └── 📂 Repository/  # Requêtes SQL
└── 📂 View/            # Templates HTML/PHP
    ├── 📂 components/  # Navbar, Footer
    ├── 📂 home/        # Pages principales (Accueil, Analyse)
    └── 📂 utilisateur/ # Pages de gestion de compte
