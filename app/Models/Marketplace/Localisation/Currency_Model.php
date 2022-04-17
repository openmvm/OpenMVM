<?php

namespace App\Models\Marketplace\Localisation;

use CodeIgniter\Model;

class Currency_Model extends Model
{
    protected $table = 'currency';
    protected $primaryKey = 'currency_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getCurrencies($data = [])
    {
        $builder = $this->db->table('currency');

        $currency_query = $builder->get();

        $currencies = [];

        foreach ($currency_query->getResult() as $result) {
            $currencies[] = [
                'currency_id' => $result->currency_id,
                'name' => $result->name,
                'code' => $result->code,
                'symbol_left' => $result->symbol_left,
                'symbol_right' => $result->symbol_right,
                'decimal_place' => $result->decimal_place,
                'value' => $result->value,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $currencies;
    }

    public function getCurrency($currency_id)
    {
        $builder = $this->db->table('currency');
        
        $builder->where('currency_id', $currency_id);

        $currency_query = $builder->get();

        $currency = [];

        if ($row = $currency_query->getRow()) {
            $currency = [
                'currency_id' => $row->currency_id,
                'name' => $row->name,
                'code' => $row->code,
                'symbol_left' => $row->symbol_left,
                'symbol_right' => $row->symbol_right,
                'decimal_place' => $row->decimal_place,
                'value' => $row->value,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $currency;
    }
}