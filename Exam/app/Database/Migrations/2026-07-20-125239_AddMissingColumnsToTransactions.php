<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingColumnsToTransactions extends Migration
{
    public function up()
    {
        // Vérifier si les colonnes existent déjà
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('transactions');
        $existingColumns = array_column($fields, 'name');
        
        $columnsToAdd = [];
        
        if (!in_array('commission', $existingColumns)) {
            $columnsToAdd['commission'] = [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'after' => 'frais_appliques',
            ];
        }
        
        if (!in_array('include_fees', $existingColumns)) {
            $columnsToAdd['include_fees'] = [
                'type' => 'BOOLEAN',
                'default' => 0,
                'after' => 'commission',
            ];
        }
        
        if (!in_array('is_multiple', $existingColumns)) {
            $columnsToAdd['is_multiple'] = [
                'type' => 'BOOLEAN',
                'default' => 0,
                'after' => 'include_fees',
            ];
        }
        
        if (!in_array('destinations', $existingColumns)) {
            $columnsToAdd['destinations'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'is_multiple',
            ];
        }
        
        if (!in_array('operateur_id', $existingColumns)) {
            $columnsToAdd['operateur_id'] = [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'destinations',
            ];
        }
        
        if (!empty($columnsToAdd)) {
            $this->forge->addColumn('transactions', $columnsToAdd);
            echo "✅ Colonnes ajoutées à la table 'transactions' !\n";
        } else {
            echo "ℹ️ Toutes les colonnes existent déjà.\n";
        }
    }

    public function down()
    {
        // Ne pas supprimer les colonnes pour éviter la perte de données
        echo "ℹ️ Les colonnes ne seront pas supprimées.\n";
    }
}