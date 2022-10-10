<?php

namespace Main\Marketplace\Controllers\Product;

class Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
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
            'text' => lang('Text.categories', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/product/category'),
            'active' => false,
        );

        $data['heading_title'] = lang('Heading.categories', [], $this->language->getCurrentCode());

        // Get categories
        $categories = $this->model_product_category->getCategories();

        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name' => $category['name'],
                'category_path' => $category['category_path'],
                'href' => $this->url->customerLink('marketplace/product/category/get/' . $category['slug'] . '-c' . $category['category_id']),
            ];
        }

        // Header
        $header_params = array(
            'title' => lang('Heading.categories', [], $this->language->getCurrentCode()),
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
            'view' => 'Product\category_all',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get($category)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get category ID
        $explode = explode('-', $category);

        $category_id = str_replace('c', '', end($explode));

        // Get category info
        $category_info = $this->model_product_category->getCategory($category_id);

        if ($category_info) {
            // Get path category ID 
            $category_id_path = $this->model_product_category->getCategoryIdPath($category_info['category_id']);

            $category_ids = explode('_', $category_id_path);

            if (!empty($category_ids[0])) {
                foreach ($category_ids as $category_id) {
                    $category_description_path = $this->model_product_category->getCategoryDescription($category_id);
    
                    $breadcrumbs[] = array(
                        'text' => $category_description_path['name'],
                        'href' => $this->url->customerLink('marketplace/product/category/get/' . $category_description_path['slug'] . '-c' . $category_id),
                        'active' => false,
                    );
                }
            }

            // Get category description
            $category_description = $this->model_product_category->getCategoryDescription($category_info['category_id']);

            $breadcrumbs[] = array(
                'text' => $category_description['name'],
                'href' => $this->url->customerLink('marketplace/product/category/get/' . $category_description['slug'] . '-c' . $category_info['category_id']),
                'active' => true,
            );
    
            $data['heading_title'] = $category_description['name'];
            $data['description'] = html_entity_decode($category_description['description'], ENT_QUOTES, 'UTF-8');

            // Get products
            $data['products'] = [];

            $filter_data = [
                'filter_category_id' => $category_info['category_id'],
                'filter_sub_category' => true,
            ];

            $products = $this->model_product_product->getProducts($filter_data);

            foreach ($products as $product) {
                // Image
                if (is_file(ROOTPATH . 'public/assets/images/' . $product['main_image'])) {
                    $thumb = $this->image->resize($product['main_image'], 512, 512, true);
                } else {
                    $thumb = $this->image->resize('no_image.png', 512, 512, true);
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

                $data['products'][] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'thumb' => $thumb,
                    'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                    'product_option' => $product['product_option'],
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                ];
            }

            // Header
            $header_params = array(
                'title' => $category_description['name'],
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
                'view' => 'Product\category',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
    
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
