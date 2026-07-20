<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestDB extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            echo "<h1>🔍 Test de la base de données</h1>";
            
            if ($db->tableExists('users')) {
                echo "<p style='color:green;'>✅ La table 'users' existe</p>";
                
                $query = $db->query("SELECT * FROM users");
                $users = $query->getResultArray();
                
                echo "<h2>📊 " . count($users) . " utilisateurs trouvés</h2>";
                
                echo "<table border='1' style='border-collapse:collapse;padding:10px;'>";
                echo "<tr><th>ID</th><th>Nom</th><th>Téléphone</th><th>Email</th></tr>";
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['username'] . "</td>";
                    echo "<td>" . $user['phone_number'] . "</td>";
                    echo "<td>" . ($user['email'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color:red;'>❌ La table 'users' n'existe pas !</p>";
                echo "<p>Exécutez : php spark migrate</p>";
            }
            
        } catch (\Exception $e) {
            echo "<p style='color:red;'>❌ Erreur : " . $e->getMessage() . "</p>";
        }
    }
}