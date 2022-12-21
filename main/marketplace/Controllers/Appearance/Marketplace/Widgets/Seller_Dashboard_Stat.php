<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Dashboard_Stat extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->currency = new \App\Libraries\Currency();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_order = new \Main\Marketplace\Models\Seller\Order_Model();
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
                // Revenue
                $total_revenue = $this->model_seller_order->getTotalRevenue($this->customer->getSellerId());

                $data['total_revenue'] = $this->currency->format($total_revenue, $this->currency->getCurrentCode());

                // Wallet balance
                $wallet_balance = $this->customer->getWalletBalance();

                $data['wallet_balance'] = $this->currency->format($wallet_balance, $this->currency->getCurrentCode());

                $data['url_account_wallet'] = $this->url->customerLink('marketplace/account/wallet', '', true);
                $data['url_seller_order'] = $this->url->customerLink('marketplace/seller/order', '', true);

                // Orders
                $total_orders = $this->model_seller_order->getTotalOrders($this->customer->getSellerId());

                $data['total_orders'] = $total_orders;

                // Sold quantity
                $total_sold_quantity = $this->model_seller_order->getTotalSoldQuantity($this->customer->getSellerId());

                $data['total_sold_quantity'] = $total_sold_quantity;

                $data['language_lib'] = $this->language;

                $data['widget'] = $widget++;
                
                // Generate view
                $template_setting = [
                    'location' => 'ThemeMarketplace',
                    'author' => 'com_openmvm',
                    'theme' => 'Basic',
                    'view' => 'Appearance\Marketplace\Widgets\seller_dashboard_stat',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            }
        }
    }
}
