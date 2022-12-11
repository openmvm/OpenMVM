<?php

namespace Main\Marketplace\Controllers\Seller;

class Seller_Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_localisation_currency = new \Main\Marketplace\Models\Localisation\Currency_Model();
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_localisation_weight_class = new \Main\Marketplace\Models\Localisation\Weight_Class_Model();
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_seller_category = new \Main\Marketplace\Models\Seller\Seller_Category_Model();
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
        $this->model_seller_option = new \Main\Marketplace\Models\Seller\Option_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/seller/seller_category/delete', '', true);

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/seller_category/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/seller_category/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_categories', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller_category', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.seller_categories', [], $this->language->getCurrentCode());

        // Get seller_categories
        $data['seller_categories'] = [];

        $seller_categories = $this->model_seller_seller_category->getSellerCategories([], $this->customer->getSellerId(), $this->customer->getId());

        foreach ($seller_categories as $seller_category) {
            // Image
            if (is_file(ROOTPATH . 'public/assets/images/' . $seller_category['image'])) {
                $thumb = $this->image->resize($seller_category['image'], 48, 48, true);
            } else {
                $thumb = $this->image->resize('no_image.png', 48, 48, true);
            }

            $data['seller_categories'][] = [
                'seller_category_id' => $seller_category['seller_category_id'],
                'name' => $seller_category['name'],
                'thumb' => $thumb,
                'sort_order' => $seller_category['sort_order'],
                'status' => $seller_category['status'] ? lang('Text.enabled', [], $this->language->getCurrentCode()) : lang('Text.disabled', [], $this->language->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/seller/seller_category/edit/' . $seller_category['seller_category_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/seller/seller_category/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.seller_categories', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\seller_category_list',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_categories', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller_category', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $seller_category_info = $this->model_seller_seller_category->getSellerCategory($this->uri->getSegment($this->uri->getTotalSegments()), $this->customer->getSellerId(), $this->customer->getId());
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $seller_category_info = [];
        }

        $data['heading_title'] = lang('Heading.seller_categories', [], $this->language->getCurrentCode());


        if ($seller_category_info) {
            $data['seller_category_description'] = $this->model_seller_seller_category->getSellerCategoryDescriptions($seller_category_info['seller_category_id'], $this->customer->getSellerId(), $this->customer->getId());
        } else {
            $data['seller_category_description'] = [];
        }

        if ($seller_category_info) {
            $data['parent'] = $this->model_seller_seller_category->getSellerCategoryPath($seller_category_info['seller_category_id'], $this->customer->getSellerId(), $this->customer->getId());
        } else {
            $data['parent'] = '';
        }

        if ($seller_category_info) {
            $data['parent_id'] = $seller_category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($seller_category_info) {
            $data['image'] = $seller_category_info['image'];
        } else {
            $data['image'] = '';
        }

        if (!empty($seller_category_info['image']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_category_info['image'])) {
            $data['thumb'] = $this->image->resize($seller_category_info['image'], 100, 100, true);
        } else {
            $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($seller_category_info) {
            $data['sort_order'] = $seller_category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($seller_category_info) {
            $data['status'] = $seller_category_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($seller_category_info) {
            $seller_category_id = $seller_category_info['seller_category_id'];
        } else {
            $seller_category_id = 0;
        }

        $data['seller_category_id'] = $seller_category_id;

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['cancel'] = $this->url->customerLink('marketplace/seller/seller_category', '', true);
        $data['seller_category_autocomplete_url'] = $this->url->customerLink('marketplace/seller/seller_category/autocomplete', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
            '<script src="' . base_url() . '/assets/plugins/swiper-8.4.4/swiper-bundle.min.js" type="text/javascript"></script>',
        ];
        $styles = [
            '<link rel="stylesheet" href="' . base_url() . '/assets/plugins/swiper-8.4.4/swiper-bundle.min.css" />',
        ];
        $header_params = array(
            'title' => lang('Heading.seller_categories', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\seller_category_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $seller_category_id) {
                    // Query
                    $query = $this->model_seller_seller_category->deleteSellerCategory($seller_category_id);

                    $json['success']['toast'] = lang('Success.seller_category_delete', [], $this->language->getCurrentCode());

                    $json['redirect'] = $this->url->customerLink('marketplace/seller/seller_category', '', true);
                }
            } else {
                $json['error']['toast'] = lang('Error.seller_category_delete');
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('seller_category_description.' . $language['language_id'] . '.name', lang('Entry.name', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
                $this->validation->setRule('seller_category_description.' . $language['language_id'] . '.meta_title', lang('Entry.meta_title', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_seller_seller_category->editSellerCategory($this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.seller_category_edit', [], $this->language->getCurrentCode());
                } else {
                    // Query
                    $query = $this->model_seller_seller_category->addSellerCategory($json_data);

                    $json['success']['toast'] = lang('Success.seller_category_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/seller/seller_category', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('seller_category_description.' . $language['language_id'] . '.name')) {
                        $json['error']['name-' . $language['language_id']] = $this->validation->getError('seller_category_description.' . $language['language_id'] . '.name');
                    }

                    if ($this->validation->hasError('seller_category_description.' . $language['language_id'] . '.meta_title')) {
                        $json['error']['meta-title-' . $language['language_id']] = $this->validation->getError('seller_category_description.' . $language['language_id'] . '.meta_title');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function autocomplete()
    {
        $json = [];

        if (!empty($this->request->getGet('filter_name'))) {
            $filter_name = $this->request->getGet('filter_name');
        } else {
            $filter_name = '';
        }

        $filter_data = [
            'filter_name' => $filter_name,
        ];

        $seller_categories = $this->model_seller_seller_category->getSellerCategories($filter_data, $this->customer->getSellerId(), $this->customer->getId());

        if ($seller_categories) {
            foreach ($seller_categories as $seller_category) {
                $json[] = [
                    'seller_category_id' => $seller_category['seller_category_id'],
                    'name' => $seller_category['name'],
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    public function get($seller, $seller_category)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get seller ID
        $explode = explode('-', $seller);

        $seller_id = str_replace('s', '', end($explode));

        // Get seller info
        $seller_info = $this->model_seller_seller->getSeller($seller_id);

        if ($seller_info) {
            // Get seller category ID
            $explode = explode('-', $seller_category);

            $seller_category_id = str_replace('sc', '', end($explode));
            
            $data['link_id'] = $seller_category_id;

            // Get seller category info
            $seller_category_info = $this->model_seller_seller_category->getSellerCategory($seller_category_id, $seller_id);

            if ($seller_category_info) {
                // Get seller category description
                $seller_category_description = $this->model_seller_seller_category->getSellerCategoryDescription($seller_category_id, $seller_id);

                if ($seller_category_description) {
                    $breadcrumbs[] = array(
                        'text' => $seller_category_description['name'],
                        'href' => $this->url->customerLink('marketplace/seller/seller_category/get/' . $seller_category_description['slug'] . '-c' . $seller_category_info['seller_category_id']),
                        'active' => true,
                    );
                }

                $data['heading_title'] = $seller_info['store_name'] . ' - ' . $seller_category_description['name'];

                // Get path seller category ID 
                $seller_category_id_path = $this->model_seller_seller_category->getSellerCategoryIdPath($seller_category_info['seller_category_id']);

                $seller_category_ids = explode('_', $seller_category_id_path);

                if (!empty($seller_category_ids[0])) {
                    foreach ($seller_category_ids as $seller_category_id) {
                        $seller_category_description_path = $this->model_seller_seller_category->getSellerCategoryDescription($seller_category_id, $seller_id);
            
                        if ($seller_category_description_path) {
                            $breadcrumbs[] = array(
                                'text' => $seller_category_description_path['name'],
                                'href' => $this->url->customerLink('marketplace/seller/seller_category/get/' . $seller_category_description_path['slug'] . '-sc' . $seller_category_id),
                                'active' => false,
                            );
                        }
                    }
                }

                // Get products
                $data['products'] = [];

                $filter_data = [
                    'filter_seller_category_id' => $seller_category_info['seller_category_id'],
                    'filter_sub_category' => true,
                ];

                $products = $this->model_seller_seller->getProducts($filter_data, $seller_id);

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
                        $special_max_price = $this->currency->format($product_variant_price['max_price'], $this->currency->getCurrentCode());
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

                $data['parent_id'] = $seller_category_info['parent_id'];

                $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);
                $data['get_seller_categories_url'] = $this->url->customerLink('marketplace/seller/seller/get_seller_categories', ['seller_id' => $seller_id]);

                // Libraries
                $data['language_lib'] = $this->language;

                // Widget
                $data['marketplace_common_widget'] = $this->marketplace_common_widget;
                // Header
                $header_params = array(
                    'title' => lang('Heading.seller_categories', [], $this->language->getCurrentCode()),
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
                    'view' => 'Seller\seller_category_info',
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
