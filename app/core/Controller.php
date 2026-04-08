<?php

namespace App\Core;

/**
 * Contrôleur de base
 * 
 * @package App\Core
 */
class Controller
{
    /**
     * Rendre une vue
     * 
     * @param string $view Nom de la vue
     * @param array $data Données à passer à la vue
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = ROOT_PATH . "/app/views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            die("La vue {$view} n'existe pas");
        }

        require_once $viewPath;
    }

    /**
     * Rediriger vers une URL
     * 
     * @param string $url URL de redirection
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Retourner une réponse JSON
     * 
     * @param mixed $data Données à retourner
     * @param int $statusCode Code de statut HTTP
     * @return void
     */
    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Vérifier si l'utilisateur est connecté
     * 
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Vérifier si l'utilisateur est admin
     * 
     * @return bool
     */
    protected function isAdmin(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Exiger une authentification
     * 
     * @return void
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }

    /**
     * Exiger le rôle admin
     * 
     * @return void
     */
    protected function requireAdmin(): void
    {
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }
    }
}