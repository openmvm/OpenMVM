<?php

namespace Main\Marketplace\Controllers\Checkout;

class Success extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_account_order = new \Main\Marketplace\Models\Account\Order_Model();
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_localisation_order_status = new \Main\Marketplace\Models\Localisation\Order_Status_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index()
    {
        if ($this->session->has('customer_order_id')) {
            $order_id = $this->session->get('customer_order_id');
        } else {
            $order_id = 0;
        }

        $order_sellers = $this->model_account_order->getOrderSellers($order_id);

        // Remove cart
        foreach ($order_sellers as $seller_id) {
            $this->cart->clear($this->customer->getId(), $seller_id, $this->cart->getKey());
        }

        // Remove checkout session data
        $this->session->remove('checkout_payment_address_id');
        $this->session->remove('checkout_shipping_address_id');

        foreach ($order_sellers as $seller_id) {
            $this->session->remove('checkout_shipping_method_' . $seller_id);
        }

        $this->session->remove('checkout_payment_method_code');
        $this->session->remove('checkout_order_id');

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
            'text' => lang('Text.checkout', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/checkout/checkout', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.success', [], $this->language->getCurrentCode());

        // Get order info
        $order_info = $this->model_account_order->getOrder($this->customer->getId(), $order_id);

        if ($order_info) {
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

            $order_sellers = $this->model_account_order->getOrderSellers($order_info['order_id']);

            foreach ($order_sellers as $seller_id) {
                $seller_info = $this->model_seller_seller->getSeller($seller_id);

                if ($seller_info) {
                    // Get order products
                    $order_product_data = [];

                    $order_products = $this->model_account_order->getOrderProducts($order_info['order_id'], $seller_id);

                    foreach ($order_products as $order_product) {
                        // Get seller info
                        $seller_info = $this->model_seller_seller->getSeller($order_product['seller_id']);

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
                        $product_info = $this->model_product_product->getProduct($order_product['product_id']);

                        if ($product_info) {
                            // Get product description
                            $product_description = $this->model_product_product->getProductDescription($order_product['product_id']);
                        } else {
                            $product_description = [];
                        }

                        $order_product_data[] = [
                            'product_id' => $order_product['product_id'],
                            'name' => $order_product['name'],
                            'quantity' => $order_product['quantity'],
                            'price' => $this->currency->format($order_product['price'], $order_info['currency_code'], $order_info['currency_value']),
                            'total' => $this->currency->format($order_product['total'], $order_info['currency_code'], $order_info['currency_value']),
                            'seller' => $seller,
                            'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_description['slug'] . '-p' . $order_product['product_id']),
                        ];
                    }

                    // Get order totals
                    $order_total_data = [];

                    $order_totals = $this->model_account_order->getOrderTotals($order_info['order_id'], $seller_id);

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

                    $order_status_histories = $this->model_account_order->getOrderStatusHistories($order_info['order_id'], $seller_id);

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
                        'href' => $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['seller_id']),
                    ];
                }
            }

            // Order statuses
            // Get order status description
            foreach ($order_sellers as $seller_id) {
                $seller_info = $this->model_seller_seller->getSeller($seller_id);

                if ($seller_info) {
                    // Get order status histories
                    $order_status = $this->model_account_order->getLatestOrderStatus($order_info['order_id'], $seller_id);

                    $order_status_description = $this->model_localisation_order_status->getOrderStatusDescription($order_status['order_status_id']);

                    if ($order_status_description) {
                        $order_status = $order_status_description['name'];
                    } else {
                        $order_status = '';
                    }

                    $data['order_statuses'][] = [
                        'store_name' => $seller_info['store_name'],
                        'order_status' => $order_status,
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
                $seller_info = $this->model_seller_seller->getSeller($seller_id);

                if ($seller_info) {
                    // Get order shipping
                    $order_shipping = $this->model_account_order->getOrderShipping($order_info['order_id'], $seller_id);

                    if ($order_shipping) {
                        $data['shipping_methods'][] = [
                            'seller' => $seller_info['store_name'],
                            'shipping_method' => $order_shipping['text'],
                        ];
                    }
                }
            }

            // Get total order amount
            $total_order = 0;

            $totals = $this->model_account_order->getOrderTotalsByCode($order_id, 'total');

            foreach ($totals as $total) {
                $total_order += $total['value'];
            }

            $data['total_order_amount'] = $this->currency->format($total_order, $order_info['currency_code'], $order_info['currency_value']);

            $data['order_add_message_3'] = stripslashes(sprintf(lang('Text.order_add_message_3', [], $this->language->getCurrentCode()), $this->url->customerLink('marketplace/account/order', '', true)));

            // Header
            $header_params = array(
                'title' => lang('Heading.success', [], $this->language->getCurrentCode()),
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
                'view' => 'Checkout\success',
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
