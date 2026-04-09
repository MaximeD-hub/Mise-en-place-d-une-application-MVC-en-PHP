<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Trajet;
use App\Models\Agence;

/**
 * Contrôleur des trajets
 * 
 * @package App\Controllers
 */
class TrajetController extends Controller
{
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
        $this->trajetModel = new Trajet();
        $this->agenceModel = new Agence();
    }

    /**
     * Page d'accueil - Liste des trajets disponibles
     * 
     * @return void
     */
    public function index(): void
    {
        $trajets = $this->trajetModel->getAvailableTrajets();
        
        $this->view('trajet/index', [
            'trajets' => $trajets
        ]);
    }

    /**
     * Afficher les détails d'un trajet (modal)
     * 
     * @param int $id
     * @return void
     */
    public function details(int $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->getTrajetWithDetails($id);

        if (!$trajet) {
            $this->json(['error' => 'Trajet non trouvé'], 404);
        }

        $this->json($trajet);
    }

    /**
     * Formulaire de création d'un trajet
     * 
     * @return void
     */
    public function create(): void
    {
        $this->requireAuth();

        $agences = $this->agenceModel->getAllOrdered();

        $this->view('trajet/create', [
            'agences' => $agences
        ]);
    }

    /**
     * Enregistrer un nouveau trajet
     * 
     * @return void
     */
    public function store(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/trajet/create');
        }

        $data = [
            'id_agence_depart' => $_POST['id_agence_depart'] ?? '',
            'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
            'gdh_depart' => $_POST['gdh_depart'] ?? '',
            'gdh_arrivee' => $_POST['gdh_arrivee'] ?? '',
            'nb_places_total' => $_POST['nb_places_total'] ?? '',
            'nb_places_dispo' => $_POST['nb_places_total'] ?? '', // Par défaut, toutes les places sont dispo
            'id_employe' => $_SESSION['user_id']
        ];

        // Validation
        $errors = $this->trajetModel->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/trajet/create');
        }

        // Créer le trajet
        $trajetId = $this->trajetModel->create($data);

        if ($trajetId) {
            $_SESSION['success'] = 'Trajet créé avec succès';
            $this->redirect('/');
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la création du trajet'];
            $this->redirect('/trajet/create');
        }
    }

    /**
     * Formulaire de modification d'un trajet
     * 
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->getTrajetWithDetails($id);

        if (!$trajet) {
            $_SESSION['errors'] = ['general' => 'Trajet non trouvé'];
            $this->redirect('/');
        }

        // Vérifier que l'utilisateur est l'auteur du trajet
        if ($trajet['employe_id'] != $_SESSION['user_id'] && !$this->isAdmin()) {
            $_SESSION['errors'] = ['general' => 'Vous n\'êtes pas autorisé à modifier ce trajet'];
            $this->redirect('/');
        }

        $agences = $this->agenceModel->getAllOrdered();

        $this->view('trajet/edit', [
            'trajet' => $trajet,
            'agences' => $agences
        ]);
    }

    /**
     * Mettre à jour un trajet
     * 
     * @param int $id
     * @return void
     */
    public function update(int $id): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/trajet/edit/' . $id);
        }

        $trajet = $this->trajetModel->find($id);

        if (!$trajet) {
            $_SESSION['errors'] = ['general' => 'Trajet non trouvé'];
            $this->redirect('/');
        }

        // Vérifier que l'utilisateur est l'auteur
        if ($trajet['id_employe'] != $_SESSION['user_id'] && !$this->isAdmin()) {
            $_SESSION['errors'] = ['general' => 'Non autorisé'];
            $this->redirect('/');
        }

        $data = [
            'id_agence_depart' => $_POST['id_agence_depart'] ?? '',
            'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
            'gdh_depart' => $_POST['gdh_depart'] ?? '',
            'gdh_arrivee' => $_POST['gdh_arrivee'] ?? '',
            'nb_places_total' => $_POST['nb_places_total'] ?? '',
            'nb_places_dispo' => $_POST['nb_places_dispo'] ?? ''
        ];

        // Validation
        $errors = $this->trajetModel->validate($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/trajet/edit/' . $id);
        }

        // Mettre à jour
        if ($this->trajetModel->update($id, $data)) {
            $_SESSION['success'] = 'Trajet modifié avec succès';
            $this->redirect('/');
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la modification'];
            $this->redirect('/trajet/edit/' . $id);
        }
    }

    /**
     * Supprimer un trajet
     * 
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->requireAuth();

        $trajet = $this->trajetModel->find($id);

        if (!$trajet) {
            $_SESSION['errors'] = ['general' => 'Trajet non trouvé'];
            $this->redirect('/');
        }

        // Vérifier que l'utilisateur est l'auteur
        if ($trajet['id_employe'] != $_SESSION['user_id'] && !$this->isAdmin()) {
            $_SESSION['errors'] = ['general' => 'Non autorisé'];
            $this->redirect('/');
        }

        if ($this->trajetModel->delete($id)) {
            $_SESSION['success'] = 'Trajet supprimé avec succès';
        } else {
            $_SESSION['errors'] = ['general' => 'Erreur lors de la suppression'];
        }

        $this->redirect('/');
    }
}