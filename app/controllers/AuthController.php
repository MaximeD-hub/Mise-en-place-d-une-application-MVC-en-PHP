<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Employe;

/**
 * Contrôleur d'authentification
 * 
 * @package App\Controllers
 */
class AuthController extends Controller
{
    /**
     * Modèle Employe
     * 
     * @var Employe
     */
    private Employe $employeModel;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->employeModel = new Employe();
    }

    /**
     * Afficher le formulaire de connexion
     * 
     * @return void
     */
    public function showLogin(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/');
        }

        $this->view('auth/login');
    }

    /**
     * Traiter la connexion
     * 
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Validation
        if (empty($email)) {
            $errors['email'] = 'L\'email est requis';
        }

        if (empty($password)) {
            $errors['password'] = 'Le mot de passe est requis';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
        }

        // Authentification
        $employe = $this->employeModel->authenticate($email, $password);

        if ($employe) {
            // Connexion réussie
            $_SESSION['user_id'] = $employe['id_employe'];
            $_SESSION['user_nom'] = $employe['nom'];
            $_SESSION['user_prenom'] = $employe['prenom'];
            $_SESSION['user_email'] = $employe['email'];
            $_SESSION['role'] = $employe['role'];

            // Redirection selon le rôle
            if ($employe['role'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/');
            }
        } else {
            // Échec de connexion
            $_SESSION['errors'] = ['login' => 'Email ou mot de passe incorrect'];
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
        }
    }

    /**
     * Déconnexion
     * 
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }
}