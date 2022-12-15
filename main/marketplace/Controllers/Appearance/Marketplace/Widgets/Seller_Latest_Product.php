<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Latest_Product extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->currency = new \App\Libraries\Currency();
        $this->image = new \App\Libraries\Image();
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
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

            // Get seller ID
            $uri_strings = explode('/', uri_string());

            $explode = explode('-', end($uri_strings));

            $seller_id = str_replace('s', '', end($explode));

            // Get seller products
            $data['products'] = [];

            $filter_data = [
                'filter_seller_id' => $seller_id,
                'sort' => 'p.date_added',
                'order' => 'DESC',
            ];

            $products = $this->model_product_product->getProducts($filter_data);

            foreach ($products as $product) {
                // Image
                if (is_file(ROOTPATH . 'public/assets/images/' . $product['main_image'])) {
                    $thumb = $this->image->resize($product['main_image'], 256, 256, true);
                } else {
                    $thumb = $this->image->resize('no_image.png', 256, 256, true);
                }

                // Get product variant min max prices
                if (!empty($product['product_option'])) {
                    $product_variant_price = $this->model_product_product->getProductVariantMinMaxPrices($product['product_id']);

                    $min_price = $this->currency->format($product_variant_price['min_price'], $this->currency->getCurrentCode());
                    $max_price = $this->currency->format($product_variant_price['max_price'], $this->currency->getCurrentCode());
                } else {
                    $min_price = null;
                    $max_price = null;
                }

                // Special
                if (!is_null($product['special']) && $product['special'] >= 0) {
                    $special = $this->currency->format($product['special'], $this->currency->getCurrentCode());
                } else {
                    $special = false;
                }

                // Get product variant special min max prices
                if (!empty($product['product_option'])) {
                    if (!empty($product['product_variant_special'])) {
                        $product_variant_special_price = $this->model_product_product->getProductVariantSpecialMinMaxPrices($product['product_id']);

                        $special_min_price = $this->currency->format($product_variant_special_price['min_price'], $this->currency->getCurrentCode());
                        $special_max_price = $this->currency->format($product_variant_special_price['max_price'], $this->currency->getCurrentCode());
                    } else {
                        $special_min_price = null;
                        $special_max_price = null;
                    }
                } else {
                    $special_min_price = null;
                    $special_max_price = null;
                }

                $data['products'][] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'thumb' => $thumb,
                    'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                    'special' => $special,
                    'product_option' => $product['product_option'],
                    'product_variant_special' => $product['product_variant_special'],
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                    'special_min_price' => $special_min_price,
                    'special_max_price' => $special_max_price,
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                ];
            }

            $data['widget'] = $widget++;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Appearance\Marketplace\Widgets\seller_latest_product',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
