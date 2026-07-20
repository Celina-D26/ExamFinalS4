<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Exécuter tous les seeders dans l'ordre
        echo "🚀 Début de l'insertion des données...\n";
        echo "----------------------------------------\n";
        
        $this->call('UserSeeder');
        $this->call('ClientSeeder');
        $this->call('PrefixeSeeder');
        $this->call('FraisSeeder');
        $this->call('TransactionSeeder');
        
        echo "----------------------------------------\n";
        echo "✅ Tous les seeders ont été exécutés avec succès !\n";
    }
}