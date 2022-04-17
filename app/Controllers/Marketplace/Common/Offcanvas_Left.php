<?php

namespace App\Controllers\Marketplace\Common;

class Offcanvas_Left extends \App\Controllers\BaseController
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
        // Model
        $this->model_product_category = new \App\Models\Marketplace\Product\Category_Model();
    }

    public function index($offcanvas_left_params = array())
    {
        $data['base'] = base_url();

        $data['logged_in'] = $this->customer->isLoggedIn();

        if ($this->customer->isLoggedIn()) {
            $data['hello'] = sprintf(lang('Text.hello_customer'), $this->customer->getFirstname());
        } else {
            $data['hello'] = sprintf(lang('Text.hello_customer'), lang('Text.guest'));
        }

        // Categories
        $data['categories'] = [];

        $categories = $this->model_product_category->getCategories(0);

        foreach ($categories as $category) {
            // Level 2
            $children_data = [];

            $children = $this->model_product_category->getCategories($category['category_id']);

            foreach ($children as $child) {
                $sub_children_data = [];
                
                $sub_children = $this->model_product_category->getCategories($child['category_id']);

                foreach ($sub_children as $sub_child) {
                    $sub_children_data[] = [
                        'category_id' => $sub_child['category_id'],
                        'name' => $sub_child['name'],
                        'href' => $this->url->customerLink('marketplace/product/category/get/' . $sub_child['slug'] . '-c' . $sub_child['category_id']),
                    ];
                }

                $children_data[] = [
                    'category_id' => $child['category_id'],
                    'name' => $child['name'],
                    'children' => $sub_children_data,
                    'href' => $this->url->customerLink('marketplace/product/category/get/' . $child['slug'] . '-c' . $child['category_id']),
                ];
            }

            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name' => $category['name'],
                'children' => $children_data,
                'href' => $this->url->customerLink('marketplace/product/category/get/' .  $category['slug'] . '-c' . $category['category_id']),
            ];
        }

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\offcanvas_left', $data);
    }
}
