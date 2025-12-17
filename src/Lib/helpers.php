<?php
/**
 * Helper functions for the application
 */

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

/**
 * Get current logged in user
 */
function getUser(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Redirect to a URL
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Check if current page matches action
 */
function isCurrentPage(string $action): bool {
    $currentAction = $_GET['action'] ?? 'home';
    return $currentAction === $action;
}
