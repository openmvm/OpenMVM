<?php

namespace Main\Marketplace\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Product_Review_Model extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'product_review_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_review_id', 'order_product_id', 'order_id', 'product_id', 'seller_id', 'customer_id', 'rating', 'title', 'review', 'date_added', 'date_modified', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
    }

    public function addProductReview($customer_id, $data = [])
    {
        // Insert
        $product_review_insert_builder = $this->db->table('product_review');

        $product_review_insert_data = [
            'order_product_id' => $data['order_product_id'],
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'],
            'seller_id' => $data['seller_id'],
            'customer_id' => $customer_id,
            'rating' => $data['rating'],
            'title' => $data['title'],
            'review' => $data['review'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];
        
        $product_review_insert_builder->insert($product_review_insert_data);

        $product_review_id = $this->db->insertID();

        return $product_review_id;
    }

    public function editProductReview($customer_id, $order_product_id, $data = [])
    {
        // Update
        $product_review_update_builder = $this->db->table('product_review');

        $product_review_update_builder->where('customer_id', $customer_id);
        $product_review_update_builder->where('order_product_id', $order_product_id);

        $product_review_update_data = [
            'rating' => $data['rating'],
            'title' => $data['title'],
            'review' => $data['review'],
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];
        
        $product_review_update_builder->update($product_review_update_data);

        return $order_product_id;
    }

    public function getProductReview($customer_id, $product_review_id)
    {
        $product_review_builder = $this->db->table('product_review');
        
        $product_review_builder->where('product_review_id', $product_review_id);
        $product_review_builder->where('customer_id', $customer_id);

        $product_review_query = $product_review_builder->get();

        $product_review = [];

        if ($row = $product_review_query->getRow()) {
            $product_review = [
                'product_review_id' => $row->product_review_id,
                'order_product_id' => $row->order_product_id,
                'order_id' => $row->order_id,
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'rating' => $row->rating,
                'title' => $row->title,
                'review' => $row->review,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
            ];
        }

        return $product_review;
    }

    public function getProductReviewByOrderProductId($customer_id, $order_product_id)
    {
        $product_review_builder = $this->db->table('product_review');
        
        $product_review_builder->where('order_product_id', $order_product_id);
        $product_review_builder->where('customer_id', $customer_id);

        $product_review_query = $product_review_builder->get();

        $product_review = [];

        if ($row = $product_review_query->getRow()) {
            $product_review = [
                'product_review_id' => $row->product_review_id,
                'order_product_id' => $row->order_product_id,
                'order_id' => $row->order_id,
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'rating' => $row->rating,
                'title' => $row->title,
                'review' => $row->review,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
            ];
        }

        return $product_review;
    }
}