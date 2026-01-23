<?php
/**
 * Controleur pour l'administration
 * BUT2 - S3 - AquaView Project
 * Gere l'administration des utilisateurs et des permissions
 */

namespace App\Controller;

use App\Model\Repository\UtilisateurRepository;
use App\Model\Repository\UserAnalysisRepository;

require_once __DIR__ . '/../Lib/auth_helpers.php';
require_once __DIR__ . '/../Lib/RoleHierarchy.php';

/**
 * ControllerAdmin - Gestion administrative
 * 
 * Ce controleur gere :
 * - Dashboard administrateur
 * - Gestion des utilisateurs (CRUD)
 * - Modification des rôles utilisateurs
 * - Statistiques d'utilisation
 */
class ControllerAdmin {
    /** @var UtilisateurRepository Repository pour les operations BDD utilisateurs */
    private UtilisateurRepository $userRepository;

    /**
     * Constructeur - Initialise le repository et lance le routage
     * Verifie que l'utilisateur est admin avant toute action
     */
    public function __construct() {
        // Vérification obligatoire : seul un admin peut accéder à ce contrôleur
        requireAdmin();
        
        $this->userRepository = new UtilisateurRepository();
        $this->handleAction();
    }
    
    /**
     * Vérifie si l'utilisateur courant est super_admin
     * @return bool True si super_admin
     */
    private function isSuperAdmin(): bool {
        return $_SESSION['user']['role'] === \RoleHierarchy::ROLE_SUPER_ADMIN;
    }
    
    /**
     * Vérifie si l'utilisateur peut agir sur une cible
     * @param int $targetId ID de la cible
     * @return bool True si l'action est autorisée
     */
    private function canActOnTarget(int $targetId): bool {
        $currentUserId = $_SESSION['user']['id'];
        $currentUserRole = $_SESSION['user']['role'];
        
        // Vérifier l'auto-modification
        if (!\RoleHierarchy::canSelfModify($currentUserRole, $currentUserId, $targetId)) {
            return false;
        }
        
        // Vérifier la hiérarchie
        return $this->userRepository->canModifyUser($currentUserId, $targetId);
    }

    /**
     * Routeur principal - Dispatch vers la bonne methode selon l'action
     * Par defaut : affiche le dashboard admin
     */
    private function handleAction(): void {
        $action = $_GET['action'] ?? 'dashboard';
        
        switch ($action) {
            case 'dashboard':
                $this->dashboard();
                break;
            case 'users':
                $this->users();
                break;
            case 'toggleRole':
                $this->toggleRole();
                break;
            case 'deleteUser':
                $this->deleteUser();
                break;
            case 'viewUserProfile':
                $this->viewUserProfile();
                break;
            default:
                $this->dashboard();
        }
    }

    /**
     * Affiche le dashboard administrateur
     * Montre les statistiques et les actions rapides
     */
    private function dashboard(): void {
        // Statistiques générales avec la nouvelle hiérarchie
        $statsByRole = $this->userRepository->countByRole();
        $totalUsers = array_sum($statsByRole);
        
        // Utilisateurs récents (derniers 5 inscrits)
        $recentUsers = $this->userRepository->findRecent(5);
        
        $stats = [
            'totalUsers' => $totalUsers,
            'superAdminUsers' => $statsByRole[\RoleHierarchy::ROLE_SUPER_ADMIN] ?? 0,
            'adminUsers' => $statsByRole[\RoleHierarchy::ROLE_ADMIN] ?? 0,
            'regularUsers' => $statsByRole[\RoleHierarchy::ROLE_USER] ?? 0,
            'recentUsers' => $recentUsers,
            'isSuperAdmin' => $this->isSuperAdmin()
        ];
        
        require_once __DIR__ . '/../View/admin/dashboard.php';
    }

    /**
     * Affiche la liste complète des utilisateurs avec actions admin
     * Permet de modifier les rôles et supprimer des comptes
     */
    private function users(): void {
        // Utiliser la nouvelle méthode avec tri hiérarchique
        $utilisateurs = $this->userRepository->findAllWithHierarchy();
        require_once __DIR__ . '/../View/admin/users.php';
    }

