<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Employe;
use App\Models\Trajet;
use App\Models\Agence;

/**
 * Contrôleur d'administration
 * 
 * @package App\Controllers
 */
class AdminController extends Controller
{
    /**
     * Modèle Employe
     * 
     * @var Employe
     */
    private Employe $employeModel;

    /**
     * Modèle Trajet
     * 
     * @var Trajet
     */
    private Trajet $trajetModel;

    /**
     * Modèle Agence
     * 
     * @var Agence
     */
    private Agence $agenceModel;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->employeModel = new Employe();
        $this->trajetModel = new Trajet();
        $this->agenceModel = new Agence();
    }

    /**
     * Tableau de bord admin
     * 
     * @return void
     */
    public function dashboard(): void
    {
        $this->requireAdmin();

        $stats = [
            'nb_employes' => count($this->employeModel->all()),
            'nb_agences' => count($this->agenceModel->all()),
            'nb_trajets' => count($this->trajetModel->all())
        ];

        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    /**
     * Liste des utilisateurs
     * 
     * @return void
     */
    public function listUsers(): void
    {
        $this->requireAdmin();

        $employes = $this->employeModel->getAllOrdered();

        $this->view('admin/users', ['employes' => $employes]);
    }

    /**
     * Liste des trajets
     * 
     * @return void
     */
    public function listTrajets(): void
    {
        $this->requireAdmin();

        $trajets = $this->trajetModel->getAllWithDetails();

        $this->view('admin/trajets', ['trajets' => $trajets]);
    }

    /**
     * Supprimer un trajet (admin)
     * 
     * @param int $id
     * @return void
     */
    public function deleteTrajet(int $id): void
    {
        $this->requireAdmin();

        if ($this->trajetModel->delete($id)) {
            $_SESSION['success'] = 'Trajet supprimé avec succès';
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la suppression'];
        }

        $this->redirect('/admin/trajets');
    }
}