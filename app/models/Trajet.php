<?php

namespace App\Models;

/**
 * Modèle Trajet
 * 
 * @package App\Models
 */
class Trajet extends Model
{
    /**
     * Nom de la table
     * 
     * @var string
     */
    protected string $table = 'trajet';

    /**
     * Clé primaire
     * 
     * @var string
     */
    protected string $primaryKey = 'id_trajet';

    /**
     * Récupérer les trajets disponibles (avec places et futurs)
     * 
     * @return array
     */
    public function getAvailableTrajets(): array
    {
        $sql = "SELECT t.*, 
                       ad.nom as agence_depart_nom, 
                       aa.nom as agence_arrivee_nom,
                       e.nom as employe_nom, 
                       e.prenom as employe_prenom,
                       e.email as employe_email,
                       e.telephone as employe_telephone
                FROM {$this->table} t
                INNER JOIN agence ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN employe e ON t.id_employe = e.id_employe
                WHERE t.nb_places_dispo > 0 
                AND t.gdh_depart > NOW()
                ORDER BY t.gdh_depart ASC";
        
        return $this->query($sql);
    }

    /**
     * Récupérer un trajet avec tous ses détails
     * 
     * @param int $id
     * @return array|false
     */
    public function getTrajetWithDetails(int $id)
    {
        $sql = "SELECT t.*, 
                       ad.nom as agence_depart_nom, 
                       aa.nom as agence_arrivee_nom,
                       e.nom as employe_nom, 
                       e.prenom as employe_prenom,
                       e.email as employe_email,
                       e.telephone as employe_telephone,
                       e.id_employe as employe_id
                FROM {$this->table} t
                INNER JOIN agence ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN employe e ON t.id_employe = e.id_employe
                WHERE t.{$this->primaryKey} = ?";
        
        return $this->queryOne($sql, [$id]);
    }

    /**
     * Récupérer les trajets d'un employé
     * 
     * @param int $employeId
     * @return array
     */
    public function getTrajetsByEmploye(int $employeId): array
    {
        $sql = "SELECT t.*, 
                       ad.nom as agence_depart_nom, 
                       aa.nom as agence_arrivee_nom
                FROM {$this->table} t
                INNER JOIN agence ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                WHERE t.id_employe = ?
                ORDER BY t.gdh_depart DESC";
        
        return $this->query($sql, [$employeId]);
    }

    /**
     * Récupérer tous les trajets (admin)
     * 
     * @return array
     */
    public function getAllWithDetails(): array
    {
        $sql = "SELECT t.*, 
                       ad.nom as agence_depart_nom, 
                       aa.nom as agence_arrivee_nom,
                       e.nom as employe_nom, 
                       e.prenom as employe_prenom
                FROM {$this->table} t
                INNER JOIN agence ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN employe e ON t.id_employe = e.id_employe
                ORDER BY t.gdh_depart DESC";
        
        return $this->query($sql);
    }

    /**
     * Valider les données d'un trajet
     * 
     * @param array $data
     * @return array Tableau d'erreurs (vide si valide)
     */
    public function validate(array $data): array
    {
        $errors = [];

        // Vérifier les agences
        if (empty($data['id_agence_depart'])) {
            $errors['id_agence_depart'] = 'L\'agence de départ est requise';
        }

        if (empty($data['id_agence_arrivee'])) {
            $errors['id_agence_arrivee'] = 'L\'agence d\'arrivée est requise';
        }

        if (!empty($data['id_agence_depart']) && !empty($data['id_agence_arrivee']) 
            && $data['id_agence_depart'] == $data['id_agence_arrivee']) {
            $errors['id_agence_arrivee'] = 'L\'agence d\'arrivée doit être différente de l\'agence de départ';
        }

        // Vérifier les dates
        if (empty($data['gdh_depart'])) {
            $errors['gdh_depart'] = 'La date et heure de départ sont requises';
        }

        if (empty($data['gdh_arrivee'])) {
            $errors['gdh_arrivee'] = 'La date et heure d\'arrivée sont requises';
        }

        if (!empty($data['gdh_depart']) && !empty($data['gdh_arrivee'])) {
            $depart = strtotime($data['gdh_depart']);
            $arrivee = strtotime($data['gdh_arrivee']);
            
            if ($arrivee <= $depart) {
                $errors['gdh_arrivee'] = 'La date d\'arrivée doit être après la date de départ';
            }

            if ($depart < time()) {
                $errors['gdh_depart'] = 'La date de départ doit être dans le futur';
            }
        }

        // Vérifier le nombre de places
        if (empty($data['nb_places_total']) || $data['nb_places_total'] < 1) {
            $errors['nb_places_total'] = 'Le nombre de places doit être au moins 1';
        }

        if (!empty($data['nb_places_total']) && $data['nb_places_total'] > 8) {
            $errors['nb_places_total'] = 'Le nombre de places ne peut pas dépasser 8';
        }

        return $errors;
    }
}