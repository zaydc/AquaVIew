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
