<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;

class Order_Model extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['customer_id', 'customer_group_id', 'firstname', 'lastname', 'telephone', 'email'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    public function getOrders($seller_id)
    {
        $order_builder = $this->db->table('order');
        $order_builder->join('order_product', 'order_product.order_id = order.order_id');

        $order_builder->where('order_product.seller_id', $seller_id);
        $order_builder->where('order.order_status_id >', 0);
        $order_builder->groupBy('order.order_id');

        if (!empty($data['sort'])) {
            $sort = $data['sort'];
        } else {
            $sort = 'order.date_added';
        }

        if (!empty($data['order'])) {
            $order = $data['order'];
        } else {
            $order = 'DESC';
        }

        $order_builder->orderBy($sort, $order);

        if (!empty($data['start']) || !empty($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $order_builder->limit($data['limit'], $data['start']);
        }

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

    public function getOrder($seller_id, $order_id)
    {
        $order_builder = $this->db->table('order');
        $order_builder->join('order_product', 'order_product.order_id = order.order_id');
        
        $order_builder->where('order.order_id', $order_id);
        $order_builder->where('order_product.seller_id', $seller_id);
        $order_builder->where('order.order_status_id >', 0);

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

    public function getTotalOrderProducts($order_id, $seller_id)
    {
        $order_product_builder = $this->db->table('order_product');
        $order_product_builder->select('COUNT(order_product_id) AS total');

        $order_product_builder->where('order_id', $order_id);
        $order_product_builder->where('seller_id', $seller_id);
        $order_product_builder->orderBy('name', 'ASC');

        $order_product_query = $order_product_builder->get();

        if ($row = $order_product_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function getTotalOrderProductQuantity($order_id, $seller_id)
    {
        $quantity = 0;

        $order_products = $this->getOrderProducts($order_id, $seller_id);

        foreach ($order_products as $order_product) {
            $quantity += $order_product['quantity'];
        }

        return $quantity;
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

    public function editTrackingNumber($order_id, $seller_id, $data = [])
    {
        $order_shipping_update_builder = $this->db->table('order_shipping');

        $order_shipping_update_data = [
            'tracking_number' => $data['tracking_number'],
        ];

        $order_shipping_update_builder->where('order_id', $order_id);
        $order_shipping_update_builder->where('seller_id', $seller_id);
        $order_shipping_update_builder->update($order_shipping_update_data);

        return true;
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

    public function getOrderTotal($order_id, $seller_id, $code = '')
    {
        $order_total_builder = $this->db->table('order_total');
        
        $order_total_builder->where('order_id', $order_id);
        $order_total_builder->where('seller_id', $seller_id);
        $order_total_builder->where('code', $code);

        $order_total_query = $order_total_builder->get();

        $order_total = [];

        if ($row = $order_total_query->getRow()) {
            $order_total = [
                'order_total_id' => $row->order_total_id,
                'order_id' => $row->order_id,
                'seller_id' => $row->seller_id,
                'code' => $row->code,
                'title' => $row->title,
                'value' => $row->value,
                'sort_order' => $row->sort_order,
            ];
        }

        return $order_total;
    }

    public function getOrderStatusHistories($order_id, $seller_id)
    {
        $order_status_history_builder = $this->db->table('order_status_history');

        $order_status_history_builder->where('order_id', $order_id);
        $order_status_history_builder->where('seller_id', $seller_id);

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

    public function getTotalRevenue($seller_id)
    {
        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('SUM(ot.value) AS total');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));

        $order_query = $order_builder->get();

        if ($row = $order_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function getTotalOrders($seller_id)
    {
        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('COUNT(o.order_id) AS total');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));

        $order_query = $order_builder->get();

        if ($row = $order_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function getTotalSoldQuantity($seller_id)
    {
        $order_builder = $this->db->table('order_product op');
        $order_builder->join('order o', 'op.order_id = o.order_id');

        $order_builder->select('SUM(op.quantity) AS total');
        
        $order_builder->where('op.seller_id', $seller_id);
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));

        $order_query = $order_builder->get();

        if ($row = $order_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }
}