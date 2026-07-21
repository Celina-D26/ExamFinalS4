<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommissionToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'commission_inter_operateur' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'null'       => false,
                'after'      => 'frais_appliques',
            ],
            'operateur_destinataire' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'commission_inter_operateur',
            ],
        ]);
        
        echo "✅ Colonnes ajoutées à la table 'transactions' !\n";
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'commission_inter_operateur');
        $this->forge->dropColumn('transactions', 'operateur_destinataire');
        echo "✅ Colonnes supprimées de la table 'transactions' !\n";
    }
}