<?php
/**
 * Repository pour la gestion des utilisateurs
 * BUT2 - S3 - AquaView Project
 * Permet de gerer les utilisateurs dans la BDD
 */

namespace App\Model\Repository;

// Inclusion de la hiérarchie des rôles
require_once __DIR__ . '/../../Lib/RoleHierarchy.php';

/**
 * UtilisateurRepository - Gestion des données utilisateurs
 * 
 * Ce repository gere :
 * - Authentification par email
 * - Creation et mise a jour de comptes
 * - Validation d'unicité d'email
 * - Herite des operations CRUD de base d'AbstractRepository
 */
class UtilisateurRepository extends AbstractRepository {
    /** @var string Nom de la table utilisateurs en BDD */
    protected string $tableName = 'utilisateurs';

    /**
     * Cherche un utilisateur par son email
     * Utilisé pour l'authentification
     * @param string $email Email de l'utilisateur
     * @return array|null Données de l'utilisateur ou null si pas trouve
     */
    public function findByEmail(string $email): ?array {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Verifie si un email existe deja
     * Utilisé pour l'inscription pour eviter les doublons
     * @param string $email Email a verifier
     * @return bool True si l'email existe, false sinon
     */
    public function emailExists(string $email): bool {
        return $this->findByEmail($email) !== null;
    }

    /**
     * Cree un nouvel utilisateur dans la BDD
     * Ajoute automatiquement la date d'inscription (NOW())
     * @param array $data Données de l'utilisateur (nom, prenom, email, numero, mot_de_passe)
     * @return bool True si ca marche, false sinon
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->tableName} (nom, prenom, email, numero, mot_de_passe, role, date_inscription) 
                VALUES (:nom, :prenom, :email, :numero, :mot_de_passe, :role, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numero' => $data['numero'],
            'mot_de_passe' => $data['mot_de_passe'],
            'role' => $data['role'] ?? 'user' // Par défaut 'user' si non spécifié
        ]);
    }

    /**
     * Met a jour les infos d'un utilisateur
     * Ne modifie pas le mot de passe (securite)
     * @param int $id ID de l'utilisateur a modifier
     * @param array $data Nouvelles données (nom, prenom, email, numero)
     * @return bool True si la mise a jour a marche, false sinon
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->tableName} SET nom = :nom, prenom = :prenom, email = :email, numero = :numero WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numero' => $data['numero']
        ]);
    }

    /**
     * Met à jour uniquement le mot de passe d'un utilisateur
     * Séparé de update() pour des raisons de sécurité
     * @param int $id ID de l'utilisateur
     * @param string $passwordHash Nouveau mot de passe hashé
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public function updatePassword(int $id, string $passwordHash): bool {
        $sql = "UPDATE {$this->tableName} SET mot_de_passe = :mot_de_passe WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'mot_de_passe' => $passwordHash
        ]);
    }

    /**
     * Cherche des utilisateurs par leur rôle
     * Utilisé pour l'administration
     * @param string $role Rôle à rechercher ('admin' ou 'user')
     * @return array Liste des utilisateurs avec ce rôle
     */
    public function findByRole(string $role): array {
        $sql = "SELECT * FROM {$this->tableName} WHERE role = :role ORDER BY nom, prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les utilisateurs les plus récents
     * Utilisé pour le dashboard admin
     * @param int $limit Nombre maximum d'utilisateurs à retourner
     * @return array Liste des utilisateurs récents
     */
    public function findRecent(int $limit = 5): array {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY date_inscription DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Met à jour le rôle d'un utilisateur
     * Utilisé par l'administration pour promouvoir/rétrograder
     * @param int $id ID de l'utilisateur
     * @param string $role Nouveau rôle ('user', 'admin' ou 'super_admin')
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public function updateRole(int $id, string $role): bool {
        // Vérifier si le rôle est valide
        if (!\RoleHierarchy::isValidRole($role)) {
            return false;
        }
        
        $sql = "UPDATE {$this->tableName} SET role = :role WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'role' => $role
        ]);
    }
    
    /**
     * Récupère le rôle d'un utilisateur
     * @param int $id ID de l'utilisateur
     * @return string|null Rôle de l'utilisateur ou null si pas trouvé
     */
    public function getRole(int $id): ?string {
        $sql = "SELECT role FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ? $result['role'] : null;
    }
    
    /**
     * Vérifie si un utilisateur peut modifier un autre utilisateur
     * @param int $actorId ID de celui qui fait l'action
     * @param int $targetId ID de la cible
     * @return bool True si l'action est autorisée
     */
    public function canModifyUser(int $actorId, int $targetId): bool {
        $actorRole = $this->getRole($actorId);
        $targetRole = $this->getRole($targetId);
        
        if (!$actorRole || !$targetRole) {
            return false;
        }
        
        // Vérifier l'auto-modification
        if (!\RoleHierarchy::canSelfModify($actorRole, $actorId, $targetId)) {
            return false;
        }
        
        // Vérifier la hiérarchie
        return \RoleHierarchy::canModify($actorRole, $targetRole);
    }
    
    /**
     * Récupère tous les utilisateurs avec leur niveau hiérarchique
     * @return array Liste des utilisateurs triés par rôle puis par nom
     */
    public function findAllWithHierarchy(): array {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY 
                CASE 
                    WHEN role = 'super_admin' THEN 1
                    WHEN role = 'admin' THEN 2
                    WHEN role = 'user' THEN 3
                    ELSE 4
                END,
                nom, prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Compte le nombre d'utilisateurs par rôle
     * @return array Statistiques des rôles
     */
    public function countByRole(): array {
        $sql = "SELECT role, COUNT(*) as count FROM {$this->tableName} GROUP BY role ORDER BY count DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $stats = [];
        foreach ($result as $row) {
            $stats[$row['role']] = (int)$row['count'];
        }
        
        return $stats;
    }
}
