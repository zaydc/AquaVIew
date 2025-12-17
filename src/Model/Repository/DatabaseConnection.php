<?php
namespace App\Model\Repository;

use App\Config\Conf;
use PDO;
use PDOException;

class DatabaseConnection {
    private static ?DatabaseConnection $instance = null;
    private ?PDO $pdo = null;

    private function __construct() {
        $hostname = Conf::getHostname();
        $database = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try {
            $this->pdo = new PDO(
                "mysql:host=$hostname;dbname=$database;charset=utf8mb4",
                $login,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): DatabaseConnection {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}
