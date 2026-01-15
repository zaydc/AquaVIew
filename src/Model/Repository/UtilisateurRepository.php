<?php
/**
 * Repository pour la gestion des utilisateurs
 * BUT2 - S3 - AquaView Project
 * Permet de gerer les utilisateurs dans la BDD
 */

namespace App\Model\Repository;

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
        $sql = "INSERT INTO {$this->tableName} (nom, prenom, email, numero, mot_de_passe, date_inscription) 
                VALUES (:nom, :prenom, :email, :numero, :mot_de_passe, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numero' => $data['numero'],
            'mot_de_passe' => $data['mot_de_passe']
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
}
