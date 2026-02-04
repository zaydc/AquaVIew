<?php
/**
 * Fichier de configuration pour la BDD
 * BUT2 - S3 - AquaView Project
 * Contient tous les params de connexion a la BDD
 */

namespace App\Config;

/**
 * Classe de configuration pour la BDD
 * Permet de centraliser tous les params de connexion
 * Utilise le pattern Singleton pour eviter les connexions multiples
 */
class Conf {
    /**
     * Configuration de la BDD
     * @var array Contient hostname, database, login, password
     */
    private static array $database = [
        'hostname' => 'localhost',  // Serveur MySQL local
        'database' => 'aquaview',   // Nom de notre BDD de donnees oceaniques
        'login' => 'root',          // Utilisateur MySQL (a adapter en prod)
        'password' => ''            // Mot de passe MySQL (vide en local)
    ];

    /**
     * Retourne le nom d'utilisateur pour la BDD
     * @return string Login MySQL
     */
    public static function getLogin(): string {
        return self::$database['login'];
    }

    /**
     * Retourne l'adresse du serveur de BDD
     * @return string Hostname du serveur MySQL
     */
    public static function getHostname(): string {
        return self::$database['hostname'];
    }

    /**
     * Retourne le nom de la BDD
     * @return string Nom de la BDD aquaview
     */
    public static function getDatabase(): string {
        return self::$database['database'];
    }

    /**
     * Retourne le mot de passe pour la connexion BDD
     * @return string Mot de passe MySQL
     */
    public static function getPassword(): string {
        return self::$database['password'];
    }
}
