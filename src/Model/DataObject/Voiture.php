<?php
namespace App\Model\DataObject;

class Voiture extends AbstractDataObject {
    public function __construct(
        private ?int $id,
        private string $marque,
        private string $modele,
        private int $annee,
        private float $prix,
        private ?int $utilisateurId = null
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getMarque(): string { return $this->marque; }
    public function getModele(): string { return $this->modele; }
    public function getAnnee(): int { return $this->annee; }
    public function getPrix(): float { return $this->prix; }
    public function getUtilisateurId(): ?int { return $this->utilisateurId; }

    public function setId(int $id): void { $this->id = $id; }
    public function setMarque(string $marque): void { $this->marque = $marque; }
    public function setModele(string $modele): void { $this->modele = $modele; }
    public function setAnnee(int $annee): void { $this->annee = $annee; }
    public function setPrix(float $prix): void { $this->prix = $prix; }
    public function setUtilisateurId(int $utilisateurId): void { $this->utilisateurId = $utilisateurId; }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'marque' => $this->marque,
            'modele' => $this->modele,
            'annee' => $this->annee,
            'prix' => $this->prix,
            'utilisateur_id' => $this->utilisateurId
        ];
    }
}
