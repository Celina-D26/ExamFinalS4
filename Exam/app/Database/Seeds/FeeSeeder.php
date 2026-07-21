<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FeeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('fees')->truncate();
        
        $fees = [
            // Frais de retrait
            ['operation_type' => 'withdrawal', 'min_amount' => 100, 'max_amount' => 1000, 'fee_type' => 'fixed', 'fee_value' => 50],
            ['operation_type' => 'withdrawal', 'min_amount' => 1001, 'max_amount' => 5000, 'fee_type' => 'percentage', 'fee_value' => 1.5],
            ['operation_type' => 'withdrawal', 'min_amount' => 5001, 'max_amount' => 10000, 'fee_type' => 'percentage', 'fee_value' => 1.2],
            ['operation_type' => 'withdrawal', 'min_amount' => 10001, 'max_amount' => 25000, 'fee_type' => 'percentage', 'fee_value' => 1.0],
            ['operation_type' => 'withdrawal', 'min_amount' => 25001, 'max_amount' => 50000, 'fee_type' => 'percentage', 'fee_value' => 0.8],
            ['operation_type' => 'withdrawal', 'min_amount' => 50001, 'max_amount' => 100000, 'fee_type' => 'percentage', 'fee_value' => 0.7],
            ['operation_type' => 'withdrawal', 'min_amount' => 100001, 'max_amount' => 250000, 'fee_type' => 'percentage', 'fee_value' => 0.6],
            ['operation_type' => 'withdrawal', 'min_amount' => 250001, 'max_amount' => 500000, 'fee_type' => 'percentage', 'fee_value' => 0.5],
            ['operation_type' => 'withdrawal', 'min_amount' => 500001, 'max_amount' => 1000000, 'fee_type' => 'percentage', 'fee_value' => 0.4],
            ['operation_type' => 'withdrawal', 'min_amount' => 1000001, 'max_amount' => 2000000, 'fee_type' => 'percentage', 'fee_value' => 0.3],
            
            // Frais de transfert
            ['operation_type' => 'transfer', 'min_amount' => 100, 'max_amount' => 1000, 'fee_type' => 'fixed', 'fee_value' => 25],
            ['operation_type' => 'transfer', 'min_amount' => 1001, 'max_amount' => 5000, 'fee_type' => 'percentage', 'fee_value' => 1.0],
            ['operation_type' => 'transfer', 'min_amount' => 5001, 'max_amount' => 10000, 'fee_type' => 'percentage', 'fee_value' => 0.8],
            ['operation_type' => 'transfer', 'min_amount' => 10001, 'max_amount' => 25000, 'fee_type' => 'percentage', 'fee_value' => 0.7],
            ['operation_type' => 'transfer', 'min_amount' => 25001, 'max_amount' => 50000, 'fee_type' => 'percentage', 'fee_value' => 0.6],
            ['operation_type' => 'transfer', 'min_amount' => 50001, 'max_amount' => 100000, 'fee_type' => 'percentage', 'fee_value' => 0.5],
            ['operation_type' => 'transfer', 'min_amount' => 100001, 'max_amount' => 250000, 'fee_type' => 'percentage', 'fee_value' => 0.4],
            ['operation_type' => 'transfer', 'min_amount' => 250001, 'max_amount' => 500000, 'fee_type' => 'percentage', 'fee_value' => 0.3],
            ['operation_type' => 'transfer', 'min_amount' => 500001, 'max_amount' => 1000000, 'fee_type' => 'percentage', 'fee_value' => 0.25],
            ['operation_type' => 'transfer', 'min_amount' => 1000001, 'max_amount' => 2000000, 'fee_type' => 'percentage', 'fee_value' => 0.2],
        ];

        foreach ($fees as $fee) {
            $fee['created_at'] = date('Y-m-d H:i:s');
            $fee['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('fees')->insert($fee);
        }
        
        echo "✅ Barème des frais créé avec succès !\n";
    }
}