    /**
     * Bascule le rôle d'un utilisateur entre 'user' et 'admin'
     * Seul le super_admin peut promouvoir en admin
     * @param int $id ID de l'utilisateur passé en GET
     */
    private function toggleRole(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($id === 0) {
            $_SESSION['error'] = 'ID utilisateur invalide.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        // Vérifier les permissions de hiérarchie
        if (!$this->canActOnTarget($id)) {
            $_SESSION['error'] = 'Action non autorisée : vous ne pouvez pas modifier cet utilisateur.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        $utilisateur = $this->userRepository->findById($id);
        
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouvé.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        $currentRole = $utilisateur['role'];
        $currentUserRole = $_SESSION['user']['role'];
        
        // Logique de basculement avec hiérarchie
        $newRole = null;
        
        if ($currentRole === \RoleHierarchy::ROLE_USER) {
            // User -> Admin : seul super_admin peut faire cette promotion
            if (\RoleHierarchy::canPromoteTo($currentUserRole, \RoleHierarchy::ROLE_ADMIN)) {
                $newRole = \RoleHierarchy::ROLE_ADMIN;
            } else {
                $_SESSION['error'] = 'Seul un super-admin peut promouvoir un utilisateur en admin.';
                header('Location: ?controller=admin&action=users');
                exit;
            }
        } elseif ($currentRole === \RoleHierarchy::ROLE_ADMIN) {
            // Admin -> User : admin ou super_admin peut rétrograder
            if (\RoleHierarchy::canModify($currentUserRole, $currentRole)) {
                $newRole = \RoleHierarchy::ROLE_USER;
            } else {
                $_SESSION['error'] = 'Vous ne pouvez pas rétrograder cet admin.';
                header('Location: ?controller=admin&action=users');
                exit;
            }
        } elseif ($currentRole === \RoleHierarchy::ROLE_SUPER_ADMIN) {
            // Personne ne peut modifier un super_admin
            $_SESSION['error'] = 'Impossible de modifier le rôle d\'un super-admin.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        if ($newRole && $this->userRepository->updateRole($id, $newRole)) {
            $action = $newRole === \RoleHierarchy::ROLE_ADMIN ? 'promu admin' : 'rétrogradé utilisateur';
            $_SESSION['success'] = "L'utilisateur {$utilisateur['prenom']} {$utilisateur['nom']} a été {$action}.";
        } else {
            $_SESSION['error'] = 'Erreur lors de la modification du rôle.';
        }
        
        header('Location: ?controller=admin&action=users');
        exit;
    }

    /**
     * Supprime un utilisateur (action admin)
     * Respecte la hiérarchie des rôles
     * @param int $id ID de l'utilisateur à supprimer
     */
    private function deleteUser(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($id === 0) {
            $_SESSION['error'] = 'ID utilisateur invalide.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        // Vérifier les permissions de hiérarchie
        if (!$this->canActOnTarget($id)) {
            $_SESSION['error'] = 'Action non autorisée : vous ne pouvez pas supprimer cet utilisateur.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        $utilisateur = $this->userRepository->findById($id);
        
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouvé.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        // Vérifier qu'on ne peut pas supprimer un super_admin
        if ($utilisateur['role'] === \RoleHierarchy::ROLE_SUPER_ADMIN) {
            $_SESSION['error'] = 'Impossible de supprimer un super-admin.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        if ($this->userRepository->delete($id)) {
            $_SESSION['success'] = "L'utilisateur {$utilisateur['prenom']} {$utilisateur['nom']} a été supprimé.";
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression de l\'utilisateur.';
        }
        
        header('Location: ?controller=admin&action=users');
        exit;
    }

    /**
     * Affiche le profil détaillé d'un utilisateur avec son historique d'analyses
     * Permet à l'admin de voir toutes les informations d'un utilisateur
     */
    private function viewUserProfile(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($id === 0) {
            $_SESSION['error'] = 'ID utilisateur invalide.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        // Récupérer les informations de l'utilisateur
        $utilisateur = $this->userRepository->findById($id);
        
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouvé.';
            header('Location: ?controller=admin&action=users');
            exit;
        }
        
        // Récupérer l'historique des analyses de l'utilisateur
        $analysisRepository = new UserAnalysisRepository();
        $recentAnalyses = $analysisRepository->findByUserId($id, 10);
        $userStats = $analysisRepository->getUserStats($id);
        
        // Passer les données à la vue
        require_once __DIR__ . '/../View/utilisateur/profile.php';
    }
}
