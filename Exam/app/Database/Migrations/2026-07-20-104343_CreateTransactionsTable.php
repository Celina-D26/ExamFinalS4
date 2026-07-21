<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('transactions', true);
        
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'type_operation' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'montant' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'frais_appliques' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'montant_net' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
            ],
            'solde_apres' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
            ],
            'reference' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'completed',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('client_id');
        $this->forge->addKey('reference');
        $this->forge->createTable('transactions');
        
        echo "✅ Table 'transactions' créée avec succès !\n";
    }

    public function down()
    {
        $this->forge->dropTable('transactions', true);
        echo "✅ Table 'transactions' supprimée !\n";
    }
}