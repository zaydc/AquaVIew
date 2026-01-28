# AquaVIew - Documentation Complète

## 🌊 Description du Projet

AquaVIew est une application web de monitoring et d'analyse des données océaniques. Elle permet aux utilisateurs de visualiser, analyser et exporter des données environnementales marines avec un système d'authentification complet et des rôles administratifs.

### Fonctionnalités Principales
- **Analyse des données océaniques** par région et période
- **Exportation des données** en différents formats (CSV, JSON, Excel)
- **Gestion des utilisateurs** avec authentification sécurisée
- **Dashboard administratif** pour la gestion des rôles
- **Historique personnel** des analyses et téléchargements

---

## 📁 Architecture du Projet

### Structure des Dossiers

```
AquaVIew/
├── src/                    # Code source principal
│   ├── Config/            # Configuration de la base de données
│   ├── Controller/        # Contrôleurs MVC
│   ├── Lib/               # Bibliothèques et helpers
│   ├── Model/             # Modèles de données
│   └── View/              # Vues PHP
├── web/                   # Point d'entrée web
│   ├── api/              # Endpoints API
│   └── assets/           # Ressources statiques
└── README.md             # Documentation
```

---

## 🔧 Fichiers de Configuration

### `src/Config/Conf.php`
**Rôle** : Configuration centralisée de la base de données MySQL

**Fonctions principales** :
- `getLogin()` : Retourne l'utilisateur MySQL ('root')
- `getHostname()` : Retourne le serveur ('localhost')
- `getDatabase()` : Retourne le nom BDD ('aquaview')
- `getPassword()` : Retourne le mot de passe (vide en local)

**Pattern utilisé** : Singleton pour éviter les connexions multiples

---

## 🎮 Contrôleurs Principaux

### `web/frontController.php`
**Rôle** : Point d'entrée unique de l'application (Front Controller Pattern)

**Fonctionnalités** :
- **Routage principal** : Dispatch vers les bons contrôleurs
- **Autoloading PSR-4** : Chargement automatique des classes
- **Gestion des sessions** : Démarrage automatique des sessions PHP
- **Routes par défaut** : home, login, register, analyse, equipe, logout

**Routes principales** :
```php
?controller=utilisateur  → ControllerUtilisateur
?controller=admin        → ControllerAdmin
?action=analyse          → Page d'analyse avec données dynamiques
?action=home            → Page d'accueil
```

### `src/Controller/ControllerUtilisateur.php`
**Rôle** : Gestion complète du cycle de vie utilisateur

**Actions principales** :

#### Authentification
- `login()` / `doLogin()` : Connexion avec vérification `password_verify()`
- `register()` / `doRegister()` : Inscription avec validation complexe
- `logout()` : Déconnexion complète

#### Gestion du Profil
- `profile()` : Affiche le profil personnel avec statistiques
- `doUpdateProfile()` : Mise à jour des informations personnelles
- `doUpdatePassword()` : Changement de mot de passe sécurisé
- `doDeleteAccount()` : Suppression du compte avec confirmation

#### Administration CRUD
- `create()` : Création utilisateur (admin)
- `update()` : Mise à jour utilisateur (admin)
- `delete()` : Suppression utilisateur (admin)
- `detail()` : Affichage détaillé utilisateur

**Sécurités implémentées** :
- Validation email avec `filter_var()`
- Regex mot de passe : 8+ caractères, 1 majuscule, 1 chiffre
- Hashage avec `password_hash()` et `PASSWORD_DEFAULT`
- Vérification unicité email
- Protection contre l'auto-modification

### `src/Controller/ControllerAdmin.php`
**Rôle** : Administration avancée avec hiérarchie des rôles

**Actions principales** :

#### Dashboard
- `dashboard()` : Statistiques par rôle, utilisateurs récents
- `users()` : Liste complète avec tri hiérarchique

#### Gestion des Rôles
- `toggleRole()` : Bascule user ↔ admin (règles strictes)
- `deleteUser()` : Suppression avec vérifications hiérarchiques
- `viewUserProfile()` : Profil utilisateur vu par admin

