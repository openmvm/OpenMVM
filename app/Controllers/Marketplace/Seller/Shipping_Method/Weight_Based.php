<?php

namespace App\Controllers\Marketplace\Seller\Shipping_Method;

class Weight_Based extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \App\Models\Marketplace\Localisation\Language_Model();
        $this->model_localisation_country = new \App\Models\Marketplace\Localisation\Country_Model();
        $this->model_system_setting = new \App\Models\Marketplace\System\Setting_Model();
        $this->model_seller_shipping_method = new \App\Models\Marketplace\Seller\Shipping_Method_Model();
    }

    public function index()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['action'] = $this->url->customerLink('marketplace/seller/shipping_method/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('rate', lang('Entry.rate'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_shipping_method->editShippingMethod($this->customer->getSellerId(), 'Weight_Based', $this->request->getPost());

                $this->session->set('success', lang('Success.shipping_method_edit'));

                return redirect()->to($this->url->customerLink('marketplace/seller/component/shipping_method', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('rate')) {
                    $data['error_rate'] = $this->validation->getError('rate');
                } else {
                    $data['error_rate'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_dashboard'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.shipping_methods'),
            'href' => $this->url->customerLink('marketplace/seller/component/shipping_method', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.weight_based'),
            'href' => $this->url->customerLink('marketplace/seller/shipping_method/weight_based', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.weight_based');

        $seller_shipping_method_info = $this->model_seller_shipping_method->getShippingMethod($this->uri->getSegment($this->uri->getTotalSegments()), $this->customer->getSellerId());

        if ($this->request->getPost('rate')) {
            $data['rates'] = $this->request->getPost('rate');
        } elseif ($seller_shipping_method_info) {
            $data['rates'] = $seller_shipping_method_info['rate'];
        } else {
            $data['rates'] = [];
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($seller_shipping_method_info) {
            $data['status'] = $seller_shipping_method_info['status'];
        } else {
            $data['status'] = $this->model_system_setting->getSettingValue('status');
        }

        $data['countries'] = $this->model_localisation_country->getCountries();
        $data['country_request'] = $this->url->customerLink('marketplace/localisation/country/get_country', '', true);

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->customerLink('marketplace/seller/component/shipping_method', '', true);

        $data['customer_token'] = $this->customer->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.shipping_methods'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\Shipping_Method\weight_based', $data);
    }
}
