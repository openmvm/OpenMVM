<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

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
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
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
            'timezone' => $data['timezone'],
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
            'timezone' => $data['timezone'],
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
                'timezone' => $result->timezone,
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
                'timezone' => $row->timezone,
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

    public function getProducts($data = [], $seller_id)
    {
        if (!empty($data['filter_seller_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $builder = $this->db->table('seller_category_path cp');
 
                $builder->join('product_to_seller_category p2c', 'cp.seller_category_id = p2c.seller_category_id', 'left');
            } else {
                $builder = $this->db->table('product_to_seller_category p2c');
            }

            $builder->join('product p', 'p2c.product_id = p.product_id', 'left');
        } else {
            $builder = $this->db->table('product p');
        }

        $builder->select("p.product_id");

        $builder->select("(SELECT price FROM " . $this->db->getPrefix() . "product_special ps WHERE ps.product_id = p.product_id AND (ps.date_start < '" . new Time('now') . "' AND ps.date_end > '" . new Time('now') . "') ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special");

        $builder->join('product_description pd', 'p.product_id = pd.product_id', 'left');

        $builder->where('pd.language_id', $this->language->getCurrentId());
        $builder->where('p.seller_id', $seller_id);
        $builder->where('p.status', 1);

        if (!empty($data['filter_seller_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $builder->where('cp.path_id', $data['filter_seller_category_id']);
            } else {
                $builder->where('p2c.seller_category_id', $data['filter_seller_category_id']);
            }
        }

        if (!empty($data['filter_seller_id'])) {
            $builder->where('p.seller_id', $data['filter_seller_id']);
        }

        if (!empty($data['filter_name'])) {
            //$builder->like('pd.name', $data['filter_name']);
            $builder->where('MATCH (pd.name) AGAINST ("' . $data['filter_name'] . '" IN BOOLEAN MODE)', null, false);
        }

        $product_query = $builder->get();

        $product_data = [];

        foreach ($product_query->getResult() as $result) {
            $product_data[$result->product_id] = $this->getProduct($result->product_id);
        }

        return $product_data;
    }

    public function getProduct($product_id)
    {
        $builder = $this->db->table('product p');

        $builder->select("*, pd.name AS name, (SELECT price FROM " . $this->db->getPrefix() . "product_special ps WHERE ps.product_id = p.product_id AND (ps.date_start < '" . new Time('now') . "' AND ps.date_end > '" . new Time('now') . "') ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special");
        
        $builder->join('product_description pd', 'p.product_id = pd.product_id', 'left');

        $builder->where('p.product_id', $product_id);
        $builder->where('pd.language_id', $this->language->getCurrentId());
        $builder->where('p.status', 1);

        $product_query = $builder->get();

        $product = [];

        if ($row = $product_query->getRow()) {
            $product = [
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'category_id_path' => $row->category_id_path,
                'product_option' => $row->product_option,
                'product_variant_special' => $row->product_variant_special,
                'product_variant_discount' => $row->product_variant_discount,
                'price' => $row->price,
                'special' => $row->special,
                'quantity' => $row->quantity,
                'minimum_purchase' => $row->minimum_purchase,
                'weight' => $row->quantity,
                'weight_class_id' => $row->weight_class_id,
                'main_image' => $row->main_image,
                'sku' => $row->sku,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
                'slug' => $row->slug,
            ];
        }

        return $product;
    }
}