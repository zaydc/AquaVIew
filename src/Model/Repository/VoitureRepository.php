<?php
namespace App\Model\Repository;

class VoitureRepository extends AbstractRepository {
    protected string $tableName = 'voitures';

    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->tableName} (marque, modele, annee, prix, utilisateur_id) 
                VALUES (:marque, :modele, :annee, :prix, :utilisateur_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->tableName} SET marque = :marque, modele = :modele, annee = :annee, prix = :prix WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function findByUtilisateur(int $utilisateurId): array {
        $sql = "SELECT * FROM {$this->tableName} WHERE utilisateur_id = :utilisateur_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['utilisateur_id' => $utilisateurId]);
        return $stmt->fetchAll();
    }
}
