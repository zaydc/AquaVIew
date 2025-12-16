<?php
class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function emailExists(string $email): bool {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM utilisateurs WHERE email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    public function create(string $email, string $passwordHash): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO utilisateurs (email, mot_de_passe, date_inscription)
             VALUES (?, ?, NOW())"
        );
        return $stmt->execute([$email, $passwordHash]);
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM utilisateurs WHERE email = ?"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
