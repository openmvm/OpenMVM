<?php

namespace Main\Marketplace\Controllers\Component\Payment_Method;

class Free_Checkout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
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
        $this->model_account_wallet = new \Main\Marketplace\Models\Account\Wallet_Model();
        $this->model_account_wallet_temp = new \Main\Marketplace\Models\Account\Wallet_Temp_Model();
        $this->model_component_component = new \Main\Marketplace\Models\Component\Component_Model();
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_checkout_order = new \Main\Marketplace\Models\Checkout\Order_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index($seller_id)
    {
        $data['instruction'] = nl2br($this->setting->get('component_payment_method_free_checkout_instruction_' . $this->language->getCurrentId()));

        if (!empty($seller_id)) {
            $data['confirm'] = $this->url->customerLink('marketplace/component/payment_method/free_checkout/confirm', ['seller_id' => $seller_id], true);
        } else {
            $data['confirm'] = $this->url->customerLink('marketplace/component/payment_method/free_checkout/confirm', '', true);
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Component\Payment_Method\free_checkout',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function confirm()
    {
        $json = [];

        if ($this->session->has('checkout_payment_method_code') && $this->session->get('checkout_payment_method_code') == 'Free_Checkout') {
            $error = false;

            if (!$error) {
                // Get languages
                $languages = $this->model_localisation_language->getLanguages();

                // Get cart sellers
                if (!empty($this->request->getGet('seller_id'))) {
                    $seller_info = $this->model_seller_seller->getSeller($this->request->getGet('seller_id'));

                    if ($seller_info) {
                        $sellers = [$seller_info];
                    } else {
                        $sellers = [];
                    }
                } else {
                    $sellers = $this->cart->getSellers();
                }

                foreach ($sellers as $seller) {
                    // Add order status history
                    $order_id = $this->session->get('checkout_order_id');

                    $order_status_id = $this->setting->get('component_payment_method_free_checkout_order_status_id');

                    $comment = [];

                    foreach ($languages as $language) {
                        if (!empty($this->setting->get('component_payment_method_free_checkout_instruction_' . $language['language_id']))) {
                            $comment[$language['language_id']] = $this->setting->get('component_payment_method_free_checkout_instruction_' . $language['language_id']);
                        }
                    }

                    $notify = true;

                    $this->model_checkout_order->addOrderStatusHistory($order_id, $seller['seller_id'], $order_status_id, $comment, $notify);
                }

                // Set the order id
                $this->session->set('customer_order_id', $order_id);

                // Update the order payment method text
                $this->model_checkout_order->editOrderPaymentMethodText($this->customer->getId(), $this->session->get('customer_order_id'), nl2br($this->setting->get('component_payment_method_free_checkout_instruction_' . $this->language->getCurrentId())));

                $json['redirect'] = $this->url->customerLink('marketplace/checkout/success', '', true);

                $json['success'] = true;
            } else {
                $json['error'] = true;
            }
        } else {
            $json['error'] = true;
        }

        return $this->response->setJSON($json);
    }
}
