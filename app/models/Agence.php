<?php

namespace App\Models;

/**
 * Modèle Agence
 * 
 * @package App\Models
 */
class Agence extends Model
{
    /**
     * Nom de la table
     * 
     * @var string
     */
    protected string $table = 'agence';

    /**
     * Clé primaire
     * 
     * @var string
     */
    protected string $primaryKey = 'id_agence';

    /**
     * Récupérer toutes les agences triées par nom
     * 
     * @return array
     */
    public function getAllOrdered(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY nom";
        return $this->query($sql);
    }

    /**
     * Vérifier si une agence existe par nom
     * 
     * @param string $nom
     * @param int|null $excludeId
     * @return bool
     */
    public function nameExists(string $nom, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE nom = ? AND {$this->primaryKey} != ?";
            $result = $this->queryOne($sql, [$nom, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE nom = ?";
            $result = $this->queryOne($sql, [$nom]);
        }
        
        return $result['count'] > 0;
    }

    /**
     * Compter le nombre de trajets associés à une agence
     * 
     * @param int $id
     * @return int
     */
    public function countTrajets(int $id): int
    {
        $sql = "SELECT COUNT(*) as count FROM trajet 
                WHERE id_agence_depart = ? OR id_agence_arrivee = ?";
        $result = $this->queryOne($sql, [$id, $id]);
        return (int) $result['count'];
    }
}