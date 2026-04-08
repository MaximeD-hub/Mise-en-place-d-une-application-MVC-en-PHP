<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle de base
 * 
 * @package App\Models
 */
abstract class Model
{
    /**
     * Instance PDO
     * 
     * @var PDO
     */
    protected PDO $db;

    /**
     * Nom de la table
     * 
     * @var string
     */
    protected string $table;

    /**
     * Clé primaire
     * 
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les enregistrements
     * 
     * @return array
     */
    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    /**
     * Trouver un enregistrement par ID
     * 
     * @param int $id
     * @return array|false
     */
    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Créer un nouvel enregistrement
     * 
     * @param array $data
     * @return int|false ID du nouvel enregistrement
     */
    public function create(array $data)
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($fields) - 1) . '?';
        
        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($values)) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Mettre à jour un enregistrement
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $values[] = $id;
        
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Supprimer un enregistrement
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Exécuter une requête personnalisée
     * 
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Exécuter une requête qui retourne une seule ligne
     * 
     * @param string $sql
     * @param array $params
     * @return array|false
     */
    protected function queryOne(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}