**Hiérarchie des rôles** :
- `ROLE_SUPER_ADMIN` : Peut promouvoir en admin
- `ROLE_ADMIN` : Gestion utilisateurs standards
- `ROLE_USER` : Accès utilisateur standard

**Sécurités** :
- `requireAdmin()` : Vérification admin obligatoire
- `canActOnTarget()` : Vérification permissions hiérarchiques
- Protection super_admin contre modification

---

## 📊 Modèles de Données

### `src/Model/Repository/AbstractRepository.php`
**Rôle** : Classe de base pour tous les repositories

**Fonctions principales** :
- `__construct()` : Connexion PDO automatique
- `executeQuery()` : Exécution avec gestion d'erreurs
- `create()` / `update()` / `delete()` : CRUD générique
- `findById()` : Recherche par ID
- `findAll()` : Liste complète

### `src/Model/Repository/UtilisateurRepository.php`
**Rôle** : Gestion des données utilisateurs en BDD

**Fonctions spécialisées** :
- `findByEmail()` : Recherche par email (connexion)
- `emailExists()` : Vérification unicité
- `updatePassword()` : Mise à jour mot de passe
- `updateRole()` : Modification rôle (admin)
- `countByRole()` : Statistiques par rôle
- `findAllWithHierarchy()` : Liste avec tri hiérarchique
- `canModifyUser()` : Vérification permissions

### `src/Model/Repository/OceanDataRepository.php`
**Rôle** : Accès aux données océaniques

**Fonctions principales** :
- `getDataByRegion()` : Données par région géographique
- `getDataByDateRange()` : Données par période temporelle
- `getAvailableRegions()` : Liste des régions disponibles
- `getAvailableMetrics()` : Métriques disponibles
- `exportData()` : Export multi-formats

### `src/Model/DataObject/Utilisateur.php`
**Rôle** : Objet métier Utilisateur

**Propriétés** :
- `id`, `nom`, `prenom`, `email`, `numero`
- `mot_de_passe` (hashé), `role`, `date_creation`
- `derniere_connexion`

---

## 🔧 Bibliothèques et Helpers

### `src/Lib/Psr4AutoloaderClass.php`
**Rôle** : Autoloading PSR-4 personnalisé

**Fonctionnalités** :
- `register()` : Enregistrement autoloader
- `addNamespace()` : Mapping namespace → dossier
- Chargement automatique des classes selon PSR-4

### `src/Lib/GeoHelper.php`
**Rôle** : Gestion des données géographiques

**Fonctions** :
- `getRegions()` : Liste des régions océaniques
- `getRegionInfo()` : Informations région spécifique
- `validateRegion()` : Validation nom région

### `src/Lib/TimeHelper.php`
**Rôle** : Gestion des périodes temporelles

**Fonctions** :
- `getAvailablePeriods()` : Périodes prédéfinies
- `formatPeriod()` : Formatage affichage
- `validateDateRange()` : Validation plage dates

### `src/Lib/MetricHelper.php`
**Rôle** : Gestion des métriques océaniques

**Fonctions** :
- `getAvailableMetrics()` : Métriques disponibles
- `getMetricInfo()` : Détails métrique
- `formatMetricValue()` : Formatage valeurs

### `src/Lib/auth_helpers.php`
**Rôle** : Fonctions d'aide à l'authentification

**Fonctions** :
- `isConnected()` : Vérification connexion utilisateur
- `requireAdmin()` : Redirection si non-admin
- `updateUserSession()` : Mise à jour session utilisateur
- `sanitizeInput()` : Nettoyage entrées utilisateur

### `src/Lib/RoleHierarchy.php`
**Rôle** : Gestion hiérarchie des rôles

**Constantes** :
- `ROLE_SUPER_ADMIN = 'super_admin'`
- `ROLE_ADMIN = 'admin'`
- `ROLE_USER = 'user'`

**Fonctions** :
- `canModify()` : Vérification permissions modification
- `canPromoteTo()` : Vérification promotion rôle
- `canSelfModify()` : Auto-modification autorisée

---

## 🌐 API Endpoints

### `web/api/login.php`
**Méthode** : POST
**Rôle** : Authentification AJAX

**Paramètres** :
- `email` : Email utilisateur
- `password` : Mot de passe en clair

