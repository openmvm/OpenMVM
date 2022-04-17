<?php

namespace App\Controllers\Marketplace\Product;

class Product extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_category = new \App\Models\Marketplace\Product\Category_Model();
        $this->model_product_product = new \App\Models\Marketplace\Product\Product_Model();
        $this->model_seller_seller = new \App\Models\Marketplace\Seller\Seller_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.categories'),
            'href' => $this->url->customerLink('marketplace/product/product'),
            'active' => false,
        );

        $data['heading_title'] = lang('Heading.products');

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
            'title' => lang('Heading.products'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Product\product_all', $data);
    }

    public function get($product)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get product ID
        $explode = explode('-', $product);

        $product_id = str_replace('p', '', end($explode));

        // Get product info
        $product_info = $this->model_product_product->getProduct($product_id);

        if ($product_info) {
            // Get seller info
            $seller_info = $this->model_seller_seller->getSeller($product_info['seller_id']);
        } else {
            $seller_info = false;
        }

        if ($product_info && $seller_info) {
            $category = explode('_', $product_info['category_id_path']);

            $category_id = end($category);

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
                    'active' => false,
                );
            }

            $breadcrumbs[] = array(
                'text' => $product_info['name'],
                'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug'] . '-p' . $product_info['product_id']),
                'active' => true,
            );
    
            $data['heading_title'] = $product_info['name'];
            $data['product_id'] = $product_info['product_id'];
            $data['name'] = $product_info['name'];
            $data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

            // Images
            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['thumb'] = $this->image->resize($product_info['main_image'], 512, 512, true);
            } else {
                $data['thumb'] = $this->image->resize('no_image.png', 512, 512, true);
            }

            $data['price'] = $this->currency->format($product_info['price'], $this->currency->getCurrentCode());  

            // Seller
            $data['store_name'] = $seller_info['store_name'];
            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);          

            // Header
            $header_params = array(
                'title' => $product_info['name'],
                'breadcrumbs' => $breadcrumbs,
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Product\product', $data);    
        } else {
            $data['message'] = lang('Error.no_data_found');
    
            // Header
            $header_params = array(
                'title' => lang('Heading.not_found'),
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\error', $data);    
        }
    }
}
