<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agence;

/**
 * Contrôleur des agences
 * 
 * @package App\Controllers
 */
class AgenceController extends Controller
{
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
        $this->agenceModel = new Agence();
    }

    /**
     * Liste des agences (admin)
     * 
     * @return void
     */
    public function index(): void
    {
        $this->requireAdmin();

        $agences = $this->agenceModel->getAllOrdered();

        $this->view('admin/agences', ['agences' => $agences]);
    }

    /**
     * Formulaire de création d'agence
     * 
     * @return void
     */
    public function create(): void
    {
        $this->requireAdmin();

        $this->view('admin/agence-form', ['agence' => null]);
    }

    /**
     * Enregistrer une nouvelle agence
     * 
     * @return void
     */
    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/agence/create');
        }

        $nom = trim($_POST['nom'] ?? '');
        $errors = [];

        // Validation
        if (empty($nom)) {
            $errors['nom'] = 'Le nom de l\'agence est requis';
        } elseif ($this->agenceModel->nameExists($nom)) {
            $errors['nom'] = 'Cette agence existe déjà';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['nom' => $nom];
            $this->redirect('/admin/agence/create');
        }

        // Créer l'agence
        if ($this->agenceModel->create(['nom' => $nom])) {
            $_SESSION['success'] = 'Agence créée avec succès';
            $this->redirect('/admin/agences');
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la création'];
            $this->redirect('/admin/agence/create');
        }
    }

    /**
     * Formulaire de modification d'agence
     * 
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->requireAdmin();

        $agence = $this->agenceModel->find($id);

        if (!$agence) {
            $_SESSION['errors'] = ['general' => 'Agence non trouvée'];
            $this->redirect('/admin/agences');
        }

        $this->view('admin/agence-form', ['agence' => $agence]);
    }

    /**
     * Mettre à jour une agence
     * 
     * @param int $id
     * @return void
     */
    public function update(int $id): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/agence/edit/' . $id);
        }

        $nom = trim($_POST['nom'] ?? '');
        $errors = [];

        // Validation
        if (empty($nom)) {
            $errors['nom'] = 'Le nom de l\'agence est requis';
        } elseif ($this->agenceModel->nameExists($nom, $id)) {
            $errors['nom'] = 'Cette agence existe déjà';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['nom' => $nom];
            $this->redirect('/admin/agence/edit/' . $id);
        }

        // Mettre à jour
        if ($this->agenceModel->update($id, ['nom' => $nom])) {
            $_SESSION['success'] = 'Agence modifiée avec succès';
            $this->redirect('/admin/agences');
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la modification'];
            $this->redirect('/admin/agence/edit/' . $id);
        }
    }

    /**
     * Supprimer une agence
     * 
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->requireAdmin();

        // Vérifier si l'agence est utilisée dans des trajets
        $nbTrajets = $this->agenceModel->countTrajets($id);

        if ($nbTrajets > 0) {
            $_SESSION['errors'] = ['general' => "Impossible de supprimer : {$nbTrajets} trajet(s) utilisent cette agence"];
            $this->redirect('/admin/agences');
        }

        if ($this->agenceModel->delete($id)) {
            $_SESSION['success'] = 'Agence supprimée avec succès';
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la suppression'];
        }

        $this->redirect('/admin/agences');
    }
}