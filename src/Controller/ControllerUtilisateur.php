<?php
/**
 * Controleur principal pour la gestion des utilisateurs
 * BUT2 - S3 - AquaView Project
 * Gere toutes les operations CRUD et authentification des utilisateurs
 */

namespace App\Controller;

use App\Model\Repository\UtilisateurRepository;
use App\Model\Repository\UserAnalysisRepository;

/**
 * ControllerUtilisateur - Gestion complete du cycle de vie utilisateur
 * 
 * Ce controleur gere :
 * - Authentification (login/logout)
 * - Inscription et validation
 * - Profil utilisateur
 * - CRUD administrateur
 * - Historique des telechargements
 */
class ControllerUtilisateur {
    /** @var UtilisateurRepository Repository pour les operations BDD utilisateurs */
    private UtilisateurRepository $repository;
    /** @var UserAnalysisRepository Repository pour les analyses utilisateur */
    private UserAnalysisRepository $analysisRepository;

    /**
     * Constructeur - Initialise les repositories et lance le routage
     * Le constructeur est auto appele et gere l'action demandee
     */
    public function __construct() {
        $this->repository = new UtilisateurRepository();
        $this->analysisRepository = new UserAnalysisRepository();
        $this->handleAction();
    }

    /**
     * Routeur principal - Dispatch vers la bonne methode selon l'action
     * Utilise le parametre GET 'action' pour determiner la methode a appeler
     * Par defaut : affiche la liste des utilisateurs
     */
    private function handleAction(): void {
        $action = $_GET['action'] ?? 'list';
        
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'doLogin':
                $this->doLogin();
                break;
            case 'register':
                $this->register();
                break;
            case 'doRegister':
                $this->doRegister();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'list':
                $this->list();
                break;
            case 'detail':
                $this->detail();
                break;
            case 'create':
                $this->create();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'profile':
                $this->profile();
                break;
            case 'doUpdateProfile':
                $this->doUpdateProfile();
                break;
            case 'doUpdatePassword':
                $this->doUpdatePassword();
                break;
            case 'doDeleteAccount':
                $this->doDeleteAccount();
                break;
            default:
                $this->list();
        }
    }

    /**
     * Affiche la page de connexion
     * Simple vue du formulaire de login
     */
    private function login(): void {
        require_once __DIR__ . '/../View/utilisateur/login.php';
    }

    /**
     * Traite la soumission du formulaire de connexion
     * Verifie les identifiants et cree la session utilisateur
     * Securite : password_verify() pour comparer les hash
     */
    private function doLogin(): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation basique des champs
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email et mot de passe requis.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        // Recherche de l'utilisateur par email
        $user = $this->repository->findByEmail($email);

        // Verification du mot de passe avec le hash stocke
        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        // Creation de la session utilisateur (sans le mot de passe !)
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom']
        ];

        // Redirection vers l'accueil apres connexion reussie
        header('Location: /');
        exit;
    }

    /**
     * Affiche la page d'inscription
     * Formulaire de creation de compte utilisateur
     */
    private function register(): void {
        require_once __DIR__ . '/../View/utilisateur/register.php';
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur
     * Validation complete des donnees et securite du mot de passe
     */
    private function doRegister(): void {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation de tous les champs obligatoires
        if (empty($nom) || empty($prenom) || empty($email) || empty($numero) || empty($password)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        // Validation du format email avec filter_var (plus securise)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        // Validation complexe du mot de passe :
        // - Au moins 8 caracteres
        // - Au moins 1 majuscule
        // - Au moins 1 chiffre
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $_SESSION['error'] = 'Mot de passe invalide (min 8 car., 1 Maj, 1 Chiffre).';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        // Verification que l'email n'est pas deja utilise
        if ($this->repository->emailExists($email)) {
            $_SESSION['error'] = 'Cet email est deja utilise.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        // Hashage securise du mot de passe (PASSWORD_DEFAULT = bcrypt actuellement)
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Creation de l'utilisateur en base de donnees
        if ($this->repository->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numero' => $numero,
            'mot_de_passe' => $hash
        ])) {
            $_SESSION['success'] = 'Compte cree avec succes !';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $_SESSION['error'] = 'Erreur lors de la creation du compte.';
        header('Location: ?controller=utilisateur&action=register');
        exit;
    }

    /**
     * Deconnexion de l'utilisateur
     * Detruit completement la session et redirige vers l'accueil
     */
    private function logout(): void {
        session_destroy();
        header('Location: /');
        exit;
    }

    /**
     * Affiche la liste de tous les utilisateurs (admin)
     * Recupere tous les utilisateurs depuis la BDD
     */
    private function list(): void {
        $utilisateurs = $this->repository->findAll();
        require_once __DIR__ . '/../View/utilisateur/list.php';
    }

    /**
     * Affiche les details d'un utilisateur specifique
     * @param int $id ID de l'utilisateur passe en GET
     */
    private function detail(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $utilisateur = $this->repository->findById($id);
        
        // Verification que l'utilisateur existe
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouve.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        require_once __DIR__ . '/../View/utilisateur/detail.php';
    }

    /**
     * Creation d'un utilisateur (admin)
     * Gere GET (affichage formulaire) et POST (traitement)
     */
    private function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Hashage du mot de passe avant insertion
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->repository->create([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero'],
                'mot_de_passe' => $hash
            ]);
            $_SESSION['success'] = 'Utilisateur cree avec succes.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        require_once __DIR__ . '/../View/utilisateur/create.php';
    }

    /**
     * Mise a jour d'un utilisateur (admin)
     * GET : affiche le formulaire avec les donnees actuelles
     * POST : traite la mise a jour en BDD
     */
    private function update(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mise a jour sans modifier le mot de passe
            $this->repository->update($id, [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero']
            ]);
            $_SESSION['success'] = 'Utilisateur mis a jour.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        // Recuperation des donnees actuelles pour pre-remplir le formulaire
        $utilisateur = $this->repository->findById($id);
        require_once __DIR__ . '/../View/utilisateur/update.php';
    }

    /**
     * Suppression d'un utilisateur (admin)
     * @param int $id ID de l'utilisateur a supprimer
     */
    private function delete(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $this->repository->delete($id);
        $_SESSION['success'] = 'Utilisateur supprime.';
        header('Location: ?controller=utilisateur&action=list');
        exit;
    }

    /**
     * Affiche le profil personnel de l'utilisateur connecte
     * Montre les infos personnelles, statistiques et historique
     */
    private function profile(): void {
        // Verification que l'utilisateur est connecte
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }
        
        $userId = $_SESSION['user']['id'];
        $utilisateur = $this->repository->findById($userId);
        
        // Recuperation des dernieres analyses de l'utilisateur (limite a 5)
        $recentAnalyses = $this->analysisRepository->findByUserId($userId, 5);
        // Statistiques personnelles (nombre d'analyses, etc.)
        $userStats = $this->analysisRepository->getUserStats($userId);
        
        require_once __DIR__ . '/../View/utilisateur/profile.php';
    }

    /**
     * Traite la mise à jour du profil personnel
     * Permet à l'utilisateur de modifier ses propres informations
     */
    private function doUpdateProfile(): void {
        // Vérification authentification
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $numero = $_POST['numero'] ?? '';

        // Validation des champs
        if (empty($nom) || empty($prenom) || empty($email) || empty($numero)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Validation email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Vérification que l'email n'est pas déjà utilisé par un autre utilisateur
        if ($this->repository->emailExists($email) && $email !== $_SESSION['user']['email']) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Mise à jour en base de données
        if ($this->repository->update($userId, [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numero' => $numero
        ])) {
            // Mise à jour de la session avec les nouvelles données
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['email'] = $email;
            $_SESSION['success'] = 'Profil mis à jour avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de la mise à jour du profil.';
        }

        header('Location: ?controller=utilisateur&action=profile');
        exit;
    }

    /**
     * Traite la mise à jour du mot de passe utilisateur
     * Vérifie l'ancien mot de passe avant d'appliquer le nouveau
     */
    private function doUpdatePassword(): void {
        // Vérification authentification
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $userId = $_SESSION['user']['id'];

        // Validation des champs
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Vérification que les nouveaux mots de passe correspondent
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Les nouveaux mots de passe ne correspondent pas.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Validation du format du nouveau mot de passe
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $newPassword)) {
            $_SESSION['error'] = 'Le nouveau mot de passe doit contenir au moins 8 caractères, 1 majuscule et 1 chiffre.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Vérification que le nouveau mot de passe est différent de l'ancien
        if ($oldPassword === $newPassword) {
            $_SESSION['error'] = 'Le nouveau mot de passe doit être différent de l\'ancien.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Récupération de l'utilisateur pour vérifier l'ancien mot de passe
        $utilisateur = $this->repository->findById($userId);
        
        if (!$utilisateur || !password_verify($oldPassword, $utilisateur['mot_de_passe'])) {
            $_SESSION['error'] = 'L\'ancien mot de passe est incorrect.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Hashage du nouveau mot de passe
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Mise à jour du mot de passe en base de données
        if ($this->repository->updatePassword($userId, $hash)) {
            $_SESSION['success'] = 'Mot de passe mis à jour avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de la mise à jour du mot de passe.';
        }

        header('Location: ?controller=utilisateur&action=profile');
        exit;
    }

    /**
     * Suppression du compte utilisateur (avec confirmation mot de passe)
     * Sécurité renforcée : nécessite le mot de passe pour supprimer le compte
     */
    private function doDeleteAccount(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $password = $_POST['password'] ?? '';
        $userId = $_SESSION['user']['id'];

        // Le mot de passe est obligatoire pour supprimer le compte
        if (empty($password)) {
            $_SESSION['error'] = 'Le mot de passe est requis pour supprimer votre compte.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Vérification du mot de passe avant suppression
        $utilisateur = $this->repository->findById($userId);
        
        if (!$utilisateur || !password_verify($password, $utilisateur['mot_de_passe'])) {
            $_SESSION['error'] = 'Mot de passe incorrect. La suppression du compte a été annulée.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        // Suppression effective du compte
        if ($this->repository->delete($userId)) {
            // Destruction complète de la session après suppression
            session_destroy();
            $_SESSION['success'] = 'Votre compte a été supprimé avec succès.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression du compte.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }
    }

    }
