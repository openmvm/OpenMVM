<?php

namespace App\Controllers\Marketplace\Common;

class Offcanvas_Right extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->customer= new \App\Libraries\Customer();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        $this->cart = new \App\Libraries\Cart();
        // Model
        $this->model_product_category = new \App\Models\Marketplace\Product\Category_Model();
    }

    public function index($offcanvas_right_params = array())
    {
        $data['base'] = base_url();

        $data['logged_in'] = $this->customer->isLoggedIn();

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\offcanvas_right', $data);
    }
}
