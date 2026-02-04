<?php
/**
 * Gestionnaire de connexion a la BDD
 * BUT2 - S3 - AquaView Project
 * Pattern Singleton pour eviter les connexions multiples
 */

namespace App\Model\Repository;

use App\Config\Conf;
use PDO;
use PDOException;

/**
 * DatabaseConnection - Singleton pour la connexion PDO
 * 
 * Cette classe garantit qu'une seule connexion a la BDD existe
 * Pattern Singleton : economise les ressources et evite les connexions multiples
 */
class DatabaseConnection {
    /** @var DatabaseConnection|null Instance unique de la classe */
    private static ?DatabaseConnection $instance = null;
    /** @var PDO|null Objet PDO pour la connexion a la base */
    private ?PDO $pdo = null;

    /**
     * Constructeur prive - Pattern Singleton
     * Cree la connexion PDO avec les params de Conf.php
     * Prive pour empecher l'instanciation directe
     */
    private function __construct() {
        // Recuperation des params de config
        $hostname = Conf::getHostname();
        $database = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        $port = Conf::getPort(); // Ajout du port

        try {
            // Creation de la connexion PDO avec options de securite
            $this->pdo = new PDO(
                "mysql:host=$hostname;port=$port;dbname=$database;charset=utf8mb4", // Ajout du port
                $login,
                $password,
                [
                    // Mode d'erreur : exceptions plutot que warnings
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Mode de fetch par defaut : tableau associatif
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
            
            // Désactiver ONLY_FULL_GROUP_BY pour compatibilité macOS
            $this->pdo->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            
        } catch (PDOException $e) {
            // En production, remplacer par un log d'erreur
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Point d'acces a l'instance unique - Pattern Singleton
     * Cree l'instance si elle n'existe pas, puis la retourne
     * @return DatabaseConnection Instance unique de la connexion
     */
    public static function getInstance(): DatabaseConnection {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    /**
     * Accesseur a l'objet PDO
     * Permet aux repositories d'executer des requetes SQL
     * @return PDO Objet PDO connecte a la BDD
     */
    public function getPdo(): PDO {
        return $this->pdo;
    }
}