**Réponse** : JSON avec succès/erreur et données session

### `web/api/register.php`
**Méthode** : POST
**Rôle** : Inscription AJAX

**Paramètres** :
- `nom`, `prenom`, `email`, `numero`, `password`

**Validation** : Côté serveur avec regex mot de passe

### `web/api/analyse.php`
**Méthode** : GET/POST
**Rôle** : Récupération données océaniques

**Paramètres GET** :
- `region` : Région géographique
- `start_date` / `end_date` : Période
- `metrics[]` : Métriques demandées

**Réponse** : JSON avec données formatées

### `web/api/export.php`
**Méthode** : POST
**Rôle** : Exportation données

**Paramètres** :
- `format` : 'csv', 'json', 'excel'
- `data` : Données à exporter
- `filename` : Nom fichier personnalisé

**Réponse** : Fichier téléchargeable ou erreur

### `web/api/date-range.php`
**Méthode** : GET
**Rôle** : Périodes disponibles dynamiques

**Réponse** : JSON avec périodes valides pour région

### `web/api/save-analysis.php`
**Méthode** : POST
**Rôle** : Sauvegarde analyse utilisateur

**Paramètres** :
- `user_id` : ID utilisateur
- `analysis_data` : Données analyse
- `parameters` : Paramètres utilisés

### `web/api/weather-analysis.php`
**Méthode** : GET
**Rôle** : Analyse météo océanique

**Paramètres** :
- `region` : Région concernée
- `period` : Période analyse

---

## 🎨 Vues et Templates

### Vues Principales

#### `src/View/home/home.php`
**Rôle** : Page d'accueil principale
**Contenu** : Présentation projet, navigation principale

#### `src/View/home/analyse.php`
**Rôle** : Interface d'analyse des données
**Variables** :
- `$regions` : Liste régions (GeoHelper)
- `$periods` : Périodes (TimeHelper)
- `$metrics` : Métriques (MetricHelper)

**Fonctionnalités** :
- Sélecteurs région/période/métriques
- Graphiques dynamiques
- Boutons export

#### `src/View/home/login.php` & `register.php`
**Rôle** : Formulaires d'authentification
**Validation** : HTML5 + JavaScript + PHP

### Vues Utilisateur

#### `src/View/utilisateur/profile.php`
**Rôle** : Profil personnel utilisateur
**Variables** :
- `$utilisateur` : Infos utilisateur
- `$recentAnalyses` : Dernières analyses
- `$userStats` : Statistiques personnelles

**Fonctionnalités** :
- Modification profil
- Changement mot de passe
- Suppression compte
- Historique analyses

#### `src/View/utilisateur/detail.php`
**Rôle** : Détails utilisateur (vue admin)
**Affichage** : Informations complètes utilisateur

### Vues Administration

#### `src/View/admin/dashboard.php`
**Rôle** : Tableau de bord admin
**Variables** :
- `$stats` : Statistiques globales
- `$isSuperAdmin` : Permissions étendues

#### `src/View/admin/users.php`
**Rôle** : Gestion utilisateurs
**Fonctionnalités** :
- Liste avec tri hiérarchique
- Actions modification rôle
- Suppression avec confirmations

### Composants Réutilisables

#### `src/View/components/header.php`
**Rôle** : En-tête HTML commun
**Contenu** : Meta, CSS, titre

#### `src/View/components/navbar.php`
**Rôle** : Navigation principale
**Logique** : Affichage selon rôle utilisateur

#### `src/View/components/footer.php`
**Rôle** : Pied de page commun
**Contenu** : Copyright, liens utiles

#### `src/View/components/export-modal.php`
**Rôle** : Modale d'exportation
**Fonctionnalités** : Choix format, nom fichier

---

## 🔄 Workflow AJAX

### Flux d'Authentification
1. **Formulaire login** → `api/login.php` (POST)
2. **Vérification BDD** → `password_verify()`
3. **Session créée** → `updateUserSession()`
4. **Redirection** → Page d'accueil ou erreur

### Flux d'Analyse
1. **Sélection paramètres** → Formulaire
2. **Requête AJAX** → `api/analyse.php`
3. **Récupération données** → `OceanDataRepository`
4. **Affichage graphiques** → JavaScript

