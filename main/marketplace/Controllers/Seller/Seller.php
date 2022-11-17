<?php

namespace Main\Marketplace\Controllers\Seller;

class Seller extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.sellers', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.sellers', [], $this->language->getCurrentCode());

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.sellers', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\seller',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get($seller)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.sellers', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller'),
            'active' => false,
        );

        // Get product ID
        $explode = explode('-', $seller);

        $seller_id = str_replace('s', '', end($explode));

        // Get seller info
        $seller_info = $this->model_seller_seller->getSeller($seller_id);

        if ($seller_info) {
            $breadcrumbs[] = array(
                'text' => $seller_info['store_name'],
                'href' => $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']),
                'active' => true,
            );

            $data['heading_title'] = $seller_info['store_name'];
            $data['description'] = nl2br($seller_info['store_description']);

            // Get seller products
            $filter_data = [
                'filter_seller_id' => $seller_id,
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

                $data['products'][] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'thumb' => $thumb,
                    'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                    'special' => $special,
                    'product_option' => $product['product_option'],
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                ];
            }

            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $header_params = array(
                'title' => $seller_info['store_name'],
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
                'view' => 'Seller\seller_info',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
        
            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $header_params = array(
                'title' => lang('Heading.not_found', [], $this->language->getCurrentCode()),
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
                'view' => 'Common\error',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
