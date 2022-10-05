<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class Cart {
	private $key;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        // Libraries
        $this->currency = new \App\Libraries\Currency();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->weight = new \App\Libraries\Weight();

        // Remove all expired cart items with no customer_id
        $now =  new Time('-1 hour');

        $builder = $this->db->table('cart');

        $builder->where('customer_id', 0);
        $builder->where('date_added <', $now);
        $builder->delete();

        // Shopping cart key
        if ($this->session->has('shopping_cart_key')) {
            $this->key = $this->session->get('shopping_cart_key');
        } else {
            $shopping_cart_key = bin2hex(random_bytes(20));

            $this->session->set('shopping_cart_key', $shopping_cart_key);

            $this->key = $this->session->get('shopping_cart_key');
        }

        // If customer is logged in
        if ($this->session->has('customer_session_token')) {
            // Get customer id
            $customer_id = $this->session->get('customer_id_' . $this->session->get('customer_session_token'));

            // Get customer seller id
            $seller_builder = $this->db->table('seller');
        
            $seller_builder->where('customer_id', $customer_id);

            $seller_query = $seller_builder->get();

            if ($seller = $seller_query->getRow()) {
                $seller_id = $seller->seller_id;
            } else {
                $seller_id = 0;
            }

            // Update customer cart key
            $cart_update_builder = $this->db->table('cart');

            $cart_update_builder->set('key', $this->key);

            $cart_update_builder->where('customer_id', $customer_id);

            $cart_update_builder->update();

            // Get carts that have customer id = 0 by key
            $cart_builder = $this->db->table('cart');
        
            $cart_builder->where('customer_id', 0);
            $cart_builder->where('key', $this->key);

            $cart_query = $cart_builder->get();
    
            foreach ($cart_query->getResult() as $result) {
                if ($result->seller_id !== $seller_id) {
                    // Add cart to customer
                    $this->add($customer_id, $result->seller_id, $result->product_id, $result->quantity, json_decode($result->option, true));
                }

                // Delete cart
                $cart_delete_builder = $this->db->table('cart');

                $cart_delete_builder->where('cart_id', $result->cart_id);
                $cart_delete_builder->delete();
            }
        }
    }

    /**
     * Cart remove.
     *
     */
    public function remove($customer_id, $seller_id, $key)
    {
        $cart_builder = $this->db->table('cart');

        $cart_builder->where('customer_id', $customer_id);
        $cart_builder->where('seller_id', $seller_id);
        $cart_builder->where('key', $key);
        $cart_builder->delete();
    }

    /**
     * Cart add.
     *
     */
    public function add($customer_id, $seller_id, $product_id, $quantity, $options = [])
    {
        if (is_array($options)) {
            asort($options);
        }
            
        $cart_builder = $this->db->table('cart');
        
        $cart_builder->where('customer_id', $customer_id);
        $cart_builder->where('seller_id', $seller_id);
        $cart_builder->where('product_id', $product_id);
        $cart_builder->where('option', json_encode($options));
        $cart_builder->where('key', $this->getKey());

        $cart_query = $cart_builder->get();

        if ($row = $cart_query->getRow()) {
            // Update cart
            $cart_update_builder = $this->db->table('cart');

            $cart_update_builder->set('quantity', 'quantity + ' . $quantity, false);
            $cart_update_builder->set('date_modified', new Time('now'));

            $cart_update_builder->where('customer_id', $customer_id);
            $cart_update_builder->where('seller_id', $seller_id);
            $cart_update_builder->where('product_id', $product_id);
            $cart_update_builder->where('option', json_encode($options));
            $cart_update_builder->where('key', $this->getKey());

            $cart_update_builder->update();
        } else {
            // Insert cart
            $cart_insert_builder = $this->db->table('cart');

            $cart_insert_data = [
                'customer_id' => $customer_id,
                'seller_id' => $seller_id,
                'key' => $this->getKey(),
                'product_id' => $product_id,
                'quantity' => $quantity,
                'option' => json_encode($options),
                'date_added' => new Time('now'),
                'date_modified' => new Time('now'),
            ];
            
            $cart_insert_builder->insert($cart_insert_data);
        }
    }

    /**
     * Cart get weight.
     *
     */
    public function getWeight($seller_id)
    {
        $weight = 0;

        $products = $this->getProducts($seller_id);

        foreach ($products as $product) {
            $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->setting->get('setting_marketplace_weight_class_id')) * $product['quantity'];
        }

        return $weight;
    }

    /**
     * Cart get sub total.
     *
     */
    public function getSubTotal($seller_id)
    {
        $sub_total = 0;

        $products = $this->getProducts($seller_id);

        foreach ($products as $product) {
            $sub_total += $product['total'];
        }

        return $sub_total;
    }

    /**
     * Cart get total products.
     *
     */
    public function getTotalProducts($seller_id)
    {
        $total_products = 0;

        $products = $this->getProducts($seller_id);

        foreach ($products as $product) {
            $total_products += $product['quantity'];
        }

        return $total_products;
    }

    /**
     * Cart get products.
     *
     */
    public function getProducts($seller_id)
    {
        $products = [];

        if ($this->session->has('customer_session_token')) {
            // Get customer id
            $customer_id = $this->session->get('customer_id_' . $this->session->get('customer_session_token'));
        } else {
            // Get customer id
            $customer_id = 0;
        }

        // Get carts
        $cart_builder = $this->db->table('cart');
    
        $cart_builder->where('customer_id', $customer_id);
        $cart_builder->where('seller_id', $seller_id);
        $cart_builder->where('key', $this->getKey());

        $cart_builder->orderBy('date_modified', 'DESC');

        $cart_query = $cart_builder->get();

        foreach ($cart_query->getResult() as $result) {
            // Get product info
            $product_builder = $this->db->table('product p');

            $product_builder->distinct("*, pd.name AS name");
            
            $product_builder->join('product_description pd', 'p.product_id = pd.product_id', 'left');
    
            $product_builder->where('p.product_id', $result->product_id);
            $product_builder->where('pd.language_id', $this->setting->get('setting_marketplace_language_id'));
            $product_builder->where('p.status', 1);
    
            $product_query = $product_builder->get();
            
            if ($product = $product_query->getRow()) {
                // Get options
                $option_data = [];

                if (is_array(json_decode($result->option, true))) {
                    $options = json_decode($result->option, true);
                } else {
                    $options = [];
                }

                foreach ($options as $key => $value) {
                    // Get option
                    $option_builder = $this->db->table('option o');
                    
                    $option_builder->where('o.option_id', $key);

                    $option_query = $option_builder->get();

                    if ($option_row = $option_query->getRow()) {
                        // Get option description
                        $option_description_data = [];

                        $option_description_builder = $this->db->table('option_description');
                    
                        $option_description_builder->where('option_id', $key);

                        $option_description_query = $option_description_builder->get();

                        foreach ($option_description_query->getResult() as $option_description) {
                            $option_description_data[$option_description->language_id] = [
                                'name' => $option_description->name,
                            ];
                        }

                        // Get option value
                        $option_value_data = [];

                        $option_value_builder = $this->db->table('option_value ov');
                        
                        $option_value_builder->where('ov.option_id', $key);
                        $option_value_builder->where('ov.option_value_id', $value);

                        $option_value_query = $option_value_builder->get();

                        if ($option_value_row = $option_value_query->getRow()) {
                            // Get option value description
                            $option_value_description_data = [];

                            $option_value_description_builder = $this->db->table('option_value_description');
                        
                            $option_value_description_builder->where('option_id', $key);
                            $option_value_description_builder->where('option_value_id', $value);

                            $option_value_description_query = $option_value_description_builder->get();

                            foreach ($option_value_description_query->getResult() as $option_value_description) {
                                $option_value_description_data[$option_value_description->language_id] = [
                                    'name' => $option_value_description->name,
                                ];
                            }

                            $option_value_data = [
                                'option_id' => $option_value_row->option_id,
                                'option_value_id' => $option_value_row->option_value_id,
                                'seller_id' => $option_value_row->seller_id,
                                'customer_id' => $option_value_row->customer_id,
                                'description' => $option_value_description_data,
                                'sort_order' => $option_value_row->sort_order,
                                'status' => $option_value_row->status,
                            ];
                        }

                        $option_data[] = [
                            'option_id' => $option_row->option_id,
                            'seller_id' => $option_row->seller_id,
                            'customer_id' => $option_row->customer_id,
                            'description' => $option_description_data,
                            'sort_order' => $option_row->sort_order,
                            'status' => $option_row->status,
                            'option_value' => $option_value_data,
                        ];
                    }
                }

                $option_data_sort_order = [];

                foreach ($option_data as $key => $value) {
                    $option_data_sort_order[$key] = $value['sort_order'];
                }

                array_multisort($option_data_sort_order, SORT_ASC, $option_data);

                // Product variant
                if (!empty($product->product_option)) {
                    // Get product variant info
                    $product_variant_builder = $this->db->table('product_variant');
                    
                    $product_variant_builder->where('options', $result->option);

                    $product_variant_query = $product_variant_builder->get();

                    if ($product_variant_row = $product_variant_query->getRow()) {
                        $price = $product_variant_row->price;
                        $weight = $product_variant_row->weight;
                    } else {
                        $price = $product->price;
                        $weight = $product->weight;
                    }
                } else {
                    $price = $product->price;
                    $weight = $product->weight;
                }

                $products[] = [
                    'cart_id' => $result->cart_id,
                    'customer_id' => $result->customer_id,
                    'seller_id' => $result->seller_id,
                    'product_id' => $result->product_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'slug' => $product->slug,
                    'product_option' => $product->product_option,
                    'price' => $price,
                    'weight' => $weight,
                    'weight_class_id' => $product->weight_class_id,
                    'main_image' => $product->main_image,
                    'quantity' => $result->quantity,
                    'total' => $price * $result->quantity,
                    'date_added' => $result->date_added,
                    'option' => $option_data,
                    'option_ids' => $result->option,
                ];
            }
        }

        return $products;
    }

    /**
     * Cart get sellers.
     *
     */
    public function getSellers()
    {
        $sellers = [];

        if ($this->session->has('customer_session_token')) {
            // Get customer id
            $customer_id = $this->session->get('customer_id_' . $this->session->get('customer_session_token'));
        } else {
            // Get customer id
            $customer_id = 0;
        }

        // Get cart sellers
        $cart_builder = $this->db->table('cart');

        $cart_builder->where('customer_id', $customer_id);
        $cart_builder->where('key', $this->getKey());

        $cart_builder->groupBy('seller_id');

        $cart_query = $cart_builder->get();

        foreach ($cart_query->getResult() as $result) {
            // Get seller info
            $seller_builder = $this->db->table('seller');

            $seller_builder->where('seller_id', $result->seller_id);
            $seller_builder->where('status', 1);

            $seller_query = $seller_builder->get();

            if ($seller = $seller_query->getRow()) {
                $sellers[] = [
                    'seller_id' => $seller->seller_id,
                    'customer_id' => $seller->customer_id,
                    'store_name' => $seller->store_name,
                    'store_description' => $seller->store_description,
                    'date_added' => $seller->date_added,
                    'date_modified' => $seller->date_modified,
                    'status' => $seller->status,
                ];
            }
        }

        return $sellers;
    }

    /**
     * Cart get key.
     *
     */
    public function getKey()
    {
        return $this->key;
    }
}