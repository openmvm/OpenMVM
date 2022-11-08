<?php

namespace Main\Admin\Models\Marketplace;

use CodeIgniter\Model;

class Seller_Model extends Model
{
    protected $table = 'seller';
    protected $primaryKey = 'seller_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['seller_id', 'customer_id', 'store_name', 'store_description', 'date_added', 'status'];
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
        $this->text = new \App\Libraries\Text();
        // Helpers
        helper('date');
    }

    public function getSellers($data = [])
    {
        $builder = $this->db->table('seller');

        if (!empty($data['filter_name'])) {
            //$builder->like('store_name', $data['filter_name']);
            $builder->where('MATCH (store_name) AGAINST ("' . $data['filter_name'] . '" IN BOOLEAN MODE)', null, false);
        }

        $seller_query = $builder->get();

        $sellers = [];

        foreach ($seller_query->getResult() as $result) {
            $sellers[] = [
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'store_name' => $result->store_name,
                'store_description' => $result->store_description,
                'slug' => $result->slug,
                'logo' => $result->logo,
                'cover' => $result->cover,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
                'status' => $result->status,
                ];
        }

        return $sellers;
    }

    public function getSeller($seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller');
        
        $builder->where('seller_id', $seller_id);

        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }

        $seller_query = $builder->get();

        $seller = [];

        if ($row = $seller_query->getRow()) {
            $seller = [
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'store_name' => $row->store_name,
                'store_description' => $row->store_description,
                'slug' => $row->slug,
                'logo' => $row->logo,
                'cover' => $row->cover,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
            ];
        }

        return $seller;
    }
}