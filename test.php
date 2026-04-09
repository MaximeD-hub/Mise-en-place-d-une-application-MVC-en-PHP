<?php
require_once __DIR__ . '/config/config.php';

use App\Core\Database;
use App\Models\Agence;
use App\Models\Employe;

try {
    echo "<h1>Test de connexion</h1>";
    
    // Test 1: Connexion à la base
    echo "<h2>1. Test de connexion à la base de données</h2>";
    $db = Database::getInstance();
    echo "✅ Connexion réussie !<br><br>";
    
    // Test 2: Récupérer les agences
    echo "<h2>2. Test du modèle Agence</h2>";
    $agenceModel = new Agence();
    $agences = $agenceModel->getAllOrdered();
    echo "Nombre d'agences : " . count($agences) . "<br>";
    foreach ($agences as $agence) {
        echo "- " . $agence['nom'] . "<br>";
    }
    echo "<br>";
    
    // Test 3: Récupérer les employés
    echo "<h2>3. Test du modèle Employe</h2>";
    $employeModel = new Employe();
    $employes = $employeModel->getAllOrdered();
    echo "Nombre d'employés : " . count($employes) . "<br>";
    foreach (array_slice($employes, 0, 5) as $employe) {
        echo "- " . $employe['prenom'] . " " . $employe['nom'] . " (" . $employe['email'] . ")<br>";
    }
    echo "<br>";
    
    // Test 4: Créer des mots de passe hashés pour les employés
    echo "<h2>4. Mise à jour des mots de passe</h2>";
    echo "⚠️ Les mots de passe sont actuellement vides. Voulez-vous les générer ?<br>";
    echo "Décommentez la section ci-dessous pour générer les mots de passe.<br><br>";
    
    /*
    // Générer un mot de passe pour chaque employé
    foreach ($employes as $employe) {
        // Mot de passe par défaut : Password123!
        $employeModel->updatePassword($employe['id_employe'], 'Password123!');
    }
    
    // Créer un compte admin
    $admin = $employeModel->findByEmail('admin@klaxon.fr');
    if (!$admin) {
        $employeModel->create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@klaxon.fr',
            'telephone' => '0600000000',
            'mot_de_passe' => password_hash('Admin123!', PASSWORD_DEFAULT),
            'role' => 'admin'
        ]);
        echo "✅ Compte admin créé (admin@klaxon.fr / Admin123!)<br>";
    }
    
    echo "✅ Mots de passe mis à jour !<br>";
    */
    
    echo "<h2>✅ Tous les tests sont passés !</h2>";
    
} catch (Exception $e) {
    echo "<h2>❌ Erreur</h2>";
    echo $e->getMessage();
}