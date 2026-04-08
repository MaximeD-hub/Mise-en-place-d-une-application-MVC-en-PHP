<?php

namespace App\Models;

/**
 * Modèle Employe
 * 
 * @package App\Models
 */
class Employe extends Model
{
    /**
     * Nom de la table
     * 
     * @var string
     */
    protected string $table = 'employe';

    /**
     * Clé primaire
     * 
     * @var string
     */
    protected string $primaryKey = 'id_employe';

    /**
     * Trouver un employé par email
     * 
     * @param string $email
     * @return array|false
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->queryOne($sql, [$email]);
    }

    /**
     * Vérifier les identifiants de connexion
     * 
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function authenticate(string $email, string $password)
    {
        $employe = $this->findByEmail($email);
        
        if ($employe && password_verify($password, $employe['mot_de_passe'])) {
            return $employe;
        }
        
        return false;
    }

    /**
     * Mettre à jour le mot de passe d'un employé
     * 
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function updatePassword(int $id, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->update($id, ['mot_de_passe' => $hashedPassword]);
    }

    /**
     * Récupérer tous les employés triés par nom
     * 
     * @return array
     */
    public function getAllOrdered(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY nom, prenom";
        return $this->query($sql);
    }

    /**
     * Vérifier si un email existe déjà
     * 
     * @param string $email
     * @param int|null $excludeId ID à exclure (pour la mise à jour)
     * @return bool
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ? AND {$this->primaryKey} != ?";
            $result = $this->queryOne($sql, [$email, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
            $result = $this->queryOne($sql, [$email]);
        }
        
        return $result['count'] > 0;
    }
}