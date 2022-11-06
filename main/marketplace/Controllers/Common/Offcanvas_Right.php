<?php

namespace Main\Marketplace\Controllers\Common;

class Offcanvas_Right extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->customer= new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        $this->cart = new \App\Libraries\Cart();
        // Model
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
    }

    public function index($offcanvas_right_params = array())
    {
        $data['base'] = base_url();

        $data['logged_in'] = $this->customer->isLoggedIn();

        $data['cart_remove_url'] = $this->url->customerLink('marketplace/checkout/cart/remove');

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\offcanvas_right',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
