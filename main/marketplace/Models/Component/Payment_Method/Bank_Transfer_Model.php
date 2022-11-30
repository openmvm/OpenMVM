<?php

namespace Main\Marketplace\Models\Component\Payment_Method;

use CodeIgniter\Model;

class Bank_Transfer_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->customer = new \App\Libraries\Customer();
        $this->cart = new \App\Libraries\Cart();
        $this->currency = new \App\Libraries\Currency();
        $this->url = new \App\Libraries\Url();
        $this->weight = new \App\Libraries\Weight();

        // Models
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_checkout_order = new \Main\Marketplace\Models\Checkout\Order_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function method($customer_address_id = 0, $total)
    {
        $method_data = [];

        if (!$this->setting->get('component_payment_method_bank_transfer_status')) {
            return false;
        }

        if ($this->setting->get('component_payment_method_bank_transfer_amount') > 0 && $this->setting->get('component_payment_method_bank_transfer_amount') > $total) {
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
        
        $zone_to_geo_zone_builder->where('geo_zone_id', $this->setting->get('component_payment_method_bank_transfer_geo_zone_id'));
        $zone_to_geo_zone_builder->where('country_id', $country_id);
        $zone_to_geo_zone_builder->where("(zone_id = '0' OR zone_id = '" . $zone_id . "')");

        $zone_to_geo_zone_query = $zone_to_geo_zone_builder->get();

        if (!$zone_to_geo_zone_query->getRow()) {
            return false;
        }

        $method_data = [
            'code' => 'Bank_Transfer',
            'name' => lang('Text.bank_transfer'),
            'sort_order' => $this->setting->get('component_payment_method_bank_transfer_sort_order'),
        ];

        return $method_data;
    }

}