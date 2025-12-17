<?php
namespace App\Controller;

use App\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur {
    private UtilisateurRepository $repository;

    public function __construct() {
        $this->repository = new UtilisateurRepository();
        $this->handleAction();
    }

    private function handleAction(): void {
        $action = $_GET['action'] ?? 'list';
        
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'doLogin':
                $this->doLogin();
                break;
            case 'register':
                $this->register();
                break;
            case 'doRegister':
                $this->doRegister();
                break;
            case 'logout':
                $this->logout();
                break;
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

    private function login(): void {
        require_once __DIR__ . '/../View/utilisateur/login.php';
    }

    private function doLogin(): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email et mot de passe requis.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $user = $this->repository->findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom']
        ];

        header('Location: /');
        exit;
    }

    private function register(): void {
        require_once __DIR__ . '/../View/utilisateur/register.php';
    }

    private function doRegister(): void {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($nom) || empty($prenom) || empty($email) || empty($numero) || empty($password)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $_SESSION['error'] = 'Mot de passe invalide (min 8 car., 1 Maj, 1 Chiffre).';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if ($this->repository->emailExists($email)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($this->repository->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numero' => $numero,
            'mot_de_passe' => $hash
        ])) {
            $_SESSION['success'] = 'Compte créé avec succès !';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $_SESSION['error'] = 'Erreur lors de la création du compte.';
        header('Location: ?controller=utilisateur&action=register');
        exit;
    }

    private function logout(): void {
        session_destroy();
        header('Location: /');
        exit;
    }

    private function list(): void {
        $utilisateurs = $this->repository->findAll();
        require_once __DIR__ . '/../View/utilisateur/list.php';
    }

    private function detail(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $utilisateur = $this->repository->findById($id);
        
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouvé.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        require_once __DIR__ . '/../View/utilisateur/detail.php';
    }

    private function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->repository->create([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero'],
                'mot_de_passe' => $hash
            ]);
            $_SESSION['success'] = 'Utilisateur créé avec succès.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        require_once __DIR__ . '/../View/utilisateur/create.php';
    }

    private function update(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->update($id, [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero']
            ]);
            $_SESSION['success'] = 'Utilisateur mis à jour.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        $utilisateur = $this->repository->findById($id);
        require_once __DIR__ . '/../View/utilisateur/update.php';
    }

    private function delete(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $this->repository->delete($id);
        $_SESSION['success'] = 'Utilisateur supprimé.';
        header('Location: ?controller=utilisateur&action=list');
        exit;
    }
}
