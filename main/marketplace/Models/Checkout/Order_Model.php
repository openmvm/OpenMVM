<?php

namespace Main\Marketplace\Models\Checkout;

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
        $this->language = new \App\Libraries\Language();
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
                    'option' => json_encode($product['option']),
                    'option_ids' => $product['option_ids'],
                    'total' => $product['total'],
                ];
        
                $order_product_insert_builder->insert($order_product_insert_data);
            }
        }

        // Order shipping method
        if (!empty($data['checkout_shipping_method'])) {
            foreach ($data['checkout_shipping_method'] as $key => $value) {
                if (!empty($data['checkout_shipping_method'][$key])) {
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
                    'option' => json_encode($product['option']),
                    'option_ids' => $product['option_ids'],
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
                if ($data['checkout_shipping_method'][$key]) {
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

    public function getOrder($order_id)
    {
        $order_builder = $this->db->table('order');
        
        $order_builder->where('order_id', $order_id);

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

    public function getOrderProducts($order_id)
    {
        $order_product_builder = $this->db->table('order_product');

        $order_product_builder->where('order_id', $order_id);

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

    public function addOrderStatusHistory($order_id, $seller_id, $order_status_id, $comment = [], $notify = false)
    {
        // Get order
        $order_info = $this->getOrder($order_id);

        if ($order_info) {
            // Stock subtraction
            if (!in_array($order_info['order_status_id'], $this->setting->get('setting_stock_subtraction_order_statuses')) && in_array($order_status_id, $this->setting->get('setting_stock_subtraction_order_statuses'))) {
                // Get order products
                $order_products = $this->getOrderProducts($order_id);

                foreach ($order_products as $order_product) {
                    if (!empty(json_decode($order_product['option_ids'], true))) {
                        // Update quantity
                        $product_variant_update_builder = $this->db->table('product_variant');

                        $product_variant_update_builder->set('quantity', 'quantity-' . $order_product['quantity'], false);

                        $product_variant_update_builder->where('product_id', $order_product['product_id']);
                        $product_variant_update_builder->where('options', $order_product['option_ids']);
                        $product_variant_update_builder->where('subtract_stock', 1);
                        $product_variant_update_builder->update();
                    } else {
                        // Update quantity
                        $product_update_builder = $this->db->table('product');

                        $product_update_builder->set('quantity', 'quantity-' . $order_product['quantity'], false);

                        $product_update_builder->where('product_id', $order_product['product_id']);
                        $product_update_builder->where('subtract_stock', 1);
                        $product_update_builder->update();
                    }
                }
            }

            // Send wallet balance to seller's wallet
            if ($order_status_id == $this->setting->get('setting_completed_order_status_id')) {
                $wallet_temp_builder = $this->db->table('wallet_temp');
                
                $wallet_temp_builder->where('order_id', $order_id);
                $wallet_temp_builder->where('seller_id', $seller_id);
                $wallet_temp_builder->where('customer_id', $seller_id);

                $wallet_temp_query = $wallet_temp_builder->get();

                foreach ($wallet_temp_query->getResult() as $wallet_temp_result) {
                    // Get languages
                    $language_builder = $this->db->table('language');

                    $language_query = $language_builder->get();

                    $languages = [];

                    foreach ($language_query->getResult() as $language_result) {
                        $languages[] = [
                            'language_id' => $language_result->language_id,
                        ];
                    }

                    // Wallet description
                    $wallet_description = [];

                    foreach ($languages as $language) {
                        $wallet_description[$language['language_id']] = lang('Text.order_payment_seller', ['order_id' => $order_id], $this->language->getCurrentCode());
                    }

                    // Add wallet
                    $wallet_insert_builder = $this->db->table('wallet');

                    $wallet_insert_data = [
                        'customer_id' => $wallet_temp_result->customer_id,
                        'amount' => $wallet_temp_result->amount,
                        'description' => json_encode($wallet_description),
                        'comment' => '',
                        'date_added' => new Time('now'),
                    ];
                    
                    $wallet_insert_builder->insert($wallet_insert_data);

                    $wallet_id = $this->db->insertID();
                }

                // Delete wallet temp for this order
                $wallet_temp_delete_builder = $this->db->table('wallet_temp');

                $wallet_temp_delete_builder->where('order_id', $order_id);
                $wallet_temp_delete_builder->where('seller_id', $seller_id);
                $wallet_temp_delete_builder->where('customer_id', $seller_id);
                $wallet_temp_delete_builder->delete();
            }

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

        }
    }
}