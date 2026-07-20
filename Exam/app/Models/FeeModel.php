<?php

namespace App\Models;

use CodeIgniter\Model;

class FeeModel extends Model
{
    protected $table = 'fees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operation_type', 'min_amount', 'max_amount', 'fee_type', 'fee_value', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    public function getFee($operationType, $amount)
    {
        $fee = $this->where('operation_type', $operationType)
                    ->where('min_amount <=', $amount)
                    ->where('max_amount >=', $amount)
                    ->where('is_active', 1)
                    ->first();
        
        return $fee;
    }

    public function calculateFee($operationType, $amount)
    {
        $fee = $this->getFee($operationType, $amount);
        
        if (!$fee) {
            return 0;
        }
        
        if ($fee['fee_type'] == 'fixed') {
            return $fee['fee_value'];
        } else {
            return ($amount * $fee['fee_value']) / 100;
        }
    }

    public function getAllFeesGrouped()
    {
        $fees = $this->where('is_active', 1)
                     ->orderBy('operation_type', 'ASC')
                     ->orderBy('min_amount', 'ASC')
                     ->findAll();
        
        $grouped = [];
        foreach ($fees as $fee) {
            $grouped[$fee['operation_type']][] = $fee;
        }
        
        return $grouped;
    }
}