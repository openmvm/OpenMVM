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

class Wishlist {
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

        // Remove all expired wishlist items with no customer_id
        $now =  new Time('-1 hour');

        $builder = $this->db->table('wishlist');

        $builder->where('customer_id', 0);
        $builder->where('date_added <', $now);
        $builder->delete();

        // Wishlist key
        if ($this->session->has('wishlist_key')) {
            $this->key = $this->session->get('wishlist_key');
        } else {
            $wishlist_key = bin2hex(random_bytes(20));

            $this->session->set('wishlist_key', $wishlist_key);

            $this->key = $this->session->get('wishlist_key');
        }

        // If customer is logged in
        if ($this->session->has('customer_session_token')) {
            // Get customer id
            $customer_id = $this->session->get('customer_id_' . $this->session->get('customer_session_token'));

            // Update customer wishlist key
            $wishlist_update_builder = $this->db->table('wishlist');

            $wishlist_update_builder->set('key', $this->key);

            $wishlist_update_builder->where('customer_id', $customer_id);

            $wishlist_update_builder->update();

            // Get wishlists that have customer id = 0 by key
            $wishlist_builder = $this->db->table('wishlist');
        
            $wishlist_builder->where('customer_id', 0);
            $wishlist_builder->where('key', $this->key);

            $wishlist_query = $wishlist_builder->get();
    
            foreach ($wishlist_query->getResult() as $result) {
                // Add wishlist to customer
                $this->add($customer_id, $result->product_id);

                // Delete wishlist
                $wishlist_delete_builder = $this->db->table('wishlist');

                $wishlist_delete_builder->where('wishlist_id', $result->wishlist_id);
                $wishlist_delete_builder->delete();
            }
        }
    }

    /**
     * Wishlist remove.
     *
     */
    public function remove($customer_id, $product_id)
    {
        $wishlist_builder = $this->db->table('wishlist');

        $wishlist_builder->where('customer_id', $customer_id);
        $wishlist_builder->where('product_id', $product_id);
        $wishlist_builder->where('key', $this->getKey());
        $wishlist_builder->delete();
    }

    /**
     * Wishlist add.
     *
     */
    public function add($customer_id, $product_id)
    {
        $wishlist_builder = $this->db->table('wishlist');
        
        $wishlist_builder->where('customer_id', $customer_id);
        $wishlist_builder->where('product_id', $product_id);
        $wishlist_builder->where('key', $this->getKey());

        $wishlist_query = $wishlist_builder->get();

        if ($row = $wishlist_query->getRow()) {
            // Update wishlist
            $wishlist_update_builder = $this->db->table('wishlist');

            $wishlist_update_builder->set('date_modified', new Time('now'));

            $wishlist_update_builder->where('customer_id', $customer_id);
            $wishlist_update_builder->where('product_id', $product_id);
            $wishlist_update_builder->where('key', $this->getKey());

            $wishlist_update_builder->update();
        } else {
            // Insert wishlist
            $wishlist_insert_builder = $this->db->table('wishlist');

            $wishlist_insert_data = [
                'customer_id' => $customer_id,
                'key' => $this->getKey(),
                'product_id' => $product_id,
                'date_added' => new Time('now'),
                'date_modified' => new Time('now'),
            ];
            
            $wishlist_insert_builder->insert($wishlist_insert_data);
        }
    }

    /**
     * Wishlist check.
     *
     */
    public function check($customer_id, $product_id)
    {
        $wishlist_builder = $this->db->table('wishlist');
        
        $wishlist_builder->where('customer_id', $customer_id);
        $wishlist_builder->where('product_id', $product_id);
        $wishlist_builder->where('key', $this->getKey());

        $wishlist_query = $wishlist_builder->get();

        if ($row = $wishlist_query->getRow()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Wishlist get products.
     *
     */
    public function getProducts($customer_id)
    {
        $products = [];

        if ($this->session->has('customer_session_token')) {
            // Get customer id
            $customer_id = $this->session->get('customer_id_' . $this->session->get('customer_session_token'));
        } else {
            // Get customer id
            $customer_id = 0;
        }

        // Get wishlists
        $wishlist_builder = $this->db->table('wishlist');
    
        $wishlist_builder->where('customer_id', $customer_id);
        $wishlist_builder->where('key', $this->getKey());

        $wishlist_builder->orderBy('date_modified', 'DESC');

        $wishlist_query = $wishlist_builder->get();

        foreach ($wishlist_query->getResult() as $result) {
            // Get product info
            $product_builder = $this->db->table('product p');

            $product_builder->distinct("*, pd.name AS name");
            
            $product_builder->join('product_description pd', 'p.product_id = pd.product_id', 'left');
    
            $product_builder->where('p.product_id', $result->product_id);
            $product_builder->where('pd.language_id', $this->setting->get('setting_marketplace_language_id'));
            $product_builder->where('p.status', 1);
    
            $product_query = $product_builder->get();
            
            if ($product = $product_query->getRow()) {
                $products[] = [
                    'wishlist_id' => $result->wishlist_id,
                    'customer_id' => $result->customer_id,
                    'seller_id' => $product->seller_id,
                    'product_id' => $product->product_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'product_option' => $product->product_option,
                    'weight' => $product->weight,
                    'weight_class_id' => $product->weight_class_id,
                    'main_image' => $product->main_image,
                    'quantity' => $product->quantity,
                    'date_added' => $product->date_added,
                ];
            }
        }

        return $products;
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