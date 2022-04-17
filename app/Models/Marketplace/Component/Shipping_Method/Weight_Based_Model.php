<?php

namespace App\Models\Marketplace\Component\Shipping_Method;

use CodeIgniter\Model;

class Weight_Based_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->cart = new \App\Libraries\Cart();
        $this->currency = new \App\Libraries\Currency();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->weight = new \App\Libraries\Weight();
    }

    public function method($customer_address_id, $seller_id)
    {
        $method_data = [];

        if (!$this->setting->get('component_shipping_method_weight_based_status')) {
            return false;
        }

        // Get customer address
        $customer_address_builder = $this->db->table('customer_address');
        
        $customer_address_builder->where('customer_address_id', $customer_address_id);

        $customer_address_query = $customer_address_builder->get();

        if ($row = $customer_address_query->getRow()) {
            $country_id = $row->country_id;

            // Get country info
            $country_builder = $this->db->table('country');
            $country_builder->where('country_id', $country_id);
            $country_query = $country_builder->get();
            $country_row = $country_query->getRow();

            $country_name = $country_row->name;

            $zone_id = $row->zone_id;

            // Get zone info
            $zone_builder = $this->db->table('zone');
            $zone_builder->where('zone_id', $zone_id);
            $zone_query = $zone_builder->get();
            $zone_row = $zone_query->getRow();

            $zone_name = $zone_row->name;
        } else {
            $country_id = 0;
            $zone_id = 0;
        }

        $weight = $this->cart->getWeight($seller_id);

        // Get seller flat rate shipping rates
        $row = [];
        $cost = 0;

        $seller_shipping_method_builder = $this->db->table('seller_shipping_method');
        
        $seller_shipping_method_builder->where('seller_id', $seller_id);
        $seller_shipping_method_builder->where('code', 'Weight_Based');
        $seller_shipping_method_builder->where('status', 1);

        $seller_shipping_method_query = $seller_shipping_method_builder->get();

        if ($seller_shipping_method_query->getRow()) {
            $row = $seller_shipping_method_query->getRow();

            $rates = json_decode($row->rate, true);

            foreach ($rates as $rate) {
                if ($rate['country_id'] == $country_id && ($rate['zone_id'] == $zone_id || $rate['zone_id'] == 0)) {
                    foreach ($rate['weight'] as $rate_weight) {
                        if ($rate_weight['weight'] >= $weight) {
                            $cost = $rate_weight['rate'];

                            break;
                        }
                    }

                    break;
                }
            }
        } else {
            return false;
        }

        if ($cost == 0) {
            return false;
        }

        $quote_data['Weight_Based.Weight_Based'] = [
            'code' => 'Weight_Based.Weight_Based',
            'cost' => $cost,
            'cost_formatted' => $this->currency->format($cost, $this->currency->getCurrentCode()),
            'text' => lang('Text.weight_based') . ' (' . $zone_name . ', ' . $country_name . ') (' . lang('Text.weight') . ': ' . $this->weight->format($weight, $this->setting->get('setting_marketplace_weight_class_id'), lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode())) . ')',
        ];

        $method_data = [
            'code' => 'Weight_Based',
            'name' => lang('Text.weight_based'),
            'sort_order' => $this->setting->get('component_shipping_method_weight_based_sort_order'),
            'quote_data' => $quote_data,
        ];

        return $method_data;
    }

}