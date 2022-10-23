<?php

namespace Main\Marketplace\Controllers\Product;

class Product extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
        $this->model_product_option = new \Main\Marketplace\Models\Product\Option_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_product_product_review = new \Main\Marketplace\Models\Product\Product_Review_Model();
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
            'text' => lang('Text.categories', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/product/product'),
            'active' => false,
        );

        $data['heading_title'] = lang('Heading.products', [], $this->language->getCurrentCode());

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

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.products', [], $this->language->getCurrentCode()),
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
            'view' => 'Product\product_all',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
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

            $data['is_wishlist'] = $this->wishlist->check($this->customer->getId(), $product_info['product_id']);

            // Images
            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['thumb'] = $this->image->resize($product_info['main_image'], 100, 100, true);
            } else {
                $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
            }

            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['image'] = $this->image->resize($product_info['main_image'], 512, 512, true);
            } else {
                $data['image'] = $this->image->resize('no_image.png', 512, 512, true);
            }

            // Additional images
            $data['additional_images'] = [];

            $additional_images = $this->model_product_product->getProductImages($product_info['product_id']);

            foreach ($additional_images as $additional_image) {
                if (is_file(ROOTPATH . 'public/assets/images/' . $additional_image['image'])) {
                    $thumb = $this->image->resize($additional_image['image'], 100, 100, true);
                    $image = $this->image->resize($additional_image['image'], 512, 512, true);
                    
                    $data['additional_images'][] = [
                        'thumb' => $thumb,
                        'image' => $image,
                    ];
                }
            }

            $data['price'] = $this->currency->format($product_info['price'], $this->currency->getCurrentCode());  
            $data['quantity'] = $product_info['quantity'];

            // Seller
            $data['store_name'] = $seller_info['store_name'];
            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);          

            if (is_file(ROOTPATH . 'public/assets/images/' . $seller_info['logo'])) {
                $data['store_logo'] = $this->image->resize($seller_info['logo'], 72, 72, true);
            } else {
                $data['store_logo'] = $this->image->resize('no_image.png', 72, 72, true);
            }

            // Product options
            $data['is_product_option'] = $product_info['product_option'];

            $data['product_options'] = [];

            $product_options = $this->model_product_product->getProductOptions($product_info['product_id']);

            foreach($product_options as $product_option) {
                $product_option_value_data = [];

                // Get product option values
                $product_option_values = $this->model_product_product->getProductOptionValues($product_option['product_id'], $product_option['product_option_id']);

                foreach ($product_option_values as $product_option_value) {
                    $product_option_value_data[] = [
                        'product_option_id' => $product_option_value['product_option_id'],
                        'product_id' => $product_option_value['product_id'],
                        'option_id' => $product_option_value['option_id'],
                        'option_value_id' => $product_option_value['option_value_id'],
                        'sort_order' => $product_option_value['sort_order'],
                        'seller_id' => $product_option_value['seller_id'],
                        'customer_id' => $product_option_value['customer_id'],
                        'description' => $product_option_value['description'],
                    ];
                }

                $product_option_value_sort_order = [];

                foreach ($product_option_value_data as $key => $value) {
                    $product_option_value_sort_order[$key] = $value['sort_order'];
                }

                array_multisort($product_option_value_sort_order, SORT_ASC, $product_option_value_data);

                $data['product_options'][] = [
                    'product_option_id' => $product_option['product_option_id'],
                    'product_id' => $product_option['product_id'],
                    'option_id' => $product_option['option_id'],
                    'sort_order' => $product_option['sort_order'],
                    'seller_id' => $product_option['seller_id'],
                    'customer_id' => $product_option['customer_id'],
                    'description' => $product_option['description'],
                    'product_option_value' => $product_option_value_data,
                ];
            }

            $sort_order = [];

            foreach ($data['product_options'] as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $data['product_options']);

            // Product variants min max prices
            $product_variant_price = $this->model_product_product->getProductVariantminMaxPrices($product_info['product_id']);

            $data['min_price'] = $this->currency->format($product_variant_price['min_price'], $this->currency->getCurrentCode());
            $data['max_price'] = $this->currency->format($product_variant_price['max_price'], $this->currency->getCurrentCode());

            $data['get_product_variant'] = $this->url->customerLink('marketplace/product/product/get_product_variant/');    

            // Get product reviews
            $data['product_reviews'] = [];

            $product_reviews = $this->model_product_product_review->getProductReviews($product_info['product_id']);  

            foreach ($product_reviews as $product_review) {
                // Get customer info
                $customer_info = $this->model_customer_customer->getCustomer($product_review['customer_id']);

                if ($customer_info) {
                    // Get order product info
                    $order_product_info = $this->model_product_product->getOrderProduct($product_review['customer_id'], $product_review['order_product_id']);

                    if ($order_product_info) {
                        $product_option_data = $order_product_info['option'];
                    } else {
                        $product_option_data = [];
                    }

                    $data['product_reviews'][] = [
                        'product_review_id' => $product_review['product_review_id'],
                        'order_product_id' => $product_review['order_product_id'],
                        'order_id' => $product_review['order_id'],
                        'product_id' => $product_review['product_id'],
                        'seller_id' => $product_review['seller_id'],
                        'customer_id' => $product_review['customer_id'],
                        'customer' => $customer_info['firstname'],
                        'rating' => $product_review['rating'],
                        'title' => $product_review['title'],
                        'review' => $product_review['review'],
                        'product_options' => $product_option_data,
                        'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_review['date_added'])),
                        'date_modified' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_review['date_modified'])),
                        'status' => $product_review['status'],
                    ];
                }
            }   

            $average_product_review_rating = $this->model_product_product_review->getAverageProductReviewRating($product_info['product_id']);

            $data['average_product_review_rating'] = number_format($average_product_review_rating, 1, lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode()));

            $data['total_product_reviews'] = $this->model_product_product_review->getTotalProductReviews($product_info['product_id']);

            $data['total_product_reviews_rating_5'] = $this->model_product_product_review->getTotalProductReviewsByRating($product_info['product_id'], 5);
            $data['total_product_reviews_rating_4'] = $this->model_product_product_review->getTotalProductReviewsByRating($product_info['product_id'], 4);
            $data['total_product_reviews_rating_3'] = $this->model_product_product_review->getTotalProductReviewsByRating($product_info['product_id'], 3);
            $data['total_product_reviews_rating_2'] = $this->model_product_product_review->getTotalProductReviewsByRating($product_info['product_id'], 2);
            $data['total_product_reviews_rating_1'] = $this->model_product_product_review->getTotalProductReviewsByRating($product_info['product_id'], 1);

            $data['percentage_product_reviews_rating_5'] = ($data['total_product_reviews_rating_5']/$data['total_product_reviews']) * 100;
            $data['percentage_product_reviews_rating_4'] = ($data['total_product_reviews_rating_4']/$data['total_product_reviews']) * 100;
            $data['percentage_product_reviews_rating_3'] = ($data['total_product_reviews_rating_3']/$data['total_product_reviews']) * 100;
            $data['percentage_product_reviews_rating_2'] = ($data['total_product_reviews_rating_2']/$data['total_product_reviews']) * 100;
            $data['percentage_product_reviews_rating_1'] = ($data['total_product_reviews_rating_1']/$data['total_product_reviews']) * 100;

            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/swiper-8.4.3/swiper-bundle.min.js" type="text/javascript"></script>',
            ];
            $styles = [
                '<link rel="stylesheet" href="' . base_url() . '/assets/plugins/swiper-8.4.3/swiper-bundle.min.css" />',
            ];
            $header_params = array(
                'title' => $product_info['name'],
                'breadcrumbs' => $breadcrumbs,
                'scripts' => $scripts,
                'styles' => $styles,
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
                'view' => 'Product\product',
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

    public function get_product_variant()
    {
        $json = [];

        // Get product variant by options
        if ($this->request->getMethod() == 'post') {
            if (!empty($this->request->getGet('product_id'))) {
                $product_id = $this->request->getGet('product_id');
            } else {
                $product_id = 0;
            }

            $product_option = $this->request->getPost();

            $product_variants = $product_option['product_variant'];

            asort($product_variants);

            // Get option values
            if ($product_variants) {
                foreach ($product_variants as $key => $value) {
                    // Get option value info
                    $option_value_info = $this->model_product_option->getOptionValue($key, $value);

                    if ($option_value_info) {
                        $option_value = $option_value_info['name'];
                    } else {
                        $option_value = '';
                    }

                    $json['options'][] = [
                        'option_id' => $key,
                        'option_value' => $option_value,
                    ];
                }
            } else {
                $json['options'] = [];
            }

            // Get product variant info
            $options = json_encode($product_variants);

            $product_variant_info = $this->model_product_product->getProductVariantByOptions($product_id, $options);

            if ($product_variant_info) {
                $json['product_variant'] = [
                    'product_variant_id' => $product_variant_info['product_variant_id'],
                    'product_id' => $product_variant_info['product_id'],
                    'seller_id' => $product_variant_info['seller_id'],
                    'customer_id' => $product_variant_info['customer_id'],
                    'sku' => $product_variant_info['sku'],
                    'quantity' => $product_variant_info['quantity'],
                    'price' => $this->currency->format($product_variant_info['price'], $this->currency->getCurrentCode()),
                    'weight' => $product_variant_info['weight'],
                    'weight_class_id' => $product_variant_info['weight_class_id'],
                ];
            } else {
                $json['product_variant'] = [];
            }

            $json['result'] = json_encode($product_variant_info);
        }

        return $this->response->setJSON($json);
    }

    public function add_to_wishlist()
    {
        $json = [];

        $is_wishlist = $this->wishlist->check($this->customer->getId(), $this->request->getPost('product_id'));

        if ($is_wishlist) {
            // Remove wishlist
            $this->wishlist->remove($this->customer->getId(), $this->request->getPost('product_id'));
        } else {
            // Add wishlist
            $this->wishlist->add($this->customer->getId(), $this->request->getPost('product_id'));
        }

        $is_wishlist = $this->wishlist->check($this->customer->getId(), $this->request->getPost('product_id'));

        if ($is_wishlist) {
            $json['is_wishlist'] = true;

            $json['success'] = lang('Success.add_to_wishlist', [], $this->language->getCurrentCode());

            if ($this->customer->getId()) {
                $json['additional_message'] = '';
            } else {
                $json['additional_message'] = lang('Text.login_wishlist', [], $this->language->getCurrentCode());
            }
        } else {
            $json['is_wishlist'] = false;

            $json['success'] = lang('Success.remove_from_wishlist', [], $this->language->getCurrentCode());
            $json['additional_message'] = '';
        }

        return $this->response->setJSON($json);
    }
}
