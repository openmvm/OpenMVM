<?php

namespace App\Models\Marketplace\Product;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_id', 'seller_id', 'customer_id', 'category_id_path', 'date_added', 'date_modified', 'status'];
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

    public function getProducts($data = [])
    {
        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $builder = $this->db->table('category_path cp');
 
                $builder->join('product_to_category p2c', 'cp.category_id = p2c.category_id', 'left');
            } else {
                $builder = $this->db->table('product_to_category p2c');
            }

            $builder->join('product p', 'p2c.product_id = p.product_id', 'left');
        } else {
            $builder = $this->db->table('product p');
        }

        $builder->select("p.product_id");

        $builder->join('product_description pd', 'p.product_id = pd.product_id', 'left');

        $builder->where('pd.language_id', $this->language->getCurrentId());
        $builder->where('p.status', 1);

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $builder->where('cp.path_id', $data['filter_category_id']);
            } else {
                $builder->where('p2c.category_id', $data['filter_category_id']);
            }
        }

        if (!empty($data['filter_seller_id'])) {
            $builder->where('p.seller_id', $data['filter_seller_id']);
        }

        if (!empty($data['filter_name'])) {
            $builder->like('pd.name', $data['filter_name']);
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

        $builder->distinct("*, pd.name AS name");
        
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
                'price' => $row->price,
                'main_image' => $row->main_image,
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

    public function getProductDescriptions($product_id)
    {
        $builder = $this->db->table('product_description');
        
        $builder->where('product_id', $product_id);

        $product_description_query = $builder->get();

        $product_descriptions = [];

        foreach ($product_description_query->getResult() as $result) {
            $product_descriptions[$result->language_id] = [
                'name' => $result->name,
                'description' => $result->description,
                'meta_title' => $result->meta_title,
                'meta_description' => $result->meta_description,
                'meta_keywords' => $result->meta_keywords,
                'slug' => $result->slug,
            ];
        }

        return $product_descriptions;
    }

    public function getProductDescription($product_id)
    {
        $builder = $this->db->table('product_description');
        
        $builder->where('product_id', $product_id);
        $builder->where('language_id', $this->language->getCurrentId());

        $product_description_query = $builder->get();

        $product_description = [];

        if ($row = $product_description_query->getRow()) {
            $product_description = [
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
                'slug' => $row->slug,
            ];
        }

        return $product_description;
    }
}