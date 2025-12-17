<?php
namespace App\Model\Repository;

class UtilisateurRepository extends AbstractRepository {
    protected string $tableName = 'utilisateurs';

    public function findByEmail(string $email): ?array {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function emailExists(string $email): bool {
        return $this->findByEmail($email) !== null;
    }

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
}
