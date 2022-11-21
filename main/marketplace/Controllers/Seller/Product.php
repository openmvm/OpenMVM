<?php

namespace Main\Marketplace\Controllers\Seller;

class Product extends \App\Controllers\BaseController
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
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
        $this->model_seller_option = new \Main\Marketplace\Models\Seller\Option_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/seller/product/delete', '', true);

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/product/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/product/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

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
            'text' => lang('Text.products', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/product', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.products', [], $this->language->getCurrentCode());

        // Get products
        $data['products'] = [];

        $products = $this->model_seller_product->getProducts($this->customer->getSellerId(), $this->customer->getId());

        foreach ($products as $product) {
            // Image
            if (is_file(ROOTPATH . 'public/assets/images/' . $product['main_image'])) {
                $thumb = $this->image->resize($product['main_image'], 48, 48, true);
            } else {
                $thumb = $this->image->resize('no_image.png', 48, 48, true);
            }

            // Get product description
            $product_description_info = $this->model_seller_product->getProductDescription($product['product_id']);

            // Get product variant min and max prices
            $product_variant_price = $this->model_seller_product->getProductVariantMinMaxPrices($product['product_id']);

            if ($product_variant_price) {
                $min_price = $this->currency->format($product_variant_price['min_price'], $this->currency->getCurrentCode());
                $max_price = $this->currency->format($product_variant_price['max_price'], $this->currency->getCurrentCode());
            } else {
                $min_price = $this->currency->format(0, $this->currency->getCurrentCode());
                $max_price = $this->currency->format(0, $this->currency->getCurrentCode());
            }

            // Get product variant min and max quantities
            $product_variant_quantity = $this->model_seller_product->getProductVariantMinMaxQuantities($product['product_id']);

            if ($product_variant_quantity) {
                $min_quantity = $product_variant_quantity['min_quantity'];
                $max_quantity = $product_variant_quantity['max_quantity'];
            } else {
                $min_quantity = 0;
                $max_quantity = 0;
            }

            $data['products'][] = [
                'product_id' => $product['product_id'],
                'name' => $product_description_info['name'],
                'thumb' => $thumb,
                'product_option' => $product['product_option'],
                'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                'min_price' => $min_price,
                'max_price' => $max_price,
                'quantity' => $product['quantity'],
                'requires_shipping' => $product['requires_shipping'],
                'min_quantity' => $min_quantity,
                'max_quantity' => $max_quantity,
                'status' => $product['status'] ? lang('Text.enabled', [], $this->language->getCurrentCode()) : lang('Text.disabled', [], $this->language->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/seller/product/edit/' . $product['product_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/seller/product/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);

        //$data['product_variants'] = file_get_contents($this->url->customerLink('marketplace/seller/product/get_product_variants', '', true));

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
            'view' => 'Seller\product_list',
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
            'text' => lang('Text.products', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/product', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $product_info = $this->model_seller_product->getProduct($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $product_info = [];
        }

        $data['heading_title'] = lang('Heading.products', [], $this->language->getCurrentCode());

        if ($product_info) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($product_info) {
            $data['product_description'] = $this->model_seller_product->getProductDescriptions($product_info['product_id']);
        } else {
            $data['product_description'] = [];
        }

        if ($product_info) {
            $data['category_id_path'] = $product_info['category_id_path'];
        } else {
            $data['category_id_path'] = '';
        }

        if ($product_info) {
            $data['is_product_variant'] = $product_info['product_option'];
        } else {
            $data['is_product_variant'] = '';
        }

        if ($product_info) {
            $data['sku'] = $product_info['sku'];
        } else {
            $data['sku'] = '';
        }

        if ($product_info) {
            $data['price'] = $product_info['price'];
        } else {
            $data['price'] = 0;
        }

        if ($product_info) {
            $data['quantity'] = $product_info['quantity'];
        } else {
            $data['quantity'] = 0;
        }

        if ($product_info) {
            $data['minimum_purchase'] = $product_info['minimum_purchase'];
        } else {
            $data['minimum_purchase'] = 1;
        }

        if ($product_info) {
            $data['requires_shipping'] = $product_info['requires_shipping'];
        } else {
            $data['requires_shipping'] = 1;
        }

        if ($product_info) {
            $data['weight'] = $product_info['weight'];
        } else {
            $data['weight'] = 0;
        }

        if ($product_info) {
            $data['weight_class_id'] = $product_info['weight_class_id'];
        } else {
            $data['weight_class_id'] = 0;
        }

        if ($product_info && is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
            $data['thumb'] = $this->image->resize($product_info['main_image'], 100, 100, true);
            $data['main_image'] = $product_info['main_image'];
        } else {
            $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
            $data['main_image'] = 'no_image.png';
        }

        // Product options
        $data['product_options'] = [];

        if ($product_info) {
            $product_options = $this->model_seller_product->getProductOptions($product_info['product_id']);

            foreach ($product_options as $product_option) {
                $data['product_options'][] = [
                    'product_option_id' => $product_option['product_option_id'],
                    'product_id' => $product_option['product_id'],
                    'option_id' => $product_option['option_id'],
                    'option' => $product_option['option'],
                    'option_sort_order' => $product_option['option_sort_order'],
                    'seller_id' => $product_option['seller_id'],
                    'customer_id' => $product_option['customer_id'],
                    'product_option_value' => $product_option['product_option_value'],
                    'option_value' => $product_option['option_value'],
                ];
            }

            $sort_order = [];

            foreach ($data['product_options'] as $key => $value) {
                $sort_order[$key] = $value['option_sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $data['product_options']);
        } else {
            $product_options = [];
        }

        $data['product_options_debug'] = $data['product_options'];

        // Product images
        if ($product_info) {
            $data['additional_images'] = [];

            $additional_images = $this->model_seller_product->getProductImages($product_info['product_id']);

            foreach ($additional_images as $additional_image) {
                if (is_file(ROOTPATH . 'public/assets/images/' . $additional_image['image'])) {
                    $data['additional_images'][] = [
                        'thumb' => $this->image->resize($additional_image['image'], 100, 100, true),
                        'image' => $additional_image['image'],
                    ];
                }
            }

        } else {
            $data['additional_images'] = [];
        }

        // Product downloads
        if ($product_info) {
            $data['product_downloads'] = [];

            $product_downloads = $this->model_seller_product->getProductDownloads($product_info['product_id']);

            foreach ($product_downloads as $product_download) {
                $data['product_downloads'][] = [
                    'product_download_id' => $product_download['product_download_id'],
                    'product_id' => $product_download['product_id'],
                    'seller_id' => $product_download['seller_id'],
                    'customer_id' => $product_download['customer_id'],
                    'filename' => $product_download['filename'],
                    'mask' => $product_download['mask'],
                    'date_added' => $product_download['date_added'],
                    'description' => $product_download['description'],
                ];
            }

        } else {
            $data['product_downloads'] = [];
        }


        // Categories
        $data['categories'] = [];

        $categories = $this->model_product_category->getCategories();

        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id_path' => $category['category_id_path'],
                'category_path' => $category['category_path'],
            ];
        }

        // Product specials
        if ($product_info) {
            $data['product_specials'] = [];

            $product_specials = $this->model_seller_product->getProductSpecials($product_info['product_id']);

            foreach ($product_specials as $product_special) {
                $data['product_specials'][] = [
                    'product_special_id' => $product_special['product_special_id'],
                    'product_id' => $product_special['product_id'],
                    'seller_id' => $product_special['seller_id'],
                    'customer_id' => $product_special['customer_id'],
                    'priority' => $product_special['priority'],
                    'price' => $product_special['price'],
                    'date_start' => $product_special['date_start'],
                    'date_end' => $product_special['date_end'],
                ];
            }

        } else {
            $data['product_specials'] = [];
        }

        // Product discounts
        if ($product_info) {
            $data['product_discounts'] = [];

            $product_discounts = $this->model_seller_product->getProductDiscounts($product_info['product_id']);

            foreach ($product_discounts as $product_discount) {
                $data['product_discounts'][] = [
                    'product_discount_id' => $product_discount['product_discount_id'],
                    'product_id' => $product_discount['product_id'],
                    'seller_id' => $product_discount['seller_id'],
                    'customer_id' => $product_discount['customer_id'],
                    'priority' => $product_discount['priority'],
                    'min_quantity' => $product_discount['min_quantity'],
                    'max_quantity' => $product_discount['max_quantity'],
                    'price' => $product_discount['price'],
                    'date_start' => $product_discount['date_start'],
                    'date_end' => $product_discount['date_end'],
                ];
            }

        } else {
            $data['product_discounts'] = [];
        }

        if ($product_info) {
            $product_id = $product_info['product_id'];
        } else {
            $product_id = 0;
        }

        $data['product_id'] = $product_id;

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        // Get currency info
        $currency_info = $this->model_localisation_currency->getCurrency($this->currency->getDefaultId());

        if ($currency_info) {
            $data['default_currency'] = [
                'currency_id' => $currency_info['currency_id'],
                'name' => $currency_info['name'],
                'code' => $currency_info['code'],
                'symbol_left' => $currency_info['symbol_left'],
                'symbol_right' => $currency_info['symbol_right'],
                'decimal_place' => $currency_info['decimal_place'],
                'value' => $currency_info['value'],
                'sort_order' => $currency_info['sort_order'],
                'status' => $currency_info['status'],
            ];
        } else {
            $data['default_currency'] = [];
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['upload'] = $this->url->customerLink('marketplace/tool/upload', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/product', '', true);
        $data['get_option'] = $this->url->customerLink('marketplace/seller/option/get_option', '', true);
        $data['option_autocomplete'] = $this->url->customerLink('marketplace/seller/option/autocomplete', '', true);
        $data['product_variant'] = $this->url->customerLink('marketplace/seller/product/get_product_variants', ['product_id' => $product_id], true);
        $data['set_product_options'] = $this->url->customerLink('marketplace/seller/product/set_product_options', '', true);
        $data['product_variant_special'] = $this->url->customerLink('marketplace/seller/product/get_product_variant_specials', ['product_id' => $product_id], true);
        $data['product_variant_discount'] = $this->url->customerLink('marketplace/seller/product/get_product_variant_discounts', ['product_id' => $product_id], true);
        $data['product_download_upload'] = $this->url->customerLink('marketplace/seller/product/product_download_upload', '', true);

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
            'title' => lang('Heading.products', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\product_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function set_product_options()
    {
        $json = [];

        $product_options = $this->request->getJSON(true);

        $this->session->set('product_options', $product_options);

        return $this->response->setJSON($json);
    }

    public function get_product_variants()
    {
        $data = [];

        $product_variant_data = [];

        $product_options = $this->session->get('product_options');

        if (!empty($product_options['product_option'])) {
            foreach ($product_options['product_option'] as $product_option) {
                if (!empty($product_option['option_value'])) {
                    $product_variant_data[$product_option['option_id']] = $product_option['option_value'];
                }
            }
        }

        $data['result'] = $this->session->get('product_options');

        $product_variants = [];
        $product_variant_key = 0;
        $selected_option_data_1 = [];

        $product_variant_ids = $this->product_variants($product_variant_data);

        foreach ($product_variant_ids as $product_variant_id) {
            $option_data = [];

            foreach ($product_variant_id as $key => $value) {
                // Get option info
                $option_info = $this->model_seller_option->getOption($key);

                if (!empty($option_info)) {
                    // Get option value info
                    $option_value_info = $this->model_seller_option->getOptionValue($key, $value);

                    if (!empty($option_value_info)) {
                        $option_data[] = [
                            'option' => $option_info['name'],
                            'option_id' => $option_info['option_id'],
                            'option_value' => $option_value_info['name'],
                            'option_value_id' => $option_value_info['option_value_id'],
                        ];
                    }

                    $selected_option_data_1[$option_info['option_id']] = $option_value_info['option_value_id'];

                    asort($selected_option_data_1);
                }
            }

            // Get product variant info
            if (!empty($this->request->getGet('product_id'))) {
                $product_id = $this->request->getGet('product_id');
            } else {
                $product_id = 0;
            }

            $product_variant_info = $this->model_seller_product->getProductVariant($product_id, $option_data);

            if (!empty($product_options['product_variant'])) {
                foreach ($product_options['product_variant'] as $product_variant) {
                    if (!empty($product_variant['option'])) {
                        asort($product_variant['option']);
                        if ($product_variant['option'] === $selected_option_data_1) {
                            $sku = $product_variant['sku'];
                            $quantity = $product_variant['quantity'];
                            $minimum_purchase = $product_variant['minimum_purchase'];
                            $price = $product_variant['price'];
                            $weight = $product_variant['weight'];
                            $weight_class_id = $product_variant['weight_class_id'];

                            break;
                        } else {
                            $sku = '';
                            $quantity = 0;
                            $minimum_purchase = 1;
                            $price = 0;
                            $weight = 0;
                            $weight_class_id = '';
                        }
                    }
                }
            } elseif ($product_variant_info) {
                $sku = $product_variant_info['sku'];
                $quantity = $product_variant_info['quantity'];
                $minimum_purchase = $product_variant_info['minimum_purchase'];
                $price = $product_variant_info['price'];
                $weight = $product_variant_info['weight'];
                $weight_class_id = $product_variant_info['weight_class_id'];
            } else {
                $sku = '';
                $quantity = 0;
                $minimum_purchase = 1;
                $price = 0;
                $weight = 0;
                $weight_class_id = '';
            }

            $product_variants[] = [
                'key' => $product_variant_key,
                'sku' => $sku,
                'quantity' => $quantity,
                'minimum_purchase' => $minimum_purchase,
                'price' => $price,
                'weight' => $weight,
                'weight_class_id' => $weight_class_id,
                'variant' => $option_data,
            ];

            $product_variant_key++;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 32, 32, true);

        $data['product_variants'] = $product_variants;
        $data['selected_1'] = $selected_option_data_1;
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        // Get currency info
        $currency_info = $this->model_localisation_currency->getCurrency($this->currency->getDefaultId());

        if ($currency_info) {
            $data['default_currency'] = [
                'currency_id' => $currency_info['currency_id'],
                'name' => $currency_info['name'],
                'code' => $currency_info['code'],
                'symbol_left' => $currency_info['symbol_left'],
                'symbol_right' => $currency_info['symbol_right'],
                'decimal_place' => $currency_info['decimal_place'],
                'value' => $currency_info['value'],
                'sort_order' => $currency_info['sort_order'],
                'status' => $currency_info['status'],
            ];
        } else {
            $data['default_currency'] = [];
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\product_variant',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function product_variants($input)
    {
        $result = [[]];

        foreach ($input as $key => $values) {
            $append = [];

            foreach($result as $product) {
                foreach($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }

            $result = $append;
        }

        return $result;
    }

    public function get_product_variant_specials()
    {
        $data = [];

        $product_variant_data = [];

        // Get product variant info
        if (!empty($this->request->getGet('product_id'))) {
            $product_id = $this->request->getGet('product_id');
        } else {
            $product_id = 0;
        }

        $product_info = $this->model_seller_product->getProduct($product_id);

        if ($product_info) {
            $product_variant_special = $product_info['product_variant_special'];
        } else {
            $product_variant_special = 0;
        }

        $data['is_product_variant_special'] = $product_variant_special;

        $product_options = $this->session->get('product_options');

        if (!empty($product_options['product_option'])) {
            foreach ($product_options['product_option'] as $product_option) {
                if (!empty($product_option['option_value'])) {
                    $product_variant_data[$product_option['option_id']] = $product_option['option_value'];
                }
            }
        }

        $product_variants = [];
        $product_variant_key = 0;
        $selected_option_data_1 = [];

        $product_variant_ids = $this->product_variants($product_variant_data);

        foreach ($product_variant_ids as $product_variant_id) {
            $option_data = [];

            foreach ($product_variant_id as $key => $value) {
                // Get option info
                $option_info = $this->model_seller_option->getOption($key);

                if (!empty($option_info)) {
                    // Get option value info
                    $option_value_info = $this->model_seller_option->getOptionValue($key, $value);

                    if (!empty($option_value_info)) {
                        $option_data[] = [
                            'option' => $option_info['name'],
                            'option_id' => $option_info['option_id'],
                            'option_value' => $option_value_info['name'],
                            'option_value_id' => $option_value_info['option_value_id'],
                        ];
                    }

                    $selected_option_data_1[$option_info['option_id']] = $option_value_info['option_value_id'];

                    asort($selected_option_data_1);
                }
            }

            $product_variant_specials = $this->model_seller_product->getProductVariantSpecials($product_id, $option_data);

            if ($product_variant_specials) {
                $product_variant_special_data = $product_variant_specials;
            } else {
                $product_variant_special_data = [];
            }

            $product_variants[] = [
                'key' => $product_variant_key,
                'product_variant_id' => $product_variant_id,
                'variant' => $option_data,
                'product_variant_specials' => $product_variant_special_data,
            ];

            $product_variant_key++;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 32, 32, true);

        $data['product_variants'] = $product_variants;
        $data['selected_1'] = $selected_option_data_1;
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['timezones'] = $this->timezone->getList();

        // Get currency info
        $currency_info = $this->model_localisation_currency->getCurrency($this->currency->getDefaultId());

        if ($currency_info) {
            $data['default_currency'] = [
                'currency_id' => $currency_info['currency_id'],
                'name' => $currency_info['name'],
                'code' => $currency_info['code'],
                'symbol_left' => $currency_info['symbol_left'],
                'symbol_right' => $currency_info['symbol_right'],
                'decimal_place' => $currency_info['decimal_place'],
                'value' => $currency_info['value'],
                'sort_order' => $currency_info['sort_order'],
                'status' => $currency_info['status'],
            ];
        } else {
            $data['default_currency'] = [];
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\product_variant_special',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_product_variant_discounts()
    {
        $data = [];

        $product_variant_data = [];

        // Get product variant info
        if (!empty($this->request->getGet('product_id'))) {
            $product_id = $this->request->getGet('product_id');
        } else {
            $product_id = 0;
        }

        $product_info = $this->model_seller_product->getProduct($product_id);

        if ($product_info) {
            $product_variant_discount = $product_info['product_variant_discount'];
        } else {
            $product_variant_discount = 0;
        }

        $data['is_product_variant_discount'] = $product_variant_discount;

        $product_options = $this->session->get('product_options');

        if (!empty($product_options['product_option'])) {
            foreach ($product_options['product_option'] as $product_option) {
                if (!empty($product_option['option_value'])) {
                    $product_variant_data[$product_option['option_id']] = $product_option['option_value'];
                }
            }
        }

        $product_variants = [];
        $product_variant_key = 0;
        $selected_option_data_1 = [];

        $product_variant_ids = $this->product_variants($product_variant_data);

        foreach ($product_variant_ids as $product_variant_id) {
            $option_data = [];

            foreach ($product_variant_id as $key => $value) {
                // Get option info
                $option_info = $this->model_seller_option->getOption($key);

                if (!empty($option_info)) {
                    // Get option value info
                    $option_value_info = $this->model_seller_option->getOptionValue($key, $value);

                    if (!empty($option_value_info)) {
                        $option_data[] = [
                            'option' => $option_info['name'],
                            'option_id' => $option_info['option_id'],
                            'option_value' => $option_value_info['name'],
                            'option_value_id' => $option_value_info['option_value_id'],
                        ];
                    }

                    $selected_option_data_1[$option_info['option_id']] = $option_value_info['option_value_id'];

                    asort($selected_option_data_1);
                }
            }

            $product_variant_discounts = $this->model_seller_product->getProductVariantDiscounts($product_id, $option_data);

            if ($product_variant_discounts) {
                $product_variant_discount_data = $product_variant_discounts;
            } else {
                $product_variant_discount_data = [];
            }

            $product_variants[] = [
                'key' => $product_variant_key,
                'product_variant_id' => $product_variant_id,
                'variant' => $option_data,
                'product_variant_discounts' => $product_variant_discount_data,
            ];

            $product_variant_key++;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 32, 32, true);

        $data['product_variants'] = $product_variants;
        $data['selected_1'] = $selected_option_data_1;
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['timezones'] = $this->timezone->getList();

        // Get currency info
        $currency_info = $this->model_localisation_currency->getCurrency($this->currency->getDefaultId());

        if ($currency_info) {
            $data['default_currency'] = [
                'currency_id' => $currency_info['currency_id'],
                'name' => $currency_info['name'],
                'code' => $currency_info['code'],
                'symbol_left' => $currency_info['symbol_left'],
                'symbol_right' => $currency_info['symbol_right'],
                'decimal_place' => $currency_info['decimal_place'],
                'value' => $currency_info['value'],
                'sort_order' => $currency_info['sort_order'],
                'status' => $currency_info['status'],
            ];
        } else {
            $data['default_currency'] = [];
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\product_variant_discount',
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
                foreach ($this->request->getPost('selected') as $product_id) {
                    // Query
                    $query = $this->model_seller_product->deleteProduct($product_id);

                    $json['success']['toast'] = lang('Success.product_delete', [], $this->language->getCurrentCode());

                    $json['redirect'] = $this->url->customerLink('marketplace/seller/product', '', true);
                }
            } else {
                $json['error']['toast'] = lang('Error.product_delete');
            }
        }

        return $this->response->setJSON($json);
    }

    public function product_download_upload()
    {
        $json = [];

        $file = $this->request->getFile('file');

        $dir = 'customer/' . $this->customer->getId();

        $mask = $file->getRandomName();

        if (!is_dir(WRITEPATH . 'uploads/' . $dir)) {
            mkdir(WRITEPATH . 'uploads/' . $dir, 0755, true);
            file_put_contents(WRITEPATH . 'uploads/' . $dir . '/' . 'index.html', '');
        }

        if (! $file->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file->store($dir, $mask);
        }

        $json['filename'] = $file->getClientName();
        $json['mask'] = $mask;

        $json['success'] = true;

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('product_description.' . $language['language_id'] . '.name', lang('Entry.name', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
                $this->validation->setRule('product_description.' . $language['language_id'] . '.description', lang('Entry.description', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_seller_product->editProduct($this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.product_edit', [], $this->language->getCurrentCode());
                } else {
                    // Query
                    $query = $this->model_seller_product->addProduct($json_data);

                    $json['success']['toast'] = lang('Success.product_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/seller/product', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.name')) {
                        $json['error']['product-description-name-language-' . $language['language_id']] = $this->validation->getError('product_description.' . $language['language_id'] . '.name');
                    }

                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.description')) {
                        $json['error']['product-description-description-language-' . $language['language_id']] = $this->validation->getError('product_description.' . $language['language_id'] . '.description');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
