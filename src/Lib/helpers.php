<?php
/**
 * Fonctions utilitaires pour l'application AquaView
 * BUT2 - S3 - AquaVIew Project
 * Helper functions pour les tâches courantes (auth, redirections, etc.)
 */

/**
 * Vérifie si un utilisateur est connecté
 * @return bool True si l'utilisateur est authentifié, false sinon
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

/**
 * Récupère les informations de l'utilisateur connecté
 * @return array|null Données de l'utilisateur ou null si non connecté
 */
function getUser(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Effectue une redirection HTTP sécurisée
 * @param string $url URL de destination
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Vérifie si la page actuelle correspond à l'action spécifiée
 * Utile pour les classes CSS actives dans la navigation
 * @param string $action Action à comparer
 * @return bool True si la page actuelle correspond à l'action
 */
function isCurrentPage(string $action): bool {
    $currentAction = $_GET['action'] ?? 'home';
    return $currentAction === $action;
}

/**
 * Get error message from session and clear it
 */
function getError(): ?string {
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
    return $error;
}

/**
 * Get success message from session and clear it
 */
function getSuccess(): ?string {
    $success = $_SESSION['success'] ?? null;
    unset($_SESSION['success']);
    return $success;
}

/**
 * Get metric label in French
 */
function getMetricLabel(string $metric): string {
    $labels = [
        'dissoxygen' => "Niveau d'oxygène",
        'water_temp' => 'Température',
        'salinity' => 'Salinité',
        'ph' => 'pH'
    ];
    
    return $labels[$metric] ?? $metric;
}

/**
 * Get metric unit
 */
function getMetricUnit(string $metric): string {
    $units = [
        'dissoxygen' => 'mg/L',
        'water_temp' => '°C',
        'salinity' => 'PSU',
        'ph' => ''
    ];
    
    return $units[$metric] ?? '';
}

/**
 * Format file size in human readable format
 */
function formatFileSize(int $bytes): string {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, 2) . ' ' . $units[$pow];
}
