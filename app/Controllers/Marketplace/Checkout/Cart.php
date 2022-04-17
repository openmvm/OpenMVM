<?php

namespace App\Controllers\Marketplace\Checkout;

class Cart extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_product = new \App\Models\Marketplace\Product\Product_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.shopping_cart'),
            'href' => $this->url->customerLink('marketplace/checkout/cart', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.shopping_cart');

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
                    'quantity' => $product['quantity'],
                    'total' => $product['total'],
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

        // Header
        $header_params = array(
            'title' => lang('Heading.shopping_cart'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Checkout\cart', $data);
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
            $json['error'] = lang('Error.product_not_found');
        }

        // If customer is the seller of this product
        if ($this->customer->getSellerId() == $product_info['seller_id']) {
            $json['error'] = lang('Error.customer_is_seller');
        }

        if (empty($json['error'])) {
            $this->cart->add($customer_id, $product_info['seller_id'], $product_info['product_id'], $this->request->getPost('quantity'));

            $json['success'] = lang('Success.add_to_cart');
        }

        return $this->response->setJSON($json);
    }
}
