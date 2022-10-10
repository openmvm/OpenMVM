<?php

namespace Main\Marketplace\Controllers\Seller\Shipping_Method;

class Flat_Rate extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \Main\Marketplace\Models\Localisation\Geo_Zone_Model();
        $this->model_system_setting = new \Main\Marketplace\Models\System\Setting_Model();
        $this->model_seller_shipping_method = new \Main\Marketplace\Models\Seller\Shipping_Method_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/seller/shipping_method/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('rate', lang('Entry.rate', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_shipping_method->editShippingMethod($this->customer->getSellerId(), 'Flat_Rate', $this->request->getPost());

                $this->session->set('success', lang('Success.shipping_method_edit', [], $this->language->getCurrentCode()));

                return redirect()->to($this->url->customerLink('marketplace/seller/component/shipping_method', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form', [], $this->language->getCurrentCode()));

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
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_dashboard', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.shipping_methods', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/component/shipping_method', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.flat_rate', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/shipping_method/flat_rate', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.flat_rate', [], $this->language->getCurrentCode());

        $seller_shipping_method_info = $this->model_seller_shipping_method->getShippingMethod($this->uri->getSegment($this->uri->getTotalSegments()), $this->customer->getSellerId());

        if ($this->request->getPost('rate')) {
            $data['rate'] = $this->request->getPost('rate');
        } elseif ($seller_shipping_method_info) {
            $data['rate'] = $seller_shipping_method_info['rate'];
        } else {
            $data['rate'] = $this->model_system_setting->getSettingValue('rate');
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($seller_shipping_method_info) {
            $data['status'] = $seller_shipping_method_info['status'];
        } else {
            $data['status'] = $this->model_system_setting->getSettingValue('status');
        }

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->customerLink('marketplace/seller/shipping_method', '', true);

        $data['customer_token'] = $this->customer->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.shipping_methods', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\Shipping_Method\flat_rate',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
