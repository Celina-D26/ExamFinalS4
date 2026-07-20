<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrefixesTable extends Migration
{
    public function up()
    {
        // Table des préfixes
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'prefix' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
                'unique'     => true,
            ],
            'operateur' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'pays' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'commission' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
                'null'       => false,
                'comment'    => 'Commission en % pour les transferts vers cet opérateur',
            ],
            'est_actif' => [
                'type'       => 'INTEGER',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
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
        $this->forge->addKey('prefix');
        $this->forge->addKey('operateur');
        $this->forge->createTable('prefixes', true);
        
        echo "✅ Table 'prefixes' créée avec succès !\n";
    }

    public function down()
    {
        $this->forge->dropTable('prefixes', true);
        echo "✅ Table 'prefixes' supprimée avec succès !\n";
    }
}