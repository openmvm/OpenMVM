<?php

namespace Main\Marketplace\Models\Product;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

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

        $builder->select("(SELECT price FROM " . $this->db->getPrefix() . "product_special ps WHERE ps.product_id = p.product_id AND (ps.date_start < '" . new Time('now') . "' AND ps.date_end > '" . new Time('now') . "') ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special");

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

    public function getProductImages($product_id)
    {
        $builder = $this->db->table('product_image');

        $builder->where('product_id', $product_id);

        $product_image_query = $builder->get();

        $product_images = [];

        foreach ($product_image_query->getResult() as $result) {
            $product_images[] = [
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'image' => $result->image,
            ];
        }

        return $product_images;
    }

    public function getProductOptions($product_id)
    {
        $product_option_builder = $this->db->table('product_option');

        $product_option_builder->where('product_id', $product_id);

        $product_option_query = $product_option_builder->get();

        $product_options = [];

        foreach ($product_option_query->getResult() as $product_option) {
            // Get option info
            $option_builder = $this->db->table('option');
            
            $option_builder->where('option_id', $product_option->option_id);

            $option_query = $option_builder->get();

            $option = [];

            if ($option_row = $option_query->getRow()) {
                $option_sort_order = $option_row->sort_order;
            } else {
                $option_sort_order = 0;
            }

            // Get option description
            $option_description_builder = $this->db->table('option_description');
            
            $option_description_builder->where('option_id', $product_option->option_id);
            $option_description_builder->where('language_id', $this->language->getCurrentId());

            $option_description_query = $option_description_builder->get();

            $option_description = [];

            if ($option_description_row = $option_description_query->getRow()) {
                $option_description = [
                    'name' => $option_description_row->name,
                ];
            }

            $product_options[] = [
                'product_option_id' => $product_option->product_option_id,
                'product_id' => $product_option->product_id,
                'option_id' => $product_option->option_id,
                'sort_order' => $option_sort_order,
                'seller_id' => $product_option->seller_id,
                'customer_id' => $product_option->customer_id,
                'description' => $option_description,
            ];
        }

        return $product_options;
    }

    public function getProductOptionValues($product_id, $product_option_id)
    {
        $product_option_value_builder = $this->db->table('product_option_value');

        $product_option_value_builder->where('product_option_id', $product_option_id);
        $product_option_value_builder->where('product_id', $product_id);

        $product_option_value_query = $product_option_value_builder->get();

        $product_option_values = [];

        foreach ($product_option_value_query->getResult() as $product_option_value) {
            // Get option value info
            $option_value_builder = $this->db->table('option_value');
            
            $option_value_builder->where('option_value_id', $product_option_value->option_value_id);

            $option_value_query = $option_value_builder->get();

            $option_value = [];

            if ($option_value_row = $option_value_query->getRow()) {
                $option_value_sort_order = $option_value_row->sort_order;
            } else {
                $option_value_sort_order = 0;
            }

            // Get option value description
            $option_value_description_builder = $this->db->table('option_value_description');
            
            $option_value_description_builder->where('option_value_id', $product_option_value->option_value_id);
            $option_value_description_builder->where('language_id', $this->language->getCurrentId());

            $option_value_description_query = $option_value_description_builder->get();

            $option_value_description = [];

            if ($option_value_description_row = $option_value_description_query->getRow()) {
                $option_value_description = [
                    'name' => $option_value_description_row->name,
                ];
            }

            $product_option_values[] = [
                'product_option_id' => $product_option_value->product_option_id,
                'product_id' => $product_option_value->product_id,
                'option_id' => $product_option_value->option_id,
                'option_value_id' => $product_option_value->option_value_id,
                'sort_order' => $option_value_sort_order,
                'seller_id' => $product_option_value->seller_id,
                'customer_id' => $product_option_value->customer_id,
                'description' => $option_value_description,
            ];
        }

        return $product_option_values;
    }

    public function getProductVariants($product_id)
    {
        $product_variant_builder = $this->db->table('product_variant');

        $product_variant_builder->where('product_id', $product_id);

        $product_variant_query = $builder->get();

        $product_variants = [];

        foreach ($product_variant_query->getResult() as $product_variant) {
            $product_variants[] = [
                'product_variant_id' => $product_variant->product_variant_id,
                'product_id' => $product_variant->product_id,
                'seller_id' => $product_variant->seller_id,
                'customer_id' => $product_variant->customer_id,
                'sku' => $product_variant->sku,
                'quantity' => $product_variant->quantity,
                'price' => $product_variant->price,
                'weight' => $product_variant->weight,
                'weight_class_id' => $product_variant->weight_class_id,
            ];
        }

        return $product_variants;
    }

    public function getProductVariantMinMaxPrices($product_id)
    {
        $product_variant_builder = $this->db->table('product_variant');
        $product_variant_builder->selectMin('price', 'min_price');
        $product_variant_builder->selectMax('price', 'max_price');

        $product_variant_builder->where('product_id', $product_id);

        $product_variant_query = $product_variant_builder->get();

        $product_variant = [];

        if ($product_variant_row = $product_variant_query->getRow()) {
            $product_variant = [
                'min_price' => $product_variant_row->min_price,
                'max_price' => $product_variant_row->max_price,
            ];
        }

        return $product_variant;
    }

    public function getProductVariantByOptions($product_id, $options)
    {
        $product_variant_builder = $this->db->table('product_variant');

        $product_variant_builder->where('product_id', $product_id);
        $product_variant_builder->where('options', $options);

        $product_variant_query = $product_variant_builder->get();

        $product_variant = [];

        if ($product_variant_row = $product_variant_query->getRow()) {
            $product_variant = [
                'product_variant_id' => $product_variant_row->product_variant_id,
                'product_id' => $product_variant_row->product_id,
                'seller_id' => $product_variant_row->seller_id,
                'customer_id' => $product_variant_row->customer_id,
                'sku' => $product_variant_row->sku,
                'quantity' => $product_variant_row->quantity,
                'minimum_purchase' => $product_variant_row->minimum_purchase,
                'price' => $product_variant_row->price,
                'weight' => $product_variant_row->weight,
                'weight_class_id' => $product_variant_row->weight_class_id,
            ];
        }

        return $product_variant;
    }

    public function getProductVariantSpecialByOptions($product_id, $options)
    {
        $product_variant_special_builder = $this->db->table('product_variant_special');

        $product_variant_special_builder->where('product_id', $product_id);
        $product_variant_special_builder->where('options', $options);
        $product_variant_special_builder->where('date_start < ', new Time('now'));
        $product_variant_special_builder->where('date_end > ', new Time('now'));

        $product_variant_special_builder->orderBy('priority', 'ASC');
        $product_variant_special_builder->orderBy('price', 'ASC');

        $product_variant_special_builder->limit(1);

        $product_variant_special_query = $product_variant_special_builder->get();

        $product_variant_special = [];

        if ($product_variant_special_row = $product_variant_special_query->getRow()) {
            $product_variant_special = [
                'product_variant_special_id' => $product_variant_special_row->product_variant_special_id,
                'product_variant_id' => $product_variant_special_row->product_variant_id,
                'options' => $product_variant_special_row->options,
                'product_id' => $product_variant_special_row->product_id,
                'seller_id' => $product_variant_special_row->seller_id,
                'customer_id' => $product_variant_special_row->customer_id,
                'priority' => $product_variant_special_row->priority,
                'price' => $product_variant_special_row->price,
                'date_start' => $product_variant_special_row->date_start,
                'date_end' => $product_variant_special_row->date_end,
                'timezone' => $product_variant_special_row->timezone,
            ];
        }

        return $product_variant_special;
    }

    public function getProductVariantSpecialMinMaxPrices($product_id)
    {
        $product_variant_builder = $this->db->table('product_variant');

        $product_variant_builder->where('product_id', $product_id);

        $product_variant_query = $product_variant_builder->get();

        $product_variant_specials = [];

        foreach ($product_variant_query->getResult() as $product_variant) {
            // Get product variant special
            $product_variant_special_builder = $this->db->table('product_variant_special');

            $product_variant_special_builder->where('product_id', $product_id);
            $product_variant_special_builder->where('options', $product_variant->options);
            $product_variant_special_builder->where('date_start < ', new Time('now'));
            $product_variant_special_builder->where('date_end > ', new Time('now'));

            $product_variant_special_builder->orderBy('priority', 'ASC');
            $product_variant_special_builder->orderBy('price', 'ASC');

            $product_variant_special_builder->limit(1);

            $product_variant_special_query = $product_variant_special_builder->get();

            if ($product_variant_special_row = $product_variant_special_query->getRow()) {
                $price = $product_variant_special_row->price;
            } else {
                $price = $product_variant->price;
            }

            $product_variant_specials[] = $price;
        }

        if (!empty($product_variant_specials)) {
            $product_variant_special_prices = [
                'min_price' => min($product_variant_specials),
                'max_price' => max($product_variant_specials),
            ];

            return $product_variant_special_prices;
        } else {
            return false;
        }
    }

    public function getOrderProduct($customer_id, $order_product_id)
    {
        $order_product_builder = $this->db->table('order_product op');
        $order_product_builder->join('order o', 'op.order_id = o.order_id', 'left');
        
        $order_product_builder->where('o.customer_id', $customer_id);
        $order_product_builder->where('op.order_product_id', $order_product_id);

        $order_product_query = $order_product_builder->get();

        $order_product = [];

        if ($row = $order_product_query->getRow()) {
            $order_product = [
                'order_product_id' => $row->order_product_id,
                'order_id' => $row->order_id,
                'seller_id' => $row->seller_id,
                'product_id' => $row->product_id,
                'name' => $row->name,
                'quantity' => $row->quantity,
                'price' => $row->price,
                'option' => json_decode($row->option, true),
                'option_ids' => $row->option_ids,
                'total' => $row->total,
            ];
        }

        return $order_product;
    }
}