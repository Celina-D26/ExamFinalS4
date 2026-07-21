<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToTransactionsTable extends Migration
{
    public function up()
    {
        // Ajouter les colonnes pour la Version 2
        $fields = [
            'include_fees' => [
                'type' => 'BOOLEAN',
                'default' => 0,
                'after' => 'montant',
            ],
            'is_multiple' => [
                'type' => 'BOOLEAN',
                'default' => 0,
                'after' => 'include_fees',
            ],
            'destinations' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON des destinations pour envoi multiple',
                'after' => 'is_multiple',
            ],
            'operateur_id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'destinations',
            ],
            'commission' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'after' => 'frais_appliques',
            ],
        ];

        $this->forge->addColumn('transactions', $fields);
        $this->forge->addForeignKey('operateur_id', 'operateurs', 'id', 'SET NULL', 'CASCADE');
        
        echo "✅ Colonnes ajoutées à la table 'transactions' !\n";
    }

    public function down()
    {
        $fields = ['include_fees', 'is_multiple', 'destinations', 'operateur_id', 'commission'];
        $this->forge->dropColumn('transactions', $fields);
        
        echo "✅ Colonnes supprimées de la table 'transactions' !\n";
    }

}
