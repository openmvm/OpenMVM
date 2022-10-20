<?php

namespace Main\Marketplace\Controllers\Checkout;

class Cart extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.shopping_cart', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/checkout/cart', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.shopping_cart', [], $this->language->getCurrentCode());

        // Get cart sellers
        $data['sellers'] = [];

        $sellers = $this->cart->getSellers();

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
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                ];
            }

            $data['sellers'][] = [
                'seller_id' => $seller['seller_id'],
                'store_name' => $seller['store_name'],
                'product' => $product_data,
                'checkout' => $this->url->customerLink('marketplace/checkout/checkout', ['seller_id' => $seller['seller_id']], true),
            ];
        }

        $data['shopping_cart'] = $this->url->customerLink('marketplace/checkout/cart', '', true);
        $data['checkout'] = $this->url->customerLink('marketplace/checkout/checkout', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.shopping_cart', [], $this->language->getCurrentCode()),
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
            'view' => 'Checkout\cart',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function add()
    {
        $json = [];

        // Get customer id
        if ($this->customer->isLoggedin()) {
            $customer_id = $this->customer->getId();
        } else {
            $customer_id = 0;
        }

        // Get product info
        if (!empty($this->request->getGet('product_id'))) {
            $product_id = $this->request->getGet('product_id');
        } else {
            $product_id = 0;
        }

        $product_info = $this->model_product_product->getProduct($product_id);

        // If product not found
        if (!$product_info) {
            $json['error'] = lang('Error.product_not_found', [], $this->language->getCurrentCode());
        }

        // If customer is the seller of this product
        if ($this->customer->getSellerId() == $product_info['seller_id']) {
            $json['error'] = lang('Error.customer_is_seller', [], $this->language->getCurrentCode());
        }

        if (empty($json['error'])) {
            $this->cart->add($customer_id, $product_info['seller_id'], $product_info['product_id'], $this->request->getPost('quantity'), $this->request->getPost('product_variant'));

            $json['success'] = lang('Success.add_to_cart', [], $this->language->getCurrentCode());
        }

        return $this->response->setJSON($json);
    }
}
