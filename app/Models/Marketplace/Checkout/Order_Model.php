<?php

namespace App\Models\Marketplace\Checkout;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Order_Model extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['order_id', 'customer_id', 'payment_firstname', 'payment_lastname', 'payment_address_1', 'payment_address_2'];
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

    public function addOrder($customer_id, $data = [])
    {
        $order_insert_builder = $this->db->table('order');

        $date_added = new Time('now');

        $order_insert_data = [
            'customer_id' => $customer_id,
            'customer_group_id' => $data['customer_group_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'payment_firstname' => $data['payment_firstname'],
            'payment_lastname' => $data['payment_lastname'],
            'payment_address_1' => $data['payment_address_1'],
            'payment_address_2' => $data['payment_address_2'],
            'payment_city' => $data['payment_city'],
            'payment_country_id' => $data['payment_country_id'],
            'payment_country' => $data['payment_country'],
            'payment_zone_id' => $data['payment_zone_id'],
            'payment_zone' => $data['payment_zone'],
            'payment_telephone' => $data['payment_telephone'],
            'payment_method_code' => $data['payment_method_code'],
            'payment_method_title' => $data['payment_method_title'],
            'shipping_firstname' => $data['shipping_firstname'],
            'shipping_lastname' => $data['shipping_lastname'],
            'shipping_address_1' => $data['shipping_address_1'],
            'shipping_address_2' => $data['shipping_address_2'],
            'shipping_city' => $data['shipping_city'],
            'shipping_country_id' => $data['shipping_country_id'],
            'shipping_country' => $data['shipping_country'],
            'shipping_zone_id' => $data['shipping_zone_id'],
            'shipping_zone' => $data['shipping_zone'],
            'shipping_telephone' => $data['shipping_telephone'],
            'total' => $data['total'],
            'currency_id' => $data['currency_id'],
            'currency_code' => $data['currency_code'],
            'currency_value' => $data['currency_value'],
            'date_added' => $date_added,
        ];
        
        $order_insert_builder->insert($order_insert_data);

        $order_id = $this->db->insertID();

        // Add invoice
        $order_update_builder = $this->db->table('order');

        $order_update_data = [
            'invoice' => $data['invoice'] . '-' . date('Y', strtotime($date_added)) . '-' . '000' . $order_id,
        ];
        
        $order_update_builder->where('customer_id', $customer_id);
        $order_update_builder->where('order_id', $order_id);
        $order_update_builder->update($order_update_data);

        // Order products
        if ($data['products']) {
            foreach ($data['products'] as $product) {
                // Add order product
                $order_product_insert_builder = $this->db->table('order_product');

                $order_product_insert_data = [
                    'order_id' => $order_id,
                    'seller_id' => $product['seller_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                ];
        
                $order_product_insert_builder->insert($order_product_insert_data);
            }
        }

        // Order shipping method
        if ($data['checkout_shipping_method']) {
            foreach ($data['checkout_shipping_method'] as $key => $value) {
                // Add order shipping
                $order_shipping_insert_builder = $this->db->table('order_shipping');

                $order_shipping_insert_data = [
                    'order_id' => $order_id,
                    'seller_id' => $key,
                    'code' => $value['code'],
                    'text' => $value['text'],
                    'cost' => $value['cost'],
                ];
        
                $order_shipping_insert_builder->insert($order_shipping_insert_data);
            }
        }

        // Order totals
        if ($data['totals']) {
            foreach ($data['totals'] as $key => $value) {
                foreach ($value as $order_total) {
                    // Add order total
                    $order_total_insert_builder = $this->db->table('order_total');

                    $order_total_insert_data = [
                        'order_id' => $order_id,
                        'seller_id' => $key,
                        'code' => $order_total['code'],
                        'title' => $order_total['title'],
                        'value' => $order_total['value'],
                        'sort_order' => $order_total['sort_order'],
                    ];
            
                    $order_total_insert_builder->insert($order_total_insert_data);
                }
            }
        }

        return $order_id;
    }

    public function editOrder($customer_id, $order_id, $data = [])
    {
        $order_update_builder = $this->db->table('order');

        $date_added = new Time('now');

        $order_update_data = [
            'invoice' => $data['invoice'] . '-' . date('Y', strtotime($date_added)) . '-' . '000' . $order_id,
            'customer_group_id' => $data['customer_group_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'payment_firstname' => $data['payment_firstname'],
            'payment_lastname' => $data['payment_lastname'],
            'payment_address_1' => $data['payment_address_1'],
            'payment_address_2' => $data['payment_address_2'],
            'payment_city' => $data['payment_city'],
            'payment_country_id' => $data['payment_country_id'],
            'payment_country' => $data['payment_country'],
            'payment_zone_id' => $data['payment_zone_id'],
            'payment_zone' => $data['payment_zone'],
            'payment_telephone' => $data['payment_telephone'],
            'payment_method_code' => $data['payment_method_code'],
            'payment_method_title' => $data['payment_method_title'],
            'shipping_firstname' => $data['shipping_firstname'],
            'shipping_lastname' => $data['shipping_lastname'],
            'shipping_address_1' => $data['shipping_address_1'],
            'shipping_address_2' => $data['shipping_address_2'],
            'shipping_city' => $data['shipping_city'],
            'shipping_country_id' => $data['shipping_country_id'],
            'shipping_country' => $data['shipping_country'],
            'shipping_zone_id' => $data['shipping_zone_id'],
            'shipping_zone' => $data['shipping_zone'],
            'shipping_telephone' => $data['shipping_telephone'],
            'total' => $data['total'],
            'currency_id' => $data['currency_id'],
            'currency_code' => $data['currency_code'],
            'currency_value' => $data['currency_value'],
            'date_added' => $date_added,
        ];
        
        $order_update_builder->where('customer_id', $customer_id);
        $order_update_builder->where('order_id', $order_id);
        $order_update_builder->update($order_update_data);

        // Order products
        $order_product_delete_builder = $this->db->table('order_product');

        $order_product_delete_builder->where('order_id', $order_id);
        $order_product_delete_builder->delete();

        if ($data['products']) {
            foreach ($data['products'] as $product) {
                // Add order product
                $order_product_insert_builder = $this->db->table('order_product');

                $order_product_insert_data = [
                    'order_id' => $order_id,
                    'seller_id' => $product['seller_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                ];
        
                $order_product_insert_builder->insert($order_product_insert_data);
            }
        }

        // Order shipping method
        $order_shipping_delete_builder = $this->db->table('order_shipping');

        $order_shipping_delete_builder->where('order_id', $order_id);
        $order_shipping_delete_builder->delete();

        if ($data['checkout_shipping_method']) {
            foreach ($data['checkout_shipping_method'] as $key => $value) {
                // Add order shipping
                $order_shipping_insert_builder = $this->db->table('order_shipping');

                $order_shipping_insert_data = [
                    'order_id' => $order_id,
                    'seller_id' => $key,
                    'code' => $value['code'],
                    'text' => $value['text'],
                    'cost' => $value['cost'],
                ];
        
                $order_shipping_insert_builder->insert($order_shipping_insert_data);
            }
        }

        // Order totals
        $order_total_delete_builder = $this->db->table('order_total');

        $order_total_delete_builder->where('order_id', $order_id);
        $order_total_delete_builder->delete();

        if ($data['totals']) {
            foreach ($data['totals'] as $key => $value) {
                foreach ($value as $order_total) {
                    // Add order total
                    $order_total_insert_builder = $this->db->table('order_total');

                    $order_total_insert_data = [
                        'order_id' => $order_id,
                        'seller_id' => $key,
                        'code' => $order_total['code'],
                        'title' => $order_total['title'],
                        'value' => $order_total['value'],
                        'sort_order' => $order_total['sort_order'],
                    ];
            
                    $order_total_insert_builder->insert($order_total_insert_data);
                }
            }
        }

        return $order_id;
    }

    public function editOrderPaymentMethodText($customer_id, $order_id, $text = '')
    {
        $order_update_builder = $this->db->table('order');

        $order_update_data = [
            'payment_method_text' => $text,
        ];
        
        $order_update_builder->where('customer_id', $customer_id);
        $order_update_builder->where('order_id', $order_id);
        $order_update_builder->update($order_update_data);

        return $order_id;
    }

    public function addOrderStatusHistory($order_id, $seller_id, $order_status_id, $comment = '', $notify = false)
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
            'comment' => $comment,
            'notify' => ($notify) ? 1 : 0,
            'date_added' => new Time('now'),
        ];
        
        $order_status_history_insert_builder->insert($order_status_history_insert_data);

        $order_status_history_id = $this->db->insertID();

        return true;
    }
}