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

                $product_variant = $product['option_ids'];

                if (is_array($product_variant)) {
                    asort($product_variant);
                }

                $product_data[] = [
                    'cart_id' => $product['cart_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'thumb' => $thumb,
                    'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                    'quantity' => $product['quantity'],
                    'total' => $this->currency->format($product['total'], $this->currency->getCurrentCode()),
                    'option' => $product['option'],
                    'product_variant' => htmlentities($product_variant),
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                    'remove_cart' => $this->url->customerLink('marketplace/checkout/cart/remove?product_id=' . $product['product_id']),
                ];
            }

            $data['sellers'][] = [
                'seller_id' => $seller['seller_id'],
                'store_name' => $seller['store_name'],
                'product' => $product_data,
                'shipping_required' => $this->cart->hasShipping($seller['seller_id']),
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

        // Check if added product is already in the cart
        $cart_product = $this->cart->getProduct($customer_id, $product_info['seller_id'], $product_info['product_id'], $this->request->getPost('product_variant'));

        if (!empty($cart_product)) {
            $product_quantity_in_cart = $cart_product['quantity'];
        } else {
            $product_quantity_in_cart = 0;
        }

        // If quantity is below minimum purchase
        if (empty($this->request->getPost('product_variant'))) {
            $minimum_quantity_added_to_cart = (int)$product_info['minimum_purchase'] - (int)$product_quantity_in_cart;

            if ($this->request->getPost('quantity') < $minimum_quantity_added_to_cart) {
                $json['error'] = lang('Error.product_minimum_purchase', ['minimum_purchase' => $product_info['minimum_purchase']], $this->language->getCurrentCode());
            }
        }

        // Get product variant
        if (!empty($this->request->getPost('product_variant'))) {
            if (is_array($this->request->getPost('product_variant'))) {
                $product_variants = $this->request->getPost('product_variant');
                asort($product_variants);
            }

            $product_variant_info = $this->model_product_product->getProductVariantByOptions($product_id, json_encode($product_variants));

            if ($product_variant_info) {
                $product_variant_minimum_purchase = $product_variant_info['minimum_purchase'];
            } else {
                $product_variant_minimum_purchase = 1;
            }

            $minimum_quantity_added_to_cart = (int)$product_variant_minimum_purchase - (int)$product_quantity_in_cart;

            if ($this->request->getPost('quantity') < $minimum_quantity_added_to_cart) {
                $json['error'] = lang('Error.product_minimum_purchase', ['minimum_purchase' => $product_variant_minimum_purchase], $this->language->getCurrentCode());
                //$json['error'] = json_encode($product_variant_minimum_purchase);
            }
        }

        // If customer is the seller of this product
        if ($this->customer->getSellerId() == $product_info['seller_id']) {
            $json['error'] = lang('Error.customer_is_seller', [], $this->language->getCurrentCode());
            //$json['error'] = json_encode($this->request->getPost('product_variant'));
        }

        if (empty($json['error'])) {
            $this->cart->add($customer_id, $product_info['seller_id'], $product_info['product_id'], $this->request->getPost('quantity'), $this->request->getPost('product_variant'));

            $json['success'] = lang('Success.add_to_cart', [], $this->language->getCurrentCode());
        }

        return $this->response->setJSON($json);
    }

    public function remove()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

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
                $json['error']['product-variant'] = lang('Error.product_not_found', [], $this->language->getCurrentCode());
            }

            if (empty($json['error'])) {
                file_put_contents(WRITEPATH . 'temp/openmvm.log', json_encode($json_data));
                $this->cart->remove($customer_id, $product_info['seller_id'], $product_info['product_id'], $json_data['product_variant'], $this->cart->getKey());

                $json['success']['toast'] = lang('Success.cart_remove', [], $this->language->getCurrentCode());
                $json['redirect'] = $this->url->customerLink('marketplace/checkout/cart');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());
            }
        }

        return $this->response->setJSON($json);
    }
}
