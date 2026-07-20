<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFeesTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('fees', true);
        
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'operation_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'min_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'max_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'fee_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'percentage',
            ],
            'fee_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => 1,
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
        $this->forge->addKey('operation_type');
        $this->forge->createTable('fees');
        
        echo "✅ Table 'fees' créée avec succès !\n";
    }

    public function down()
    {
        $this->forge->dropTable('fees', true);
        echo "✅ Table 'fees' supprimée avec succès !\n";
    }
}