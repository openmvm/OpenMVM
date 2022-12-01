<?php

namespace Main\Marketplace\Models\Component\Payment_Method;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Free_Checkout_Model extends Model
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

        if (!$this->setting->get('component_payment_method_free_checkout_status')) {
            return false;
        }

        if ($total > 0.00) {
            return false;
        }

        $method_data = [
            'code' => 'Free_Checkout',
            'name' => lang('Text.free_checkout', [], $this->language->getCurrentCode()),
            'sort_order' => $this->setting->get('component_payment_method_free_checkout_sort_order'),
        ];

        return $method_data;
    }

}