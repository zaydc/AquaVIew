<?php
namespace App\Model\Repository;

use PDO;

abstract class AbstractRepository {
    protected PDO $pdo;
    protected string $tableName;
    protected string $primaryKey = 'id';

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getPdo();
    }

    public function findAll(): array {
        $sql = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
