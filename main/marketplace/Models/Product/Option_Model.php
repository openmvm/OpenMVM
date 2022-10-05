<?php

namespace Main\Marketplace\Models\Product;

use CodeIgniter\Model;

class Option_Model extends Model
{
    protected $table = 'option';
    protected $primaryKey = 'option_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['option_id', 'seller_id', 'customer_id'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->text = new \App\Libraries\Text();
        // Helpers
        helper('date');
    }

    public function getOptionValue($option_id, $option_value_id)
    {
        $builder = $this->db->table('option_value ov');
        $builder->join('option_value_description ovd', 'ov.option_value_id = ovd.option_value_id', 'left');
        
        $builder->where('ov.option_id', $option_id);
        $builder->where('ov.option_value_id', $option_value_id);
        $builder->where('ovd.language_id', $this->language->getCurrentId());

        $option_query = $builder->get();

        $option = [];

        if ($row = $option_query->getRow()) {
            $option = [
                'option_value_id' => $row->option_value_id,
                'option_id' => $row->option_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'name' => $row->name,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $option;
    }
}