<?php

namespace App\Models\Marketplace\Seller;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_id', 'seller_id', 'customer_id', 'category_id_path', 'price', 'weight', 'weight_class_id', 'date_added', 'date_modified', 'status'];
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

    public function addProduct($data = [])
    {
        $product_insert_builder = $this->db->table('product');

        $product_insert_data = [
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'category_id_path' => $data['category_id_path'],
            'price' => (float)$data['price'],
            'weight' => $data['weight'],
            'weight_class_id' => $data['weight_class_id'],
            'date_added' => now(),
            'status' => $data['status'],
        ];
        
        $product_insert_builder->insert($product_insert_data);

        $product_id = $this->db->insertID();

        // Main image
        if (!empty($data['main_image'])) {
            $product_update_builder = $this->db->table('product');

            $product_update_data = [
                'main_image' => $data['main_image'],
            ];

            $product_update_builder->where('seller_id', $this->customer->getSellerId());
            $product_update_builder->where('customer_id', $this->customer->getId());
            $product_update_builder->where('product_id', $product_id);
            $product_update_builder->update($product_update_data);
        }

        // Product Descriptions
        if ($data['product_description']) {
            foreach ($data['product_description'] as $language_id => $value) {
                $product_description_builder = $this->db->table('product_description');

                $product_description_insert_data = [
                    'product_id' => $product_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $product_description_builder->insert($product_description_insert_data);
            }
        }

        // Product to category
        $category_ids = explode('_', $data['category_id_path']);

        foreach ($category_ids as $category_id) {
            $product_to_category_insert_builder = $this->db->table('product_to_category');

            $product_to_category_insert_data = [
                'product_id' => $product_id,
                'category_id' => $category_id,
            ];
            
            $product_to_category_insert_builder->insert($product_to_category_insert_data);
        }

        return $product_id;
    }

    public function editProduct($product_id, $data = [])
    {
        $product_update_builder = $this->db->table('product');

        $product_update_data = [
            'price' => (float)$data['price'],
            'weight' => $data['weight'],
            'weight_class_id' => $data['weight_class_id'],
            'date_modified' => now(),
            'status' => $data['status'],
        ];

        $product_update_builder->where('seller_id', $this->customer->getSellerId());
        $product_update_builder->where('customer_id', $this->customer->getId());
        $product_update_builder->where('product_id', $product_id);
        $product_update_builder->update($product_update_data);

        // Main image
        if (!empty($data['main_image'])) {
            $product_update_builder = $this->db->table('product');

            $product_update_data = [
                'main_image' => $data['main_image'],
            ];

            $product_update_builder->where('seller_id', $this->customer->getSellerId());
            $product_update_builder->where('customer_id', $this->customer->getId());
            $product_update_builder->where('product_id', $product_id);
            $product_update_builder->update($product_update_data);
        }
        
        // Delete product descriptions
        $builder = $this->db->table('product_description');

        $builder->where('product_id', $product_id);
        $builder->delete();

        // Product Descriptions
        if ($data['product_description']) {
            foreach ($data['product_description'] as $language_id => $value) {
                $product_description_builder = $this->db->table('product_description');

                $product_description_insert_data = [
                    'product_id' => $product_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $product_description_builder->insert($product_description_insert_data);
            }
        }

        // Delete product to category
        $product_to_category_delete_builder = $this->db->table('product_to_category');

        $product_to_category_delete_builder->where('product_id', $product_id);
        $product_to_category_delete_builder->delete();

        // Product to category
        $category_ids = explode('_', $data['category_id_path']);

        foreach ($category_ids as $category_id) {
            $product_to_category_insert_builder = $this->db->table('product_to_category');

            $product_to_category_insert_data = [
                'product_id' => $product_id,
                'category_id' => $category_id,
            ];
            
            $product_to_category_insert_builder->insert($product_to_category_insert_data);
        }

        return $product_id;
    }

    public function deleteProduct($product_id)
    {
        // Delete product
        $builder = $this->db->table('product');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);
        $builder->delete();

        // Delete product descriptions
        $builder = $this->db->table('product_description');

        $builder->where('product_id', $product_id);
        $builder->delete();

        // Delete product to category
        $builder = $this->db->table('product_to_category');

        $builder->where('product_id', $product_id);
        $builder->delete();
    }

    public function getProducts($data = [])
    {
        $builder = $this->db->table('product');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());

        $product_query = $builder->get();

        $products = [];

        foreach ($product_query->getResult() as $result) {
            $products[] = [
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'price' => $result->price,
                'weight' => $result->weight,
                'weight_class_id' => $result->weight_class_id,
                'main_image' => $result->main_image,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
                'status' => $result->status,
            ];
        }

        return $products;
    }

    public function getProduct($product_id)
    {
        $builder = $this->db->table('product');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);

        $product_query = $builder->get();

        $product = [];

        if ($row = $product_query->getRow()) {
            $product = [
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'category_id_path' => $row->category_id_path,
                'price' => $row->price,
                'weight' => $row->weight,
                'weight_class_id' => $row->weight_class_id,
                'main_image' => $row->main_image,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
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
        $builder->where('language_id', $this->setting->get('setting_admin_language_id'));

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