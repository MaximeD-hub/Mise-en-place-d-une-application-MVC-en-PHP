<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe de gestion de la connexion à la base de données
 * 
 * @package App\Core
 */
class Database
{
    /**
     * Instance PDO
     * 
     * @var PDO|null
     */
    private static ?PDO $instance = null;

    /**
     * Constructeur privé pour empêcher l'instanciation directe
     */
    private function __construct()
    {
    }

    /**
     * Obtenir l'instance PDO (Singleton)
     * 
     * @return PDO
     * @throws PDOException
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $config = require ROOT_PATH . '/config/database.php';
                
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=%s',
                    $config['host'],
                    $config['dbname'],
                    $config['charset']
                );

                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                throw new PDOException('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Empêcher le clonage de l'instance
     */
    private function __clone()
    {
    }

    /**
     * Empêcher la désérialisation
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}