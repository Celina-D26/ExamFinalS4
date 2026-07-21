<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
    'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => true,
        'auto_increment' => true,
    ],

    'type_operation' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
    ],

    'montant' => [
        'type' => 'DECIMAL',
        'constraint' => '12,2',
    ],

    'frais_appliques' => [
        'type' => 'DECIMAL',
        'constraint' => '12,2',
        'default' => 0,
    ],

    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('operations');
    }

    public function down()
    {
        $this->forge->dropTable('operations');
    }
}