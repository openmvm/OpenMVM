<?php

namespace Main\Admin\Controllers\Marketplace;

class Order extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_marketplace_order = new \Main\Admin\Models\Marketplace\Order_Model();
        $this->model_marketplace_product = new \Main\Admin\Models\Marketplace\Product_Model();
        $this->model_marketplace_seller = new \Main\Admin\Models\Marketplace\Seller_Model();
        $this->model_localisation_country = new \Main\Admin\Models\Localisation\Country_Model();
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_order_status = new \Main\Admin\Models\Localisation\Order_Status_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.orders'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.orders');

        // Get orders
        $data['orders'] = [];

        $orders = $this->model_marketplace_order->getOrders();

        foreach ($orders as $order) {
            $data['orders'][] = [
                'order_id' => $order['order_id'],
                'invoice' => $order['invoice'],
                'info' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/info/' . $order['order_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.orders'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\order_list',
            'permission' => 'Marketplace/Order',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.orders'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $order_info = $this->model_marketplace_order->getOrder($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $order_info = [];
        }

        $data['heading_title'] = lang('Heading.orders');

        if ($order_info) {
            $data['status'] = $order_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
        ];
        $header_params = array(
            'title' => lang('Heading.orders'),
            'scripts' => $scripts,
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\order_form',
            'permission' => 'Marketplace/Order',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function info()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.orders'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.order_info'),
            'href' => '',
            'active' => true,
        );
        
        $order_info = $this->model_marketplace_order->getOrder($this->uri->getSegment($this->uri->getTotalSegments()));

        $data['heading_title'] = lang('Heading.order_info') . ' - ' . $order_info['invoice'];

        // Order info
        $data['order_id'] = $order_info['order_id'];
        $data['invoice'] = $order_info['invoice'];
        $data['name'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
        $data['email'] = $order_info['email'];
        $data['telephone'] = $order_info['telephone'];

        // Get payment country info
        $payment_country_info = $this->model_localisation_country->getCountry($order_info['payment_country_id']);

        if ($payment_country_info && !empty($payment_country_info['address_format'])) {
            $payment_address_format = $payment_country_info['address_format'];
        } else {
            $payment_address_format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city}, {zone}, {country}' . "\n" . lang('Text.telephone', [], $this->language->getCurrentCode()) . ': ' . '{telephone}';
        }

        $find = [
            '{firstname}',
            '{lastname}',
            '{address_1}',
            '{address_2}',
            '{city}',
            '{zone}',
            '{country}',
            '{telephone}',
            "\n\n",
        ];

        $payment_address_replace = [
            $order_info['payment_firstname'],
            $order_info['payment_lastname'],
            $order_info['payment_address_1'],
            $order_info['payment_address_2'],
            $order_info['payment_city'],
            $order_info['payment_zone'],
            $order_info['payment_country'],
            $order_info['payment_telephone'],
            "\n",
        ];

        $data['payment_address'] = nl2br(str_replace($find, $payment_address_replace, $payment_address_format));

        // Get shipping address info
        $shipping_country_info = $this->model_localisation_country->getCountry($order_info['shipping_country_id']);

        if ($shipping_country_info && !empty($shipping_country_info['address_format'])) {
            $shipping_address_format = $shipping_country_info['address_format'];
        } else {
            $shipping_address_format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city}, {zone}, {country}' . "\n" . lang('Text.telephone', [], $this->language->getCurrentCode()) . ': ' . '{telephone}';
        }

        $find = [
            '{firstname}',
            '{lastname}',
            '{address_1}',
            '{address_2}',
            '{city}',
            '{zone}',
            '{country}',
            '{telephone}',
            "\n\n",
        ];

        $shipping_address_replace = [
            $order_info['shipping_firstname'],
            $order_info['shipping_lastname'],
            $order_info['shipping_address_1'],
            $order_info['shipping_address_2'],
            $order_info['shipping_city'],
            $order_info['shipping_zone'],
            $order_info['shipping_country'],
            $order_info['shipping_telephone'],
            "\n",
        ];

        $data['shipping_address'] = nl2br(str_replace($find, $shipping_address_replace, $shipping_address_format));

        $data['date_added'] = date(lang('Common.datetime_format', [], $this->language->getCurrentCode()), strtotime($order_info['date_added']));

        // Get order sellers
        $data['sellers'] = [];

        $order_sellers = $this->model_marketplace_order->getOrderSellers($order_info['order_id']);

        foreach ($order_sellers as $seller_id) {
            $seller_info = $this->model_marketplace_seller->getSeller($seller_id);

            if ($seller_info) {
                // Get order products
                $order_product_data = [];

                $order_products = $this->model_marketplace_order->getOrderProducts($order_info['order_id'], $seller_id);

                foreach ($order_products as $order_product) {
                    // Get seller info
                    $seller_info = $this->model_marketplace_seller->getSeller($order_product['seller_id']);

                    if ($seller_info) {
                        $seller = [
                            'seller_id' => $seller_info['seller_id'],
                            'customer_id' => $seller_info['customer_id'],
                            'store_name' => $seller_info['store_name'],
                            'store_description' => $seller_info['store_description'],
                        ];
                    } else {
                        $seller = [];
                    }

                    // Get product info
                    $product_info = $this->model_marketplace_product->getProduct($order_product['product_id']);

                    if ($product_info) {
                        // Get product description
                        $product_description = $this->model_marketplace_product->getProductDescription($order_product['product_id']);
                    } else {
                        $product_description = [];
                    }

                    $order_product_data[] = [
                        'product_id' => $order_product['product_id'],
                        'name' => $order_product['name'],
                        'quantity' => $order_product['quantity'],
                        'price' => $this->currency->format($order_product['price'], $order_info['currency_code'], $order_info['currency_value']),
                        'total' => $this->currency->format($order_product['total'], $order_info['currency_code'], $order_info['currency_value']),
                        'option' => json_decode($order_product['option'], true),
                        'seller' => $seller,
                        'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_description['slug'] . '-p' . $order_product['product_id']),
                    ];
                }

                // Get order totals
                $order_total_data = [];

                $order_totals = $this->model_marketplace_order->getOrderTotals($order_info['order_id'], $seller_id);

                foreach ($order_totals as $order_total) {
                    $order_total_data[] = [
                        'order_total_id' => $order_total['order_total_id'],
                        'order_id' => $order_total['order_id'],
                        'seller_id' => $order_total['seller_id'],
                        'code' => $order_total['code'],
                        'title' => $order_total['title'],
                        'value' => $this->currency->format($order_total['value'], $order_info['currency_code'], $order_info['currency_value']),
                        'sort_order' => $order_total['sort_order'],
                    ];
                }

                // Get order status histories
                $order_status_history_data = [];

                $order_status_histories = $this->model_marketplace_order->getOrderStatusHistories($order_info['order_id'], $seller_id);

                foreach ($order_status_histories as $order_status_history) {
                    // Get order status description
                    $order_status_description = $this->model_localisation_order_status->getOrderStatusDescription($order_status_history['order_status_id']);
                    
                    if (!empty($order_status_history['comment'][$this->language->getCurrentId()])) {
                        $comment = $order_status_history['comment'][$this->language->getCurrentId()];
                    } else {
                        $comment = '';
                    }

                    $order_status_history_data[] = [
                        'order_status_history_id' => $order_status_history['order_status_history_id'],
                        'order_id' => $order_status_history['order_id'],
                        'order_status_id' => $order_status_history['order_status_id'],
                        'order_status' => $order_status_description['name'],
                        'comment' => html_entity_decode(nl2br($comment), ENT_QUOTES, 'UTF-8'),
                        'notify' => $order_status_history['notify'],
                        'date_added' => date(lang('Common.datetime_format', [], $this->language->getCurrentCode()), strtotime($order_status_history['date_added'])),
                    ];
                }

                $data['sellers'][] = [
                    'seller_id' => $seller_info['seller_id'],
                    'customer_id' => $seller_info['customer_id'],
                    'store_name' => $seller_info['store_name'],
                    'store_description' => $seller_info['store_description'],
                    'product' => $order_product_data,
                    'total' => $order_total_data,
                    'order_status' => $order_status_history_data,
                    'href' => $this->url->customerLink('marketplace/seller/seller', ['seller_id' => $seller_info['seller_id']]),
                ];
            }
        }

        // Order statuses
        // Get order status description
        foreach ($order_sellers as $seller_id) {
            $seller_info = $this->model_marketplace_seller->getSeller($seller_id);

            if ($seller_info) {
                $order_status_data = [];

                // Get order status histories
                $order_status = $this->model_marketplace_order->getLatestOrderStatus($order_info['order_id'], $seller_id);

                $order_status_description = $this->model_localisation_order_status->getOrderStatusDescription($order_status['order_status_id']);

                if ($order_status_description) {
                    $order_status_description = $order_status_description['name'];
                } else {
                    $order_status_description = '';
                }

                $order_status_data = [
                    'order_status_id' => $order_status['order_status_id'],
                    'name' => $order_status_description,
                ];

                $data['order_status_histories'][] = [
                    'seller_id' => $seller_id,
                    'store_name' => $seller_info['store_name'],
                    'order_id' => $order_info['order_id'],
                    'order_status' => $order_status_data,
                ];
            }
        }

        // Order payment method
        $data['payment_method'] = $order_info['payment_method_title'];
        $data['payment_method_text'] = $order_info['payment_method_text'];

        // Order shipping methods
        $data['shipping_methods'] = [];

        foreach ($order_sellers as $seller_id) {
            // Get seller info
            $seller_info = $this->model_marketplace_seller->getSeller($seller_id);

            if ($seller_info) {
                // Get order shipping
                $order_shipping = $this->model_marketplace_order->getOrderShipping($order_info['order_id'], $seller_id);

                if ($order_shipping) {
                    $data['shipping_methods'][] = [
                        'seller' => $seller_info['store_name'],
                        'shipping_method' => $order_shipping['text'],
                        'tracking_number' => $order_shipping['tracking_number'],
                    ];
                }
            }
        }

        // Get total order amount
        $total_order = 0;

        $totals = $this->model_marketplace_order->getOrderTotalsByCode($order_info['order_id'], 'total');

        foreach ($totals as $total) {
            $total_order += $total['value'];
        }

        $data['total_order_amount'] = $this->currency->format($total_order, $order_info['currency_code'], $order_info['currency_value']);

        $data['order_add_message_3'] = stripslashes(sprintf(lang('Text.order_add_message_3', [], $this->language->getCurrentCode()), $this->url->customerLink('marketplace/account/order', '', true)));

        $data['non_cancelable_order_statuses'] = $this->setting->get('setting_non_cancelable_order_statuses');
        $data['delivered_order_status_id'] = $this->setting->get('setting_delivered_order_status_id');
        $data['canceled_order_status_id'] = $this->setting->get('setting_canceled_order_status_id');
        $data['completed_order_status_id'] = $this->setting->get('setting_completed_order_status_id');

        $data['get_order_status'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/get_order_status');
        $data['update_order_status_history'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/update_order_status_history');
        $data['get_order_status_histories_url'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order/order_status_history');

        $data['language'] = $this->language;

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['language_lib'] = $this->language;

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.order_info') . ' - ' . $order_info['invoice'],
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\order_info',
            'permission' => 'Marketplace/Order',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function order_status_history()
    {
        $data['heading_title'] = lang('Heading.order_status_histories');

        // Get order status histories
        $data['order_status_histories'] = [];

        $order_status_histories = $this->model_marketplace_order->getOrderStatusHistories($this->request->getGet('order_id'), $this->request->getGet('seller_id'));

        foreach ($order_status_histories as $order_status_history) {
            // Get order status description
            $order_status_description = $this->model_localisation_order_status->getOrderStatusDescription($order_status_history['order_status_id']);
            
            if (!empty($order_status_history['comment'][$this->language->getCurrentId()])) {
                $comment = $order_status_history['comment'][$this->language->getCurrentId()];
            } else {
                $comment = '';
            }

            $data['order_status_histories'][] = [
                'order_status_history_id' => $order_status_history['order_status_history_id'],
                'order_id' => $order_status_history['order_id'],
                'order_status_id' => $order_status_history['order_status_id'],
                'order_status' => $order_status_description['name'],
                'comment' => html_entity_decode(nl2br($comment), ENT_QUOTES, 'UTF-8'),
                'notify' => $order_status_history['notify'],
                'date_added' => date(lang('Common.datetime_format', [], $this->language->getCurrentCode()), strtotime($order_status_history['date_added'])),
            ];
        }

        $data['language_lib'] = $this->language;

        $data['administrator_token'] = $this->administrator->getToken();

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\order_status_history',
            'permission' => 'Marketplace/Order',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Order')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $order_id) {
                        // Query
                        $query = $this->model_marketplace_order->deleteOrder($order_id);
                    }

                    $json['success']['toast'] = lang('Success.order_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order');
                } else {
                    $json['error']['toast'] = lang('Error.order_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Order')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('status', lang('Entry.status'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_marketplace_order->editOrder($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.order_edit');
                    } else {
                        // Query
                        $query = $this->model_marketplace_order->addOrder($this->request->getPost());

                        $json['success']['toast'] = lang('Success.order_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/order');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('status')) {
                        $json['error']['status'] = $this->validation->getError('status');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function update_order_status_history()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $order_status_descriptions = $this->model_localisation_order_status->getOrderStatusDescriptions($json_data['order_status_id']);

            foreach ($order_status_descriptions as $order_status_description) {
                $comment[$order_status_description['language_id']] = $order_status_description['message'];
            }

            $this->model_marketplace_order->addOrderStatusHistory($json_data['order_id'], $json_data['seller_id'], $json_data['order_status_id'], $comment, $json_data['notify']);

            $json = [
                'order_id' => $json_data['order_id'],
                'seller_id' => $json_data['seller_id'],
            ];
        }

        return $this->response->setJSON($json);
    }
}
