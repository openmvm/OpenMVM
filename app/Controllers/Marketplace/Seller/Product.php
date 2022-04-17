<?php

namespace App\Controllers\Marketplace\Seller;

class Product extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_localisation_language = new \App\Models\Marketplace\Localisation\Language_Model();
        $this->model_localisation_weight_class = new \App\Models\Marketplace\Localisation\Weight_Class_Model();
        $this->model_product_category = new \App\Models\Marketplace\Product\Category_Model();
        $this->model_seller_product = new \App\Models\Marketplace\Seller\Product_Model();
    }

    public function index()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['action'] = $this->url->customerLink('marketplace/seller/product', '', true);

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            foreach ($this->request->getPost('selected') as $product_id) {
                // Query
                $query = $this->model_seller_product->deleteProduct($product_id);

                $this->session->set('success', lang('Success.product_delete'));

                return redirect()->to($this->url->customerLink('marketplace/seller/product', '', true));
            }
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->customerLink('marketplace/seller/product/add', '', true);

        if ($this->request->getMethod() == 'post') {
            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('product_description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('product_description.' . $language['language_id'] . '.description', lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_product->addProduct($this->request->getPost());

                $this->session->set('success', lang('Success.product_add'));

                return redirect()->to($this->url->customerLink('marketplace/seller/product', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.name')) {
                        $data['error_product_description'][$language['language_id']]['name'] = $this->validation->getError('product_description.' . $language['language_id'] . '.name');
                    } else {
                        $data['error_product_description'][$language['language_id']]['name'] = '';
                    }

                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.description')) {
                        $data['error_product_description'][$language['language_id']]['description'] = $this->validation->getError('product_description.' . $language['language_id'] . '.description');
                    } else {
                        $data['error_product_description'][$language['language_id']]['description'] = '';
                    }
                }
            }
        }

        return $this->get_form($data);
    }

    public function edit()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->customerLink('marketplace/seller/product/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        if ($this->request->getMethod() == 'post') {
            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('product_description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('product_description.' . $language['language_id'] . '.description', lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_product->editProduct($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.product_edit'));

                return redirect()->to($this->url->customerLink('marketplace/seller/product', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.name')) {
                        $data['error_product_description'][$language['language_id']]['name'] = $this->validation->getError('product_description.' . $language['language_id'] . '.name');
                    } else {
                        $data['error_product_description'][$language['language_id']]['name'] = '';
                    }

                    if ($this->validation->hasError('product_description.' . $language['language_id'] . '.description')) {
                        $data['error_product_description'][$language['language_id']]['description'] = $this->validation->getError('product_description.' . $language['language_id'] . '.description');
                    } else {
                        $data['error_product_description'][$language['language_id']]['description'] = '';
                    }
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.products'),
            'href' => $this->url->customerLink('marketplace/seller/product', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.products');

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

            $data['products'][] = [
                'product_id' => $product['product_id'],
                'name' => $product_description_info['name'],
                'thumb' => $thumb,
                'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                'status' => $product['status'] ? lang('Text.enabled') : lang('Text.disabled'),
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

        // Header
        $header_params = array(
            'title' => lang('Heading.products'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\product_list', $data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.products'),
            'href' => $this->url->customerLink('marketplace/seller/product', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $product_info = $this->model_seller_product->getProduct($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $product_info = [];
        }

        $data['heading_title'] = lang('Heading.products');

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($product_info) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('product_description')) {
            $data['product_description'] = $this->request->getPost('product_description');
        } elseif ($product_info) {
            $data['product_description'] = $this->model_seller_product->getProductDescriptions($product_info['product_id']);
        } else {
            $data['product_description'] = [];
        }

        if ($this->request->getPost('category_id_path')) {
            $data['category_id_path'] = $this->request->getPost('category_id_path');
        } elseif ($product_info) {
            $data['category_id_path'] = $product_info['category_id_path'];
        } else {
            $data['category_id_path'] = '';
        }

        if ($this->request->getPost('price')) {
            $data['price'] = $this->request->getPost('price');
        } elseif ($product_info) {
            $data['price'] = $product_info['price'];
        } else {
            $data['price'] = 0;
        }

        if ($this->request->getPost('weight')) {
            $data['weight'] = $this->request->getPost('weight');
        } elseif ($product_info) {
            $data['weight'] = $product_info['weight'];
        } else {
            $data['weight'] = 0;
        }

        if ($this->request->getPost('weight_class_id')) {
            $data['weight_class_id'] = $this->request->getPost('weight_class_id');
        } elseif ($product_info) {
            $data['weight_class_id'] = $product_info['weight_class_id'];
        } else {
            $data['weight_class_id'] = 0;
        }

        if ($this->request->getPost('main_image')) {
            $data['thumb'] = $this->image->resize($this->request->getPost('main_image'), 100, 100, true);
            $data['main_image'] = $this->request->getPost('main_image');
        } elseif ($product_info && is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
            $data['thumb'] = $this->image->resize($product_info['main_image'], 100, 100, true);
            $data['main_image'] = $product_info['main_image'];
        } else {
            $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
            $data['main_image'] = 'no_image.png';
        }

        $data['categories'] = [];

        $categories = $this->model_product_category->getCategories();

        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id_path' => $category['category_id_path'],
                'category_path' => $category['category_path'],
            ];
        }

        $data['default_currency_code'] = $this->currency->getCode($this->setting->get('setting_marketplace_currency_id'));

        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['cancel'] = $this->url->customerLink('marketplace/seller/product', '', true);

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce-5.10.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
        ];
        $header_params = array(
            'title' => lang('Heading.products'),
            'breadcrumbs' => $breadcrumbs,
            'scripts' => $scripts,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\product_form', $data);
    }
}
