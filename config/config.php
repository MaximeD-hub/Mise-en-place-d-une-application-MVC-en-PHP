<?php
/**
 * Configuration générale de l'application
 * 
 * @package Config
 */

// Fuseau horaire
date_default_timezone_set('Europe/Paris');

// Constantes de l'application
define('APP_NAME', 'Touche Pas au Klaxon');
define('BASE_URL', 'http://localhost:8000');
define('ROOT_PATH', dirname(__DIR__));

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Activer l'autoloader de Composer
require_once ROOT_PATH . '/vendor/autoload.php';