<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Menu extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            // Links
            $data['url_seller_dashboard'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);
            $data['url_seller_edit'] = $this->url->customerLink('marketplace/seller/edit', '', true);
            $data['url_seller_category'] = $this->url->customerLink('marketplace/seller/seller_category', '', true);
            $data['url_seller_product'] = $this->url->customerLink('marketplace/seller/product', '', true);
            $data['url_seller_option'] = $this->url->customerLink('marketplace/seller/option', '', true);
            $data['url_seller_order'] = $this->url->customerLink('marketplace/seller/order', '', true);
            $data['url_seller_product_question'] = $this->url->customerLink('marketplace/seller/product_question', '', true);
            $data['url_seller_localisation_geo_zone'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true);
            $data['url_seller_component_shipping_method'] = $this->url->customerLink('marketplace/seller/component/shipping_method', '', true);

            $data['widget'] = $widget++;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Appearance\Marketplace\Widgets\seller_menu',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
