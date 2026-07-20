<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFraisBaremesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type_operation' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'montant_min' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'montant_max' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'frais' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('frais_baremes');
    }

    public function down()
    {
        $this->forge->dropTable('frais_baremes');
    }
}