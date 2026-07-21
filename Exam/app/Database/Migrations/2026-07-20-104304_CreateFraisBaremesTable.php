<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFraisBaremesTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('frais_baremes', true);
        
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type_operation' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'montant_min' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'montant_max' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'frais' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
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
        $this->forge->addKey('type_operation');
        $this->forge->createTable('frais_baremes');
        
        echo "✅ Table 'frais_baremes' créée avec succès !\n";
    }

    public function down()
    {
        $this->forge->dropTable('frais_baremes', true);
        echo "✅ Table 'frais_baremes' supprimée !\n";
    }
}