<?php

namespace Main\Admin\Models\Marketplace;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Order_Model extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['parent_id', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->text = new \App\Libraries\Text();
    }

    public function deleteOrder($order_id)
    {
        // Delete order
        $builder = $this->db->table('order');

        $builder->where('order_id', $order_id);
        $builder->delete();

        // Delete order product
        $builder = $this->db->table('order_product');

        $builder->where('order_id', $order_id);
        $builder->delete();

        // Delete order shipping
        $builder = $this->db->table('order_shipping');

        $builder->where('order_id', $order_id);
        $builder->delete();

        // Delete order status history
        $builder = $this->db->table('order_status_history');

        $builder->where('order_id', $order_id);
        $builder->delete();

        // Delete order total
        $builder = $this->db->table('order_total');

        $builder->where('order_id', $order_id);
        $builder->delete();
    }

    public function getOrders($data = [])
    {
        $order_builder = $this->db->table('order');

        if (!empty($data['filter_order_status'])) {
            $order_builder->where('order_status_id', $data['filter_order_status']);
        } else {
            $order_builder->where('order_status_id > ', 0);
        }

        $order_builder->orderBy('date_added', 'DESC');

        $order_query = $order_builder->get();

        $orders = [];

        foreach ($order_query->getResult() as $result) {
            $orders[] = [
                'order_id' => $result->order_id,
                'invoice' => $result->invoice,
                'customer_id' => $result->customer_id,
                'customer_group_id' => $result->customer_group_id,
                'firstname' => $result->firstname,
                'lastname' => $result->lastname,
                'email' => $result->email,
                'telephone' => $result->telephone,
                'payment_firstname' => $result->payment_firstname,
                'payment_lastname' => $result->payment_lastname,
                'payment_address_1' => $result->payment_address_1,
                'payment_address_2' => $result->payment_address_2,
                'payment_city' => $result->payment_city,
                'payment_country_id' => $result->payment_country_id,
                'payment_country' => $result->payment_country,
                'payment_zone_id' => $result->payment_zone_id,
                'payment_zone' => $result->payment_zone,
                'payment_telephone' => $result->payment_telephone,
                'payment_method_code' => $result->payment_method_code,
                'payment_method_title' => $result->payment_method_title,
                'payment_method_text' => $result->payment_method_text,
                'shipping_firstname' => $result->shipping_firstname,
                'shipping_lastname' => $result->shipping_lastname,
                'shipping_address_1' => $result->shipping_address_1,
                'shipping_address_2' => $result->shipping_address_2,
                'shipping_city' => $result->shipping_city,
                'shipping_country_id' => $result->shipping_country_id,
                'shipping_country' => $result->shipping_country,
                'shipping_zone_id' => $result->shipping_zone_id,
                'shipping_zone' => $result->shipping_zone,
                'shipping_telephone' => $result->shipping_telephone,
                'total' => $result->total,
                'order_status_id' => $result->order_status_id,
                'currency_id' => $result->currency_id,
                'currency_code' => $result->currency_code,
                'currency_value' => $result->currency_value,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
            ];
        }

        return $orders;
    }

    public function getOrder($order_id)
    {
        $order_builder = $this->db->table('order');
        
        $order_builder->where('order_id', $order_id);
        $order_builder->where('order_status_id > ', 0);

        $order_query = $order_builder->get();

        $order = [];

        if ($row = $order_query->getRow()) {
            $order = [
                'order_id' => $row->order_id,
                'invoice' => $row->invoice,
                'customer_id' => $row->customer_id,
                'customer_group_id' => $row->customer_group_id,
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'email' => $row->email,
                'telephone' => $row->telephone,
                'payment_firstname' => $row->payment_firstname,
                'payment_lastname' => $row->payment_lastname,
                'payment_address_1' => $row->payment_address_1,
                'payment_address_2' => $row->payment_address_2,
                'payment_city' => $row->payment_city,
                'payment_country_id' => $row->payment_country_id,
                'payment_country' => $row->payment_country,
                'payment_zone_id' => $row->payment_zone_id,
                'payment_zone' => $row->payment_zone,
                'payment_telephone' => $row->payment_telephone,
                'payment_method_code' => $row->payment_method_code,
                'payment_method_title' => $row->payment_method_title,
                'payment_method_text' => $row->payment_method_text,
                'shipping_firstname' => $row->shipping_firstname,
                'shipping_lastname' => $row->shipping_lastname,
                'shipping_address_1' => $row->shipping_address_1,
                'shipping_address_2' => $row->shipping_address_2,
                'shipping_city' => $row->shipping_city,
                'shipping_country_id' => $row->shipping_country_id,
                'shipping_country' => $row->shipping_country,
                'shipping_zone_id' => $row->shipping_zone_id,
                'shipping_zone' => $row->shipping_zone,
                'shipping_telephone' => $row->shipping_telephone,
                'total' => $row->total,
                'order_status_id' => $row->order_status_id,
                'currency_id' => $row->currency_id,
                'currency_code' => $row->currency_code,
                'currency_value' => $row->currency_value,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
            ];
        }

        return $order;
    }

    public function getOrderSellers($order_id)
    {
        $order_seller_builder = $this->db->table('order_product');

        $order_seller_builder->where('order_id', $order_id);
        $order_seller_builder->groupBy('seller_id');

        $order_seller_query = $order_seller_builder->get();

        $order_sellers = [];

        foreach ($order_seller_query->getResult() as $result) {
            $order_sellers[] = $result->seller_id;
        }

        return $order_sellers;
    }

    public function getOrderProducts($order_id, $seller_id)
    {
        $order_product_builder = $this->db->table('order_product');

        $order_product_builder->where('order_id', $order_id);
        $order_product_builder->where('seller_id', $seller_id);
        $order_product_builder->orderBy('name', 'ASC');

        $order_product_query = $order_product_builder->get();

        $order_products = [];

        foreach ($order_product_query->getResult() as $result) {
            $order_products[] = [
                'order_product_id' => $result->order_product_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'product_id' => $result->product_id,
                'name' => $result->name,
                'quantity' => $result->quantity,
                'price' => $result->price,
                'option' => $result->option,
                'option_ids' => $result->option_ids,
                'total' => $result->total,
            ];
        }

        return $order_products;
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
                'option' => $row->option,
                'option_ids' => $row->option_ids,
                'total' => $row->total,
            ];
        }

        return $order_product;
    }

    public function getOrderShipping($order_id, $seller_id)
    {
        $order_shipping_builder = $this->db->table('order_shipping');
        
        $order_shipping_builder->where('order_id', $order_id);
        $order_shipping_builder->where('seller_id', $seller_id);

        $order_shipping_query = $order_shipping_builder->get();

        $order_shipping = [];

        if ($row = $order_shipping_query->getRow()) {
            $order_shipping = [
                'order_shipping_id' => $row->order_shipping_id,
                'order_id' => $row->order_id,
                'seller_id' => $row->seller_id,
                'code' => $row->code,
                'text' => $row->text,
                'cost' => $row->cost,
                'tracking_number' => $row->tracking_number,
            ];
        }

        return $order_shipping;
    }

    public function getOrderTotals($order_id, $seller_id)
    {
        $order_total_builder = $this->db->table('order_total');

        $order_total_builder->where('order_id', $order_id);
        $order_total_builder->where('seller_id', $seller_id);
        $order_total_builder->orderBy('sort_order', 'ASC');

        $order_total_query = $order_total_builder->get();

        $order_totals = [];

        foreach ($order_total_query->getResult() as $result) {
            $order_totals[] = [
                'order_total_id' => $result->order_total_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'code' => $result->code,
                'title' => $result->title,
                'value' => $result->value,
                'sort_order' => $result->sort_order,
            ];
        }

        return $order_totals;
    }

    public function getOrderTotalsByCode($order_id, $code)
    {
        $order_total_builder = $this->db->table('order_total');

        $order_total_builder->where('order_id', $order_id);
        $order_total_builder->where('code', $code);
        $order_total_builder->orderBy('sort_order', 'ASC');

        $order_total_query = $order_total_builder->get();

        $order_totals = [];

        foreach ($order_total_query->getResult() as $result) {
            $order_totals[] = [
                'order_total_id' => $result->order_total_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'code' => $result->code,
                'title' => $result->title,
                'value' => $result->value,
                'sort_order' => $result->sort_order,
            ];
        }

        return $order_totals;
    }

    public function getOrderStatusHistories($order_id, $seller_id)
    {
        $order_status_history_builder = $this->db->table('order_status_history');

        $order_status_history_builder->where('order_id', $order_id);
        $order_status_history_builder->where('seller_id', $seller_id);

        $order_status_history_builder->orderBy('date_added', 'DESC');

        $order_status_history_query = $order_status_history_builder->get();

        $order_status_histories = [];

        foreach ($order_status_history_query->getResult() as $result) {
            $order_status_histories[] = [
                'order_status_history_id' => $result->order_status_history_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'order_status_id' => $result->order_status_id,
                'comment' => json_decode($result->comment, true),
                'notify' => $result->notify,
                'date_added' => $result->date_added,
            ];
        }

        return $order_status_histories;
    }

    public function getLatestOrderStatus($order_id, $seller_id)
    {
        $order_status_history_builder = $this->db->table('order_status_history');
        
        $order_status_history_builder->where('order_id', $order_id);
        $order_status_history_builder->where('seller_id', $seller_id);
        $order_status_history_builder->orderBy('date_added', 'DESC');
        $order_status_history_builder->limit(1);

        $order_status_history_query = $order_status_history_builder->get();

        $order_status_history = [];

        if ($row = $order_status_history_query->getRow()) {
            $order_status_history = [
                'order_status_history_id' => $row->order_status_history_id,
                'order_id' => $row->order_id,
                'seller_id' => $row->seller_id,
                'order_status_id' => $row->order_status_id,
                'comment' => $row->comment,
                'notify' => $row->notify,
                'date_added' => $row->date_added,
            ];
        }

        return $order_status_history;
    }

    public function getOrderProductsByOrderStatusId($order_status_id)
    {
        $builder = $this->db->table('order_product op');
        $builder->join('order o', 'op.order_id = o.order_id', 'left');
        $builder->join('order_status_history osh', '(op.order_id = osh.order_id) AND (op.seller_id = osh.seller_id)', 'left');

        $builder->where('o.customer_id', $this->customer->getId());
        $builder->where('osh.order_status_id', $order_status_id);

        $order_product_query = $builder->get();

        $order_products = [];

        foreach ($order_product_query->getResult() as $result) {
            $order_products[] = [
                'order_product_id' => $result->order_product_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'product_id' => $result->product_id,
                'name' => $result->name,
                'quantity' => $result->quantity,
                'price' => $result->price,
                'option' => json_decode($result->option, true),
                'option_ids' => $result->option_ids,
                'total' => $result->total,
                'date_added' => $result->date_added,
            ];
        }

        return $order_products;
    }

    public function addOrderStatusHistory($order_id, $seller_id, $order_status_id, $comment = [], $notify = false)
    {
        // Update order status id
        $order_update_builder = $this->db->table('order');

        $order_update_data = [
            'order_status_id' => $order_status_id,
        ];
        
        $order_update_builder->where('order_id', $order_id);
        $order_update_builder->update($order_update_data);

        // Add order status history
        $order_status_history_insert_builder = $this->db->table('order_status_history');

        $order_status_history_insert_data = [
            'order_id' => $order_id,
            'seller_id' => $seller_id,
            'order_status_id' => $order_status_id,
            'comment' => json_encode($comment),
            'notify' => ($notify) ? 1 : 0,
            'date_added' => new Time('now'),
        ];
        
        $order_status_history_insert_builder->insert($order_status_history_insert_data);

        $order_status_history_id = $this->db->insertID();

        return true;
    }
}