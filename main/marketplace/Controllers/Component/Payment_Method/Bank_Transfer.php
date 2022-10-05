<?php

namespace Main\Marketplace\Controllers\Component\Payment_Method;

class Bank_Transfer extends \App\Controllers\BaseController
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
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_checkout_order = new \Main\Marketplace\Models\Checkout\Order_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index($seller_id)
    {
        $data['instruction'] = nl2br($this->setting->get('component_payment_method_bank_transfer_instruction_' . $this->language->getCurrentId()));

        if (!empty($seller_id)) {
            $data['confirm'] = $this->url->customerLink('marketplace/component/payment_method/bank_transfer/confirm', ['seller_id' => $seller_id], true);
        } else {
            $data['confirm'] = $this->url->customerLink('marketplace/component/payment_method/bank_transfer/confirm', '', true);
        }

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Component\Payment_Method\bank_transfer', $data);
    }

    public function confirm()
    {
        $json = [];

        if ($this->session->has('checkout_payment_method_code') && $this->session->get('checkout_payment_method_code') == 'Bank_Transfer') {
            $error = false;

            if (!$error) {
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

                    $order_status_id = $this->setting->get('component_payment_method_bank_transfer_order_status_id');

                    $comment = $this->setting->get('component_payment_method_bank_transfer_instruction_' . $this->language->getCurrentId());

                    $notify = true;

                    $this->model_checkout_order->addOrderStatusHistory($order_id, $seller['seller_id'], $order_status_id, $comment, $notify);
                }

                // Set the order id
                $this->session->set('customer_order_id', $order_id);

                // Update the order payment method text
                $this->model_checkout_order->editOrderPaymentMethodText($this->customer->getId(), $this->session->get('customer_order_id'), nl2br($this->setting->get('component_payment_method_bank_transfer_instruction_' . $this->language->getCurrentId())));

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