### Flux d'Export
1. **Clic export** → Modale choix format
2. **Requête AJAX** → `api/export.php`
3. **Génération fichier** → CSV/JSON/Excel
4. **Téléchargement** → Navigateur

---

## 🔒 Sécurité

### Mesures Implémentées

#### Authentification
- **Hashage mot de passe** : `password_hash()` avec bcrypt
- **Validation complexe** : Regex 8+ caractères, majuscule, chiffre
- **Protection session** : `session_start()` sécurisé
- **Timeout session** : Configuration PHP.ini

#### Validation Entrées
- **Email** : `filter_var(FILTER_VALIDATE_EMAIL)`
- **Nettoyage** : `sanitizeInput()` personnalisé
- **SQL Injection** : Requêtes préparées PDO
- **XSS** : `htmlspecialchars()` affichage

#### Contrôle Accès
- **Rôles hiérarchiques** : `RoleHierarchy` strict
- **Vérification admin** : `requireAdmin()` systématique
- **Auto-modification** : Contrôles permissions
- **CSRF** : Tokens de session (à implémenter)

#### Gestion Erreurs
- **Try-catch** : Capture exceptions globales
- **Logging** : `error_log()` PHP
- **Messages utilisateur** : Sans informations techniques

---

## 📊 Base de Données

### Tables Principales

#### `utilisateurs`
```sql
- id (PK, AUTO_INCREMENT)
- nom, prenom, email, numero
- mot_de_passe (VARCHAR 255, hashé)
- role (ENUM: 'user', 'admin', 'super_admin')
- date_creation (DATETIME)
- derniere_connexion (DATETIME)
```

#### `analyses_utilisateurs`
```sql
- id (PK, AUTO_INCREMENT)
- user_id (FK utilisateurs)
- region_analysee (VARCHAR)
- periode_debut, periode_fin (DATE)
- metriques_utilisees (JSON)
- date_analyse (DATETIME)
- parametres_export (JSON)
```

#### `donnees_oceaniques`
```sql
- id (PK, AUTO_INCREMENT)
- region (VARCHAR)
- date_mesure (DATE)
- temperature, salinite, ph, oxygene (DECIMAL)
- profondeur (INT)
- coordonnees_lat, coordonnees_lon (DECIMAL)
```

---

## 🚀 Installation et Déploiement

### Prérequis
- **PHP 8.0+** avec extensions PDO, MySQL
- **MySQL 8.0+** ou MariaDB 10.5+
- **Apache 2.4+** avec mod_rewrite
- **Composer** pour dépendances (si applicable)

### Configuration
1. **Base de données** : Importer `aquaview.sql`
2. **Configuration** : Adapter `src/Config/Conf.php`
3. **Permissions** : Dossiers `web/assets/` en écriture
4. **VirtualHost** : Pointer vers `/web/`

### Variables d'Environnement
```php
// src/Config/Conf.php
'hostname' => 'localhost',
'database' => 'aquaview',
'login' => 'root',
'password' => ''
```

---

## 🔄 Maintenance et Évolutions

### Tâches Régulières
- **Sauvegardes BDD** : Quotidiennes
- **Logs monitoring** : Erreurs et tentatives intrusion
- **Mises à jour** : Sécurité et dépendances
- **Performance** : Optimisation requêtes

### Évolutions Possibles
- **API REST complète** : Endpoint CRUD
- **Dashboard temps réel** : WebSocket
- **Export avancé** : PDF, rapports personnalisés
- **Notifications** : Email, SMS
- **Multi-langues** : i18n

---

## 📞 Support et Contact

### Documentation Complémentaire
- **API Documentation** : `/api/docs` (à implémenter)
- **Base de connaissances** : Wiki interne
- **Tickets support** : Système de suivi

### Équipe Développement
- **Backend** : Architecture MVC, PHP 8
- **Frontend** : JavaScript vanilla, CSS moderne
- **DevOps** : Docker, CI/CD (à venir)

---

*Ce document couvre l'ensemble de l'architecture et fonctionnalités d'AquaVIew. Pour toute question technique, contacter l'équipe de développement.*
