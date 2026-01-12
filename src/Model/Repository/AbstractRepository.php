<?php
/**
 * Repository de base abstrait
 * BUT2 - S3 - AquaView Project
 * Fournit les operations CRUD generiques pour tous les repositories
 */

namespace App\Model\Repository;

use PDO;

/**
 * AbstractRepository - Classe de base pour tous les repositories
 * 
 * Cette classe abstraite implemente les operations CRUD de base :
 * - Create : a implementer dans les classes filles
 * - Read : findAll(), findById() deja implementes
 * - Update : a implementer dans les classes filles
 * - Delete : delete() deja implemente
 * 
 * Pattern Repository : isole la logique d'acces aux donnees
 */
abstract class AbstractRepository {
    /** @var PDO Connexion a la BDD */
    protected PDO $pdo;
    /** @var string Nom de la table dans la BDD */
    protected string $tableName;
    /** @var string Nom de la cle primaire (generalement 'id') */
    protected string $primaryKey = 'id';

    /**
     * Constructeur - Initialise la connexion a la BDD
     * Utilise le Singleton DatabaseConnection pour eviter les connexions multiples
     */
    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getPdo();
    }

    /**
     * Recupere tous les enregistrements de la table
     * @return array Tableau de tous les enregistrements (tableaux associatifs)
     */
    public function findAll(): array {
        $sql = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recupere un enregistrement par son ID
     * @param int $id ID de l'enregistrement a chercher
     * @return array|null Tableau associatif de l'enregistrement ou null si pas trouve
     */
    public function findById(int $id): ?array {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Supprime un enregistrement par son ID
     * @param int $id ID de l'enregistrement a supprimer
     * @return bool True si la suppression a marche, false sinon
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
