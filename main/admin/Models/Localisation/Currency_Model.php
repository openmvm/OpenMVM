<?php

namespace Main\Admin\Models\Localisation;

use CodeIgniter\Model;

class Currency_Model extends Model
{
    protected $table = 'currency';
    protected $primaryKey = 'currency_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'code', 'value', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addCurrency($data = [])
    {
        $builder = $this->db->table('currency');

        $insert_data = [
            'name' => $data['name'],
            'code' => $data['code'],
            'symbol_left' => $data['symbol_left'],
            'symbol_right' => $data['symbol_right'],
            'decimal_place' => $data['decimal_place'],
            'value' => $data['value'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editCurrency($currency_id, $data = [])
    {
        $builder = $this->db->table('currency');

        $update_data = [
            'name' => $data['name'],
            'code' => $data['code'],
            'symbol_left' => $data['symbol_left'],
            'symbol_right' => $data['symbol_right'],
            'decimal_place' => $data['decimal_place'],
            'value' => $data['value'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('currency_id', $currency_id);
        $builder->update($update_data);

        return $currency_id;
    }

    public function deleteCurrency($currency_id)
    {
        $builder = $this->db->table('currency');

        $builder->where('currency_id', $currency_id);
        $builder->delete();
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

    public function updateValue($currency_id, $value)
    {
        $builder = $this->db->table('currency');

        $update_data = [
            'value' => $value,
        ];

        $builder->where('currency_id', $currency_id);
        $builder->update($update_data);

        return $currency_id;
    }
}