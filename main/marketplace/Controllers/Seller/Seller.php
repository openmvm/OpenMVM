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
        $this->model_seller_seller_category = new \Main\Marketplace\Models\Seller\Seller_Category_Model();
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

        // Get seller ID
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
            $data['lead'] = lang('Text.home', [], $this->language->getCurrentCode());
            $data['description'] = nl2br($seller_info['store_description']);

            $data['link_id'] = 'home';

            // Get seller products
            $data['products'] = [];

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

                // Get product variant special min max prices
                if (!empty($product['product_option'])) {
                    $product_variant_special_price = $this->model_product_product->getProductVariantSpecialMinMaxPrices($product['product_id']);

                    $special_min_price = $this->currency->format($product_variant_special_price['min_price'], $this->currency->getCurrentCode());
                    $special_max_price = $this->currency->format($product_variant_special_price['max_price'], $this->currency->getCurrentCode());
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

            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);
            $data['get_seller_categories_url'] = $this->url->customerLink('marketplace/seller/seller/get_seller_categories', ['seller_id' => $seller_id]);
            $data['product_search_url'] = $this->url->customerLink('marketplace/product/search');
            $data['seller_product_search_url'] = $this->url->customerLink('marketplace/seller/seller/product');
            $data['seller_slug'] = $seller_info['slug'] . '-s' . $seller_info['seller_id'];

            // Libraries
            $data['language_lib'] = $this->language;

            // Widget
            $data['marketplace_common_widget'] = $this->marketplace_common_widget;
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

    public function product($seller, $keyword = null)
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

        // Get seller ID
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
            $data['lead'] = lang('Text.search', [], $this->language->getCurrentCode());
            $data['description'] = nl2br($seller_info['store_description']);

            $data['link_id'] = 'product';

            $data['parent_id'] = 0;

            $data['keyword'] = $keyword;

            if (!empty($this->request->getGet('type'))) {
                $type = $this->request->getGet('type');
            } else {
                $type = 'shop';
            }

            $data['type'] = $type;

            // Get seller products
            $data['products'] = [];

            $filter_data = [
                'filter_seller_id' => $seller_id,
                'filter_name' => $keyword,
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
                    $product_variant_special_price = $this->model_product_product->getProductVariantSpecialMinMaxPrices($product['product_id']);

                    $special_min_price = $this->currency->format($product_variant_special_price['min_price'], $this->currency->getCurrentCode());
                    $special_max_price = $this->currency->format($product_variant_special_price['max_price'], $this->currency->getCurrentCode());
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

            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);
            $data['get_seller_categories_url'] = $this->url->customerLink('marketplace/seller/seller/get_seller_categories', ['seller_id' => $seller_id]);
            $data['product_search_url'] = $this->url->customerLink('marketplace/product/search');
            $data['seller_product_search_url'] = $this->url->customerLink('marketplace/seller/seller/product');
            $data['seller_slug'] = $seller_info['slug'] . '-s' . $seller_info['seller_id'];

            // Libraries
            $data['language_lib'] = $this->language;

            // Widget
            $data['marketplace_common_widget'] = $this->marketplace_common_widget;
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
                'view' => 'Seller\seller_product',
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

    public function get_seller_categories()
    {
        $json = [];

        if (!empty($this->request->getPost('parent_id'))) {
            $parent_id = $this->request->getPost('parent_id');
        } else {
            $parent_id = 0;
        }

        if (!empty($this->request->getGet('seller_id'))) {
            $seller_id = $this->request->getGet('seller_id');
        } else {
            $seller_id = 0;
        }

        // Get seller info
        $seller_info = $this->model_seller_seller->getSeller($seller_id);

        // Get seller categories
        $json['seller_categories'] = [];

        $seller_categories = $this->model_seller_seller_category->getSellerCategoriesByParentId(0, $seller_id);

        foreach ($seller_categories as $seller_category) {
            // Level 2
            $seller_category_children_data = [];

            $seller_category_children = $this->model_seller_seller_category->getSellerCategoriesByParentId($seller_category['seller_category_id'], $seller_id);

            foreach ($seller_category_children as $seller_category_child) {
                $seller_category_children_data[] = [
                    'seller_category_id' => $seller_category_child['seller_category_id'],
                    'name' => $seller_category_child['name'],
                    'parent_id' => $seller_category_child['parent_id'],
                    'image' => $seller_category_child['image'],
                    'sort_order' => $seller_category_child['sort_order'],
                    'status' => $seller_category_child['status'],
                    'href' => $this->url->customerLink('marketplace/seller/seller_category/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id'] . '/' . $seller_category_child['slug'] . '-sc' . $seller_category_child['seller_category_id']),
                ];
            }

            $json['seller_categories'][] = [
                'seller_category_id' => $seller_category['seller_category_id'],
                'name' => $seller_category['name'],
                'parent_id' => $seller_category['parent_id'],
                'image' => $seller_category['image'],
                'sort_order' => $seller_category['sort_order'],
                'status' => $seller_category['status'],
                'href' => $this->url->customerLink('marketplace/seller/seller_category/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id'] . '/' . $seller_category['slug'] . '-sc' . $seller_category['seller_category_id']),
                'children' => $seller_category_children_data,
            ];
        }

        return $this->response->setJSON($json);
    }
}
