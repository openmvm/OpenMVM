<?php

namespace Main\Marketplace\Models\Product;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Product_Review_Model extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'product_review_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_review_id', 'order_product_id', 'order_id', 'product_id', 'seller_id', 'customer_id', 'rating', 'review', 'date_added', 'date_modified', 'status'];
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

    public function getProductReviews($product_id, $rating = false)
    {
        $product_review_builder = $this->db->table('product_review');
        
        $product_review_builder->where('product_id', $product_id);
        $product_review_builder->where('status', 1);

        if ($rating) {
            $product_review_builder->where('rating', $rating);
        }

        $product_review_query = $product_review_builder->get();

        $product_reviews = [];

        foreach ($product_review_query->getResult() as $result) {
            $product_reviews[] = [
                'product_review_id' => $result->product_review_id,
                'order_product_id' => $result->order_product_id,
                'order_id' => $result->order_id,
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'rating' => $result->rating,
                'title' => $result->title,
                'review' => $result->review,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
                'status' => $result->status,
            ];
        }

        return $product_reviews;
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

    public function getAverageProductReviewRating($product_id)
    {
        $product_review_builder = $this->db->table('product_review');
        $product_review_builder->select('AVG(rating) AS avg');
        
        $product_review_builder->where('product_id', $product_id);
        $product_review_builder->where('status', 1);

        $product_review_query = $product_review_builder->get();

        $row = $product_review_query->getRow();

        return $row->avg;
    }

    public function getTotalProductReviewsByRating($product_id, $rating)
    {
        $product_review_builder = $this->db->table('product_review');
        $product_review_builder->select('COUNT(product_review_id) AS total');
        
        $product_review_builder->where('product_id', $product_id);
        $product_review_builder->where('rating', $rating);
        $product_review_builder->where('status', 1);

        $product_review_query = $product_review_builder->get();

        $row = $product_review_query->getRow();

        return $row->total;
    }

    public function getTotalProductReviews($product_id)
    {
        $product_review_builder = $this->db->table('product_review');
        $product_review_builder->select('COUNT(product_review_id) AS total');
        
        $product_review_builder->where('product_id', $product_id);
        $product_review_builder->where('status', 1);

        $product_review_query = $product_review_builder->get();

        $row = $product_review_query->getRow();

        return $row->total;
    }
}