<?php

namespace App\Models\Marketplace\Seller;

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

    public function addSeller($data = [])
    {
        $seller_insert_builder = $this->db->table('seller');

        $seller_insert_data = [
            'customer_id' => $this->customer->getId(),
            'store_name' => $data['store_name'],
            'store_description' => $data['store_description'],
            'slug' => $this->text->slugify($data['store_name']),
            'date_added' => now(),
            'status' => 1,
        ];
        
        $seller_insert_builder->insert($seller_insert_data);

        $seller_id = $this->db->insertID();

        $seller_update_builder = $this->db->table('seller');

        $seller_update_data = [
            'logo' => $data['logo'],
            'cover' => $data['cover'],
        ];

        $seller_update_builder->where('seller_id', $seller_id);
        $seller_update_builder->where('customer_id', $this->customer->getId());
        $seller_update_builder->update($seller_update_data);

        return $seller_id;
    }

    public function editSeller($seller_id, $customer_id, $data = [])
    {
        $seller_update_builder = $this->db->table('seller');

        $seller_update_data = [
            'store_name' => $data['store_name'],
            'store_description' => $data['store_description'],
            'slug' => $this->text->slugify($data['store_name']),
            'date_modified' => now(),
        ];

        $seller_update_builder->where('seller_id', $seller_id);
        $seller_update_builder->where('customer_id', $customer_id);
        $seller_update_builder->update($seller_update_data);

        $seller_update_builder = $this->db->table('seller');

        $seller_update_data = [
            'logo' => $data['logo'],
            'cover' => $data['cover'],
        ];

        $seller_update_builder->where('seller_id', $seller_id);
        $seller_update_builder->where('customer_id', $customer_id);
        $seller_update_builder->update($seller_update_data);

        return $seller_id;
    }

    public function deleteSeller($seller_id, $customer_id)
    {
        $builder = $this->db->table('seller');

        $builder->where('seller_id', $seller_id);
        $builder->where('customer_id', $customer_id);
        $builder->delete();
    }

    public function getSellers($data = [])
    {
        $builder = $this->db->table('seller');

        $seller_query = $builder->get();

        $sellers = [];

        foreach ($seller_query->getResult() as $result) {
            $sellers[] = [
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