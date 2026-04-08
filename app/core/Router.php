<?php

namespace App\Core;

/**
 * Routeur de l'application
 * 
 * @package App\Core
 */
class Router
{
    /**
     * Routes enregistrées
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * Ajouter une route GET
     * 
     * @param string $path Chemin de la route
     * @param string $controller Contrôleur au format "ControllerName@method"
     * @return void
     */
    public function get(string $path, string $controller): void
    {
        $this->addRoute('GET', $path, $controller);
    }

    /**
     * Ajouter une route POST
     * 
     * @param string $path Chemin de la route
     * @param string $controller Contrôleur au format "ControllerName@method"
     * @return void
     */
    public function post(string $path, string $controller): void
    {
        $this->addRoute('POST', $path, $controller);
    }

    /**
     * Ajouter une route
     * 
     * @param string $method Méthode HTTP
     * @param string $path Chemin
     * @param string $controller Contrôleur
     * @return void
     */
    private function addRoute(string $method, string $path, string $controller): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller
        ];
    }

    /**
     * Dispatcher la requête vers le bon contrôleur
     * 
     * @return void
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            // Convertir le pattern en regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                // Extraire les paramètres
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Appeler le contrôleur
                $this->callController($route['controller'], $params);
                return;
            }
        }

        // Route non trouvée
        $this->notFound();
    }

    /**
     * Appeler le contrôleur
     * 
     * @param string $controllerString Format "ControllerName@method"
     * @param array $params Paramètres de la route
     * @return void
     */
    private function callController(string $controllerString, array $params = []): void
    {
        [$controllerName, $method] = explode('@', $controllerString);
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            die("Le contrôleur {$controllerClass} n'existe pas");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            die("La méthode {$method} n'existe pas dans {$controllerClass}");
        }

        call_user_func_array([$controller, $method], $params);
    }

    /**
     * Page 404
     * 
     * @return void
     */
    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 - Page non trouvée</h1>';
        exit;
    }
}