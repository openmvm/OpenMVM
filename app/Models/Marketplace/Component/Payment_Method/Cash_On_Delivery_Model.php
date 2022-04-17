<?php

namespace App\Models\Marketplace\Component\Payment_Method;

use CodeIgniter\Model;

class Cash_On_Delivery_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    public function method($customer_address_id = 0)
    {
        $method_data = [];

        if (!$this->setting->get('component_payment_method_cash_on_delivery_status')) {
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
        
        $zone_to_geo_zone_builder->where('geo_zone_id', $this->setting->get('component_payment_method_cash_on_delivery_geo_zone_id'));
        $zone_to_geo_zone_builder->where('country_id', $country_id);
        $zone_to_geo_zone_builder->where("(zone_id = '0' OR zone_id = '" . $zone_id . "')");

        $zone_to_geo_zone_query = $zone_to_geo_zone_builder->get();

        if (!$zone_to_geo_zone_query->getRow()) {
            return false;
        }

        $method_data = [
            'code' => 'Cash_On_Delivery',
            'name' => lang('Text.cash_on_delivery'),
            'sort_order' => $this->setting->get('component_payment_method_cash_on_delivery_sort_order'),
        ];

        return $method_data;
    }

}