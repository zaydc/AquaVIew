<?php
namespace App\Model\DataObject;

class Utilisateur extends AbstractDataObject {
    public function __construct(
        private ?int $id,
        private string $nom,
        private string $prenom,
        private string $email,
        private string $numero,
        private ?string $motDePasse = null,
        private ?string $dateInscription = null,
        private string $role = 'user'
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getNumero(): string { return $this->numero; }
    public function getMotDePasse(): ?string { return $this->motDePasse; }
    public function getDateInscription(): ?string { return $this->dateInscription; }
    public function getRole(): string { return $this->role; }

    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setNumero(string $numero): void { $this->numero = $numero; }
    public function setMotDePasse(string $motDePasse): void { $this->motDePasse = $motDePasse; }
    public function setRole(string $role): void { $this->role = $role; }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'numero' => $this->numero,
            'date_inscription' => $this->dateInscription,
            'role' => $this->role
        ];
    }
}
