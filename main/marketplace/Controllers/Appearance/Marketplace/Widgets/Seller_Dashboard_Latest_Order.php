<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Dashboard_Latest_Order extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->currency = new \App\Libraries\Currency();
        $this->customer = new \App\Libraries\Customer();
        $this->image = new \App\Libraries\Image();
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_localisation_order_status = new \Main\Marketplace\Models\Localisation\Order_Status_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_order = new \Main\Marketplace\Models\Seller\Order_Model();
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            // Get seller info
            $seller_info = $this->model_seller_seller->getSeller($this->customer->getSellerId());

            if ($seller_info) {
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
                            'price' => $this->currency->format($order_product['price'], $order['currency_code'], $order['currency_value']),
                            'total' => $this->currency->format($order_product['total'], $order['currency_code'], $order['currency_value']),
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

                    // Total order product quantity
                    $total_order_product_quantity = $this->model_seller_order->getTotalOrderProductQuantity($order['order_id'], $this->customer->getSellerId());

                    // Total order products
                    $total_order_products = $this->model_seller_order->getTotalOrderProducts($order['order_id'], $this->customer->getSellerId());

                    $data['orders'][] = [
                        'order_id' => $order['order_id'],
                        'invoice' => $order['invoice'],
                        'customer_id' => $order['customer_id'],
                        'customer_group_id' => $order['customer_group_id'],
                        'firstname' => $order['firstname'],
                        'lastname' => $order['lastname'],
                        'product' => $order_product_data,
                        'total' => $this->currency->format($total, $order['currency_code'], $order['currency_value']),
                        'total_quantity' => $total_order_product_quantity,
                        'total_products' => $total_order_products,
                        'order_status' => $order_status_data,
                        'date_added' => date(lang('Common.date_format_local', [], $this->language->getCurrentCode()), strtotime($order['date_added'])),
                        'info' => $this->url->customerLink('marketplace/seller/order/info/' . $order['order_id'], '', true),
                    ];
                }

                $data['language_lib'] = $this->language;

                $data['widget'] = $widget++;
                
                // Generate view
                $template_setting = [
                    'location' => 'ThemeMarketplace',
                    'author' => 'com_openmvm',
                    'theme' => 'Basic',
                    'view' => 'Appearance\Marketplace\Widgets\seller_dashboard_latest_order',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            }
        }
    }
}
