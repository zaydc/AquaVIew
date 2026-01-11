<?php
namespace App\Config;

class Conf {
    private static array $database = [
        'hostname' => 'localhost',
        'database' => 'aquaview',
        'login' => 'root',
        'password' => ''
    ];

    public static function getLogin(): string {
        return self::$database['login'];
    }

    public static function getHostname(): string {
        return self::$database['hostname'];
    }

    public static function getDatabase(): string {
        return self::$database['database'];
    }

    public static function getPassword(): string {
        return self::$database['password'];
    }
}
