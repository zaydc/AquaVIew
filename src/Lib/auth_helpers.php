<?php
/**
 * Fonctions utilitaires pour la gestion des rôles et permissions
 * BUT2 - S3 - AquaView Project
 */

/**
 * Vérifie si l'utilisateur connecté est un administrateur (admin ou super_admin)
 * @return bool True si l'utilisateur est admin ou super_admin, false sinon
 */
function isAdmin(): bool {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    
    $role = $_SESSION['user']['role'] ?? 'user';
    return $role === 'admin' || $role === 'super_admin';
}

/**
 * Vérifie si l'utilisateur connecté est un super administrateur
 * @return bool True si l'utilisateur est super_admin, false sinon
 */
function isSuperAdmin(): bool {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    
    return ($_SESSION['user']['role'] ?? 'user') === 'super_admin';
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
 */
function requireLogin(): void {
    if (!isset($_SESSION['user'])) {
        header('Location: ?controller=utilisateur&action=login');
        exit;
    }
}

/**
 * Vérifie si l'utilisateur connecté est le propriétaire de la ressource
 * ou s'il est admin (accès autorisé)
 * @param int $resourceUserId ID de l'utilisateur propriétaire de la ressource
 * @return bool True si accès autorisé, false sinon
 */
function canAccessResource(int $resourceUserId): bool {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    
    $currentUserId = $_SESSION['user']['id'];
    return $currentUserId === $resourceUserId || isAdmin();
}

/**
 * Redirige vers l'accueil si l'utilisateur n'est pas admin
 * Affiche un message d'erreur
 */
function requireAdmin(): void {
    if (!isAdmin()) {
        $_SESSION['error'] = 'Accès réservé aux administrateurs.';
        header('Location: /');
        exit;
    }
}

/**
 * Redirige vers l'accueil si l'utilisateur n'est pas super admin
 * Affiche un message d'erreur
 */
function requireSuperAdmin(): void {
    if (!isSuperAdmin()) {
        $_SESSION['error'] = 'Accès réservé aux super administrateurs.';
        header('Location: /');
        exit;
    }
}

/**
 * Met à jour la session utilisateur avec le rôle depuis la BDD
 * À appeler après la connexion
 * @param array $userData Données complètes de l'utilisateur depuis la BDD
 */
function updateUserSession(array $userData): void {
    $_SESSION['user'] = [
        'id' => $userData['id'],
        'email' => $userData['email'],
        'nom' => $userData['nom'],
        'prenom' => $userData['prenom'],
        'role' => $userData['role'] // Rôle directement depuis la BDD, sans fallback
    ];
}
