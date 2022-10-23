<?php

namespace Main\Marketplace\Controllers\Account;

class Product_Review extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_account_order = new \Main\Marketplace\Models\Account\Order_Model();
        $this->model_account_product_review = new \Main\Marketplace\Models\Account\Product_Review_Model();
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
    }

    public function add()
    {
        $data['heading_title'] = lang('Heading.product_review_add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/account/product_review/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['heading_title'] = lang('Heading.product_review_edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/account/product_review/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        return $this->get_form($data);
    }

    public function delete()
    {
        // Query
        $query = $this->model_account_product_review->deleteProductReview($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

        $this->session->set('success', lang('Success.product_review_delete', [], $this->language->getCurrentCode()));

        return redirect()->to($this->url->customerLink('marketplace/account/product_review', '', true));
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
            'text' => lang('Text.my_product_reviews', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/product_review', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_product_reviews', [], $this->language->getCurrentCode());

        // Get order products
        $data['order_products'] = [];

        $order_products = $this->model_account_order->getOrderProductsByOrderStatusId($this->setting->get('setting_completed_order_status_id'));

        foreach ($order_products as $order_product) {
            // Get product info
            $product_info = $this->model_product_product->getProduct($order_product['product_id']);

            if ($product_info && ROOTPATH . 'public/assets/images/' . $product_info['main_image']) {
                $thumb = $this->image->resize($product_info['main_image'], 48, 48, true);
            } else {
                $thumb = $this->image->resize('no_image.png', 48, 48, true);
            }

            if ($product_info) {
                $href = $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug']);
            } else {
                $href = '';
            }

            // Get product review by order_product_id
            $product_review = $this->model_account_product_review->getProductReviewByOrderProductId($this->customer->getId(), $order_product['order_product_id']);

            if ($product_review) {
                $product_review_data = $product_review;
            } else {
                $product_review_data = [];
            }

            $data['order_products'][] = [
                'order_product_id' => $order_product['order_product_id'],
                'order_id' => $order_product['order_id'],
                'seller_id' => $order_product['seller_id'],
                'product_id' => $order_product['product_id'],
                'thumb' => $thumb,
                'name' => $order_product['name'],
                'quantity' => $order_product['quantity'],
                'price' => $order_product['price'],
                'option' => $order_product['option'],
                'option_ids' => $order_product['option_ids'],
                'total' => $order_product['total'],
                'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($order_product['date_added'])),
                'href' => $href,
                'product_review' => $product_review_data,
                'add' => $this->url->customerLink('marketplace/account/product_review/add/' . $order_product['order_product_id'], '', true),
                'edit' => $this->url->customerLink('marketplace/account/product_review/edit/' . $order_product['order_product_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/account/product_review/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/account/product_review', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.my_product_reviews', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\product_review_list',
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
            'text' => lang('Text.my_product_reviews', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/product_review', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $product_review_info = $this->model_account_product_review->getProductReviewByOrderProductId($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $product_review_info = [];
        }

        // Get order product info
        $order_product_info = $this->model_account_order->getOrderProduct($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($product_review_info) {
            $data['product_review_id'] = $product_review_info['product_review_id'];
        } else {
            $data['product_review_id'] = 0;
        }

        if ($product_review_info) {
            $data['order_product_id'] = $product_review_info['order_product_id'];
        } elseif ($order_product_info) {
            $data['order_product_id'] = $order_product_info['order_product_id'];
        } else {
            $data['order_product_id'] = 0;
        }

        if ($product_review_info) {
            $data['order_id'] = $product_review_info['order_id'];
        } elseif ($order_product_info) {
            $data['order_id'] = $order_product_info['order_id'];
        } else {
            $data['order_id'] = 0;
        }

        if ($product_review_info) {
            $data['product_id'] = $product_review_info['product_id'];
        } elseif ($order_product_info) {
            $data['product_id'] = $order_product_info['product_id'];
        } else {
            $data['product_id'] = 0;
        }

        if ($product_review_info) {
            $data['seller_id'] = $product_review_info['seller_id'];
        } elseif ($order_product_info) {
            $data['seller_id'] = $order_product_info['seller_id'];
        } else {
            $data['seller_id'] = 0;
        }

        if ($product_review_info) {
            $data['rating'] = $product_review_info['rating'];
        } else {
            $data['rating'] = 0;
        }

        if ($product_review_info) {
            $data['title'] = $product_review_info['title'];
        } else {
            $data['title'] = '';
        }

        if ($product_review_info) {
            $data['review'] = $product_review_info['review'];
        } else {
            $data['review'] = '';
        }

        if ($product_review_info) {
            $data['status'] = $product_review_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->customerLink('marketplace/account/product_review', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.my_product_reviews', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\product_review_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('rating', lang('Entry.rating', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('review', lang('Entry.review', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_account_product_review->editProductReview($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.product_review_edit', [], $this->language->getCurrentCode());
                } else {
                    // Query
                    $query = $this->model_account_product_review->addProductReview($this->customer->getId(), $json_data);

                    $json['success']['toast'] = lang('Success.product_review_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/account/product_review', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                if ($this->validation->hasError('rating')) {
                    $json['error']['rating'] = $this->validation->getError('rating');
                }

                if ($this->validation->hasError('review')) {
                    $json['error']['review'] = $this->validation->getError('review');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
