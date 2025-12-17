<?php
namespace App\Controller;

use App\Model\Repository\VoitureRepository;

class ControllerVoiture {
    private VoitureRepository $repository;

    public function __construct() {
        $this->repository = new VoitureRepository();
        $this->handleAction();
    }

    private function handleAction(): void {
        $action = $_GET['action'] ?? 'list';
        
        switch ($action) {
            case 'list':
                $this->list();
                break;
            case 'detail':
                $this->detail();
                break;
            case 'create':
                $this->create();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->list();
        }
    }

    private function list(): void {
        $voitures = $this->repository->findAll();
        require_once __DIR__ . '/../View/voiture/list.php';
    }

    private function detail(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $voiture = $this->repository->findById($id);
        
        if (!$voiture) {
            $_SESSION['error'] = 'Voiture non trouvée.';
            header('Location: ?controller=voiture&action=list');
            exit;
        }
        
        require_once __DIR__ . '/../View/voiture/detail.php';
    }

    private function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->create([
                'marque' => $_POST['marque'],
                'modele' => $_POST['modele'],
                'annee' => (int) $_POST['annee'],
                'prix' => (float) $_POST['prix'],
                'utilisateur_id' => $_SESSION['user']['id'] ?? null
            ]);
            $_SESSION['success'] = 'Voiture créée avec succès.';
            header('Location: ?controller=voiture&action=list');
            exit;
        }
        require_once __DIR__ . '/../View/voiture/create.php';
    }

    private function update(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->update($id, [
                'marque' => $_POST['marque'],
                'modele' => $_POST['modele'],
                'annee' => (int) $_POST['annee'],
                'prix' => (float) $_POST['prix']
            ]);
            $_SESSION['success'] = 'Voiture mise à jour.';
            header('Location: ?controller=voiture&action=list');
            exit;
        }
        
        $voiture = $this->repository->findById($id);
        require_once __DIR__ . '/../View/voiture/update.php';
    }

    private function delete(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $this->repository->delete($id);
        $_SESSION['success'] = 'Voiture supprimée.';
        header('Location: ?controller=voiture&action=list');
        exit;
    }
}
