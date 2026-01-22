<?php
/**
 * Gestion de la hiérarchie des rôles - AquaView
 * BUT2 - S3 - AquaView Project
 * Définit les niveaux de permissions et les règles d'accès
 */

class RoleHierarchy {
    // Niveaux de rôles (numériques pour comparaison facile)
    public const LEVEL_USER = 1;
    public const LEVEL_ADMIN = 2;
    public const LEVEL_SUPER_ADMIN = 3;
    
    // Noms de rôles
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_SUPER_ADMIN = 'super_admin';
    
    /**
     * Tableau de correspondance rôle -> niveau
     */
    public static array $roleLevels = [
        self::ROLE_USER => self::LEVEL_USER,
        self::ROLE_ADMIN => self::LEVEL_ADMIN,
        self::ROLE_SUPER_ADMIN => self::LEVEL_SUPER_ADMIN,
    ];
    
    /**
     * Tableau de correspondance niveau -> rôle
     */
    public static array $levelRoles = [
        self::LEVEL_USER => self::ROLE_USER,
        self::LEVEL_ADMIN => self::ROLE_ADMIN,
        self::LEVEL_SUPER_ADMIN => self::ROLE_SUPER_ADMIN,
    ];
    
    /**
     * Vérifie si un rôle peut modifier un autre rôle
     * @param string $actorRole Rôle de celui qui fait l'action
     * @param string $targetRole Rôle de la cible
     * @return bool True si l'action est autorisée
     */
    public static function canModify(string $actorRole, string $targetRole): bool {
        $actorLevel = self::$roleLevels[$actorRole] ?? 0;
        $targetLevel = self::$roleLevels[$targetRole] ?? 0;
        
        // Un rôle peut uniquement modifier les rôles de niveau inférieur
        return $actorLevel > $targetLevel;
    }
    
    /**
     * Vérifie si un rôle peut promouvoir vers un certain niveau
     * @param string $actorRole Rôle de celui qui fait l'action
     * @param string $targetRole Rôle cible de la promotion
     * @return bool True si la promotion est autorisée
     */
    public static function canPromoteTo(string $actorRole, string $targetRole): bool {
        // Seul le super_admin peut promouvoir en admin
        if ($targetRole === self::ROLE_ADMIN) {
            return $actorRole === self::ROLE_SUPER_ADMIN;
        }
        
        // Personne ne peut promouvoir en super_admin (manuel uniquement)
        if ($targetRole === self::ROLE_SUPER_ADMIN) {
            return false;
        }
        
        // Pour les autres cas, utiliser la logique standard
        return self::canModify($actorRole, $targetRole);
    }
    
    /**
     * Vérifie si l'utilisateur peut s'auto-modifier
     * @param string $role Rôle de l'utilisateur
     * @param int $userId ID de l'utilisateur
     * @param int $targetId ID de la cible
     * @return bool True si l'auto-modification est autorisée
     */
    public static function canSelfModify(string $role, int $userId, int $targetId): bool {
        // Seul le super_admin peut s'auto-modifier
        if ($userId === $targetId) {
            return $role === self::ROLE_SUPER_ADMIN;
        }
        
        return true;
    }
    
    /**
     * Retourne tous les rôles valides
     * @return array Liste des rôles disponibles
     */
    public static function getAllRoles(): array {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN,
        ];
    }
    
    /**
     * Vérifie si un rôle est valide
     * @param string $role Rôle à vérifier
     * @return bool True si le rôle est valide
     */
    public static function isValidRole(string $role): bool {
        return in_array($role, self::getAllRoles());
    }
    
    /**
     * Retourne le niveau d'un rôle
     * @param string $role Rôle
     * @return int Niveau du rôle (0 si invalide)
     */
    public static function getLevel(string $role): int {
        return self::$roleLevels[$role] ?? 0;
    }
}
