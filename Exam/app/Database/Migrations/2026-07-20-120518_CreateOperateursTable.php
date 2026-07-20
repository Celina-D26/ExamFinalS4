<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperateursTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('operateurs', true);
        
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'prefixes' => [
                'type' => 'TEXT',
                'comment' => 'JSON des préfixes (ex: ["032","031"])',
            ],
            'commission_pourcentage' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'is_other' => [
                'type' => 'BOOLEAN',
                'default' => 0,
                'comment' => '1 pour autres opérateurs',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
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
        $this->forge->createTable('operateurs');
        
        echo "✅ Table 'operateurs' créée avec succès !\n";
    }

    public function down()
    {
        $this->forge->dropTable('operateurs', true);
        echo "✅ Table 'operateurs' supprimée !\n";
    }
}