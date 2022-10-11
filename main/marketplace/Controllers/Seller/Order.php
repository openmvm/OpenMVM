<?php

namespace Main\Marketplace\Controllers\Seller;

class Order extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_seller_order = new \Main\Marketplace\Models\Seller\Order_Model();
        $this->model_checkout_order = new \Main\Marketplace\Models\Checkout\Order_Model();
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_localisation_order_status = new \Main\Marketplace\Models\Localisation\Order_Status_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
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
            'text' => lang('Text.seller_dashboard', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_orders', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/order', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_orders', [], $this->language->getCurrentCode());

        // Get orders
        $data['orders'] = [];

        $orders = $this->model_seller_order->getOrders($this->customer->getSellerId());

        foreach ($orders as $order) {
            // Get order products
            $order_product_data = [];

            $order_products = $this->model_seller_order->getOrderProducts($order['order_id'], $this->customer->getSellerId());

            foreach ($order_products as $order_product) {
                // Get product
                $product_info = $this->model_seller_product->getProduct($order_product['product_id']);

                // Images
                if ($product_info && is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                    $thumb = $this->image->resize($product_info['main_image'], 48, 48, true);
                } else {
                    $thumb = $this->image->resize('no_image.png', 48, 48, true);
                }

                // Get product description
                $product_description = $this->model_product_product->getProductDescription($order_product['product_id']);

                $order_product_data[] = [
                    'order_product_id' => $order_product['order_product_id'],
                    'order_id' => $order_product['order_id'],
                    'seller_id' => $order_product['seller_id'],
                    'product_id' => $order_product['product_id'],
                    'name' => $order_product['name'],
                    'thumb' => $thumb,
                    'quantity' => $order_product['quantity'],
                    'price' => $order_product['price'],
                    'total' => $order_product['total'],
                    'option' => json_decode($order_product['option'], true),
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_description['slug'] . '-p' . $order_product['product_id']),
                ];
            }

            // Order statuses
            $order_status_data = [];
    
            // Get order status histories
            $order_status = $this->model_seller_order->getLatestOrderStatus($order['order_id'], $this->customer->getSellerId());

            if ($order_status) {
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
            }

            // Get order total
            $order_total_info = $this->model_seller_order->getOrderTotal($order['order_id'], $this->customer->getSellerId(), 'total');

            if ($order_total_info) {
                $total = $order_total_info['value'];
            } else {
                $total = 0;
            }

            $data['orders'][] = [
                'order_id' => $order['order_id'],
                'invoice' => $order['invoice'],
                'product' => $order_product_data,
                'total' => $this->currency->format($total, $order['currency_code'], $order['currency_value']),
                'date_added' => date(lang('Common.datetime_format', [], $this->language->getCurrentCode()), strtotime($order['date_added'])),
                'date' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($order['date_added'])),
                'time' => date(lang('Common.time_format', [], $this->language->getCurrentCode()), strtotime($order['date_added'])),
                'order_status' => $order_status_data,
                'info' => $this->url->customerLink('marketplace/seller/order/info/' . $order['order_id'], '', true),
            ];
        }

        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);
        $data['update_order_status'] = $this->url->customerLink('marketplace/seller/order/update_order_status', '', true);

        $data['language'] = $this->language;

        $data['non_rejectable_order_statuses'] = $this->setting->get('setting_non_rejectable_order_statuses');
        $data['non_acceptable_order_statuses'] = $this->setting->get('setting_non_acceptable_order_statuses');
        $data['processing_order_statuses'] = $this->setting->get('setting_processing_order_statuses');
        $data['completed_order_statuses'] = $this->setting->get('setting_completed_order_statuses');
        $data['accepted_order_status_id'] = $this->setting->get('setting_accepted_order_status_id');
        $data['rejected_order_status_id'] = $this->setting->get('setting_rejected_order_status_id');
        $data['shipped_order_status_id'] = $this->setting->get('setting_shipped_order_status_id');
        $data['delivered_order_status_id'] = $this->setting->get('setting_delivered_order_status_id');

        // Header
        $header_params = array(
            'title' => lang('Heading.my_orders', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\order_list',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function info()
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
            'text' => lang('Text.seller_dashboard', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_orders', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/order', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.order_info', [], $this->language->getCurrentCode()),
            'href' => '',
            'active' => true,
        );

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['cancel'] = $this->url->customerLink('marketplace/seller/order', '', true);

        $order_info = $this->model_seller_order->getOrder($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($order_info) {
            $data['heading_title'] = lang('Heading.order_info', [], $this->language->getCurrentCode());

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

            // Get order products
            $data['order_products'] = [];

            $order_products = $this->model_seller_order->getOrderProducts($order_info['order_id'], $this->customer->getSellerId());

            foreach ($order_products as $order_product) {
                // Get product info
                $product_info = $this->model_product_product->getProduct($order_product['product_id']);

                if ($product_info) {
                    // Get product description
                    $product_description = $this->model_product_product->getProductDescription($order_product['product_id']);
                } else {
                    $product_description = [];
                }

                $data['order_products'][] = [
                    'product_id' => $order_product['product_id'],
                    'name' => $order_product['name'],
                    'quantity' => $order_product['quantity'],
                    'price' => $this->currency->format($order_product['price'], $order_info['currency_code'], $order_info['currency_value']),
                    'total' => $this->currency->format($order_product['total'], $order_info['currency_code'], $order_info['currency_value']),
                    'option' => json_decode($order_product['option'], true),
                    'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_description['slug'] . '-p' . $order_product['product_id']),
                ];
            }

            // Get order totals
            $data['order_totals'] = [];

            $order_totals = $this->model_seller_order->getOrderTotals($order_info['order_id'], $this->customer->getSellerId());

            foreach ($order_totals as $order_total) {
                $data['order_totals'][] = [
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
            $data['order_status_histories'] = [];

            $order_status_histories = $this->model_seller_order->getOrderStatusHistories($order_info['order_id'], $this->customer->getSellerId());

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

            // Order status
            // Get latest order status
            $data['order_status'] = '';

            $order_status = $this->model_seller_order->getLatestOrderStatus($order_info['order_id'], $this->customer->getSellerId());

            if ($order_status) {
                $order_status_description = $this->model_localisation_order_status->getOrderStatusDescription($order_status['order_status_id']);

                if ($order_status_description) {
                    $data['order_status'] = $order_status_description['name'];
                }
            }

            // Order payment method
            $data['payment_method'] = $order_info['payment_method_title'];

            // Order shipping method
            $order_shipping = $this->model_seller_order->getOrderShipping($order_info['order_id'], $this->customer->getSellerId());

            if ($order_shipping) {
                $data['shipping_method'] = $order_shipping['text'];
                $data['tracking_number'] = $order_shipping['tracking_number'];

                $data['tracking_number_add'] = $this->url->customerLink('marketplace/seller/order/add_tracking_number', ['order_id' => $order_info['order_id']], true);
            } else {
                $data['shipping_method'] = '';
                $data['tracking_number'] = '';

                $data['tracking_number_add'] = $this->url->customerLink('marketplace/seller/order/add_tracking_number', '', true);
            }

            $data['language'] = $this->language;

            // Header
            $header_params = array(
                'title' => lang('Heading.order_info', [], $this->language->getCurrentCode()),
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
                'view' => 'Seller\order_info',
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

    public function add_tracking_number()
    {
        $json = [];

        if (!empty($this->request->getGet('order_id'))) {
            // Get latest order status
            $order_status = $this->model_seller_order->getLatestOrderStatus($this->request->getGet('order_id'), $this->customer->getSellerId());

            if ($order_status) {
                $current_order_status_order_id = $order_status['order_status_id'];
            } else {
                $current_order_status_order_id = 0;
            }

            // Get order shipping info
            $order_shipping_info = $this->model_seller_order->getOrderShipping($this->request->getGet('order_id'), $this->customer->getSellerId());

            if ($order_shipping_info) {
                $order_id = $this->request->getGet('order_id');
                $seller_id = $this->customer->getSellerId();
                $order_status_id = $this->setting->get('setting_shipped_order_status_id');

                if ($current_order_status_order_id === $this->setting->get('setting_accepted_order_status_id') || $current_order_status_order_id === $this->setting->get('setting_shipped_order_status_id')) {
                    // Edit tracking number
                    $this->model_seller_order->editTrackingNumber($this->request->getGet('order_id'), $this->customer->getSellerId(), $this->request->getPost());

                    // Get order status descriptions
                    $order_status_descriptions = $this->model_localisation_order_status->getOrderStatusDescriptions($order_status_id);

                    if ($order_status_descriptions) {
                        foreach ($order_status_descriptions as $key => $value) {
                            $comment[$key] = $value['message'];
                        }
                    } else {
                        $comment = [];
                    }

                    $this->model_checkout_order->addOrderStatusHistory($order_id, $seller_id, $order_status_id, $comment, true);

                    $json['redirect'] = $this->url->customerLink('marketplace/seller/order/info/' . $this->request->getGet('order_id'), '', true);

                    $json['success'] = lang('Success.tracking_number_update', [], $this->language->getCurrentCode());
                } else {
                    $json['error'] = lang('Error.try_again', [], $this->language->getCurrentCode());
                }
            } else {
                $json['error'] = lang('Error.try_again', [], $this->language->getCurrentCode());
            }
        } else {
            $json['error'] = lang('Error.try_again', [], $this->language->getCurrentCode());
        }

        return $this->response->setJSON($json);
    }

    public function update_order_status()
    {
        $json = [];

        if (!empty($this->request->getPost('order_id')) && !empty($this->request->getPost('order_status_id'))) {
            // Get order status info
            $order_status_info = $this->model_localisation_order_status->getOrderStatus($this->request->getPost('order_status_id'));

            if ($order_status_info) {
                $order_id = $this->request->getPost('order_id');
                $seller_id = $this->customer->getSellerId();
                $order_status_id = $order_status_info['order_status_id'];

                // Get order status descriptions
                $order_status_descriptions = $this->model_localisation_order_status->getOrderStatusDescriptions($order_status_id);

                if ($order_status_descriptions) {
                    foreach ($order_status_descriptions as $key => $value) {
                        $comment[$key] = $value['message'];
                    }
                } else {
                    $comment = [];
                }

                $this->model_checkout_order->addOrderStatusHistory($order_id, $seller_id, $order_status_id, $comment, true);

                $json['success'] = $comment[$this->language->getCurrentId()];
            } else {
                $json['error'] = lang('Text.error', [], 'en');
            }
        } else {
            $json['error'] = lang('Text.error', [], 'en');
        }

        $json['redirect'] = $this->url->customerLink('marketplace/seller/order', '', true);

        return $this->response->setJSON($json);
    }
}
