<?php

namespace Main\Marketplace\Models\Component\Shipping_Method;

use CodeIgniter\Model;

class Flat_Rate_Model extends Model
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

        // Check status
        if (!$this->setting->get('component_shipping_method_flat_rate_status')) {
            return false;
        }

        // Get customer address
        $customer_address_builder = $this->db->table('customer_address');
        
        $customer_address_builder->where('customer_address_id', $customer_address_id);

        $customer_address_query = $customer_address_builder->get();

        if ($row = $customer_address_query->getRow()) {
            $country_id = $row->country_id;
            $zone_id = $row->zone_id;
        } else {
            $country_id = 0;
            $zone_id = 0;
        }

        // Check zone to geo zone
        $zone_to_geo_zone_builder = $this->db->table('zone_to_geo_zone');
        
        $zone_to_geo_zone_builder->where('geo_zone_id', $this->setting->get('component_shipping_method_flat_rate_geo_zone_id'));
        $zone_to_geo_zone_builder->where('country_id', $country_id);
        $zone_to_geo_zone_builder->where("(zone_id = '0' OR zone_id = '" . $zone_id . "')");

        $zone_to_geo_zone_query = $zone_to_geo_zone_builder->get();

        if (!$zone_to_geo_zone_query->getRow()) {
            return false;
        }

        // Get seller flat rate shipping rates
        $row = [];

        $seller_shipping_method_builder = $this->db->table('seller_shipping_method');
        
        $seller_shipping_method_builder->where('seller_id', $seller_id);
        $seller_shipping_method_builder->where('code', 'Flat_Rate');
        $seller_shipping_method_builder->where('status', 1);

        $seller_shipping_method_query = $seller_shipping_method_builder->get();

        if (!$seller_shipping_method_query->getRow()) {
            return false;
        } else {
            $row = $seller_shipping_method_query->getRow();
        }

        if ($row->serialized) {
            $rate = json_decode($row->rate, true);
        } else {
            $rate = $row->rate;
        }

        $cost = $rate;

        $weight = $this->cart->getWeight($seller_id);

        $quote_data['Flat_Rate.Flat_Rate'] = [
            'code' => 'Flat_Rate.Flat_Rate',
            'cost' => $cost,
            'cost_formatted' => $this->currency->format($cost, $this->currency->getCurrentCode()),
            'text' => lang('Text.flat_rate') . ' (' . lang('Text.weight') . ': ' . $this->weight->format($weight, $this->setting->get('setting_marketplace_weight_class_id'), lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode())) . ')',
        ];

        $method_data = [
            'code' => 'Flat_Rate',
            'name' => lang('Text.flat_rate'),
            'sort_order' => $this->setting->get('component_shipping_method_flat_rate_sort_order'),
            'quote_data' => $quote_data,
        ];

        return $method_data;
    }

}