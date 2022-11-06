<?php

namespace Main\Marketplace\Controllers\Common;

class Cart extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Libraries
        $this->request = \Config\Services::request();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->cart = new \App\Libraries\Cart();
        $this->currency = new \App\Libraries\Currency();
        $this->url = new \App\Libraries\Url();
        $this->weight = new \App\Libraries\Weight();
        $this->image = new \App\Libraries\Image();
    }

    public function index($cart_params = array())
    {
        // Get cart sellers
        $data['sellers'] = [];

        $sellers = $this->cart->getSellers();

        $total_products = 0;

        foreach ($sellers as $seller) {
            // Get cart products
            $product_data = [];

            $products = $this->cart->getProducts($seller['seller_id']);

            foreach ($products as $product) {
                // Image
                if (ROOTPATH . 'public/assets/images' . $product['main_image']) {
                    $thumb = $this->image->resize($product['main_image'], 64, 64, true);
                } else {
                    $thumb = $this->image->resize('no_image.png', 64, 64, true);
                }

                $product_data[] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'thumb' => $thumb,
                    'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                    'quantity' => $product['quantity'],
                    'total' => $this->currency->format($product['total'], $this->currency->getCurrentCode()),
                    'option' => $product['option'],
                    'product_variant' => $product['option_ids'],
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                ];
            }

            $data['sellers'][] = [
                'seller_id' => $seller['seller_id'],
                'store_name' => $seller['store_name'],
                'product' => $product_data,
                'weight' => $this->weight->format($this->cart->getWeight($seller['seller_id']), $this->setting->get('setting_marketplace_weight_class_id'), lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode())),
                'checkout' => $this->url->customerLink('marketplace/checkout/checkout', ['seller_id' => $seller['seller_id']], true),
            ];

            $total_products += $this->cart->getTotalProducts($seller['seller_id']);
        }

        $data['total_products'] = $total_products;

        $data['shopping_cart'] = $this->url->customerLink('marketplace/checkout/cart', '', true);
        $data['checkout'] = $this->url->customerLink('marketplace/checkout/checkout', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\cart',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
