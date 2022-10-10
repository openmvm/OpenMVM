<?php

namespace Main\Marketplace\Controllers\Common;

class Header extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->customer= new \App\Libraries\Customer();
        $this->image= new \App\Libraries\Image();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Common Controllers
        $this->marketplace_search = new \Main\Marketplace\Controllers\Common\Search();
        $this->marketplace_language = new \Main\Marketplace\Controllers\Common\Language();
        $this->marketplace_currency = new \Main\Marketplace\Controllers\Common\Currency();
        $this->marketplace_cart = new \Main\Marketplace\Controllers\Common\Cart();
        $this->marketplace_offcanvas_left = new \Main\Marketplace\Controllers\Common\Offcanvas_Left();
        $this->marketplace_offcanvas_right = new \Main\Marketplace\Controllers\Common\Offcanvas_Right();
        // Models
        $this->model_component_component = new \Main\Marketplace\Models\Component\Component_Model();

    }

    public function index($header_params = array())
    {
        $data['base'] = base_url();
        $data['title'] = $header_params['title'];
        $data['uri_string'] = uri_string();
        
        $uri_strings = explode('/', ltrim(uri_string(), '/'));

        $num_uri_strings = count($uri_strings);

        for ($i = 0; $i < $num_uri_strings; $i++) {
            if ($i == 0) {
              for ($j = $i; $j < $num_uri_strings; $j++) {
                    $segment = array();
                for ($k = $i; $k <= $j; $k++) {
                  $segment[] = "/" . $uri_strings[$k];
                }
                    $segments[] = $segment;
              }
            }
        }

        foreach ($segments as $segment) {
            $routes[] = implode('', $segment);
        }

        $data['routes'] = json_encode($routes, true);

        // Scripts
        if (!empty($header_params['scripts'])) {
            foreach ($header_params['scripts'] as $script) {
                $scripts[] = $script;
            }
        } else {
            $scripts = [];
        }

        $data['scripts'] = array_unique($scripts);

        // Styles
        if (!empty($header_params['styles'])) {
            foreach ($header_params['styles'] as $style) {
                $styles[] = $style;
            }
        } else {
            $styles = [];
        }

        $data['styles'] = array_unique($styles);

        // Breadcrumbs
        if (!empty($header_params['breadcrumbs'])) {
            $data['breadcrumbs'] = $header_params['breadcrumbs'];
        } else {
            $data['breadcrumbs'] = [];
        }

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['logged_in'] = $this->customer->isLoggedIn();
        $data['my_account'] = $this->url->customerLink('marketplace/account/account', '', true);
        $data['my_orders'] = $this->url->customerLink('marketplace/account/order', '', true);
        $data['edit_profile'] = $this->url->customerLink('marketplace/account/profile', '', true);
        $data['my_address_book'] = $this->url->customerLink('marketplace/account/address', '', true);
        $data['seller_register'] = $this->url->customerLink('marketplace/seller/register', '', true);
        $data['seller_dashboard'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);
        $data['seller_edit'] = $this->url->customerLink('marketplace/seller/edit', '', true);
        $data['seller_product'] = $this->url->customerLink('marketplace/seller/product', '', true);
        $data['seller_option'] = $this->url->customerLink('marketplace/seller/option', '', true);
        $data['seller_order'] = $this->url->customerLink('marketplace/seller/order', '', true);
        $data['seller_shipping_method'] = $this->url->customerLink('marketplace/seller/component/shipping_method', '', true);
        $data['seller_geo_zone'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true);

        if ($this->customer->isLoggedIn()) {
            $data['firstname'] = $this->customer->getFirstname();
        }

        if ($this->customer->isSeller()) {
            $data['is_seller'] = true;
        } else {
            $data['is_seller'] = false;
        }

        // Logo
        if (!empty($this->setting->get('setting_logo')) && is_file(ROOTPATH . 'public/assets/images/' . $this->setting->get('setting_logo'))) {
            $data['logo'] = $this->image->resize($this->setting->get('setting_logo'), 100, 100, true);
        } else {
            $data['logo'] = '';
        }

        if (!empty($this->setting->get('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->setting->get('setting_favicon'))) {
            $data['favicon'] = $this->image->resize($this->setting->get('setting_favicon'), 100, 100, true);
        } else {
            $data['favicon'] = '';
        }

        $data['marketplace_name'] = $this->setting->get('marketplace_name');

        // Get component analytics
        $analytics = [];

        $installed_analytics = $this->model_component_component->getInstalledComponents('analytics');

        foreach ($installed_analytics as $installed_analytics) {
            $namespace = '\Main\Marketplace\Controllers\Component\Analytics\\' . $installed_analytics['value'];

            $this->analytics = new $namespace;

            $data['analytics'][] = $this->analytics->index();
        }

        // Search
        $search_params = array();
        $data['search'] = $this->marketplace_search->index($search_params);
        // Language
        $language_params = array();
        $data['language'] = $this->marketplace_language->index($language_params);
        // Currency
        $currency_params = array();
        $data['currency'] = $this->marketplace_currency->index($currency_params);
        // Cart
        $cart_params = array();
        $data['cart'] = $this->marketplace_cart->index($cart_params);
        // Offcanvas Left
        $offcanvas_left_params = array();
        $data['offcanvas_left'] = $this->marketplace_offcanvas_left->index($offcanvas_left_params);
        // Offcanvas Right
        $offcanvas_right_params = array();
        $data['offcanvas_right'] = $this->marketplace_offcanvas_right->index($offcanvas_right_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\header',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
