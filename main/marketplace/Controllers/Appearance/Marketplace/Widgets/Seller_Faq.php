<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Faq extends \App\Controllers\BaseController
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
        $this->model_seller_seller_faq = new \Main\Marketplace\Models\Seller\Seller_Faq_Model();
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
                // Get faqs
                $data['seller_faqs'] = [];

                $seller_faqs = $this->model_seller_seller_faq->getSellerFaqs([], $this->customer->getSellerId());

                foreach ($seller_faqs as $seller_faq) {
                    $data['seller_faqs'][] = [
                        'seller_faq_id' => $seller_faq['seller_faq_id'],
                        'question' => $seller_faq['question'],
                        'answer' => $seller_faq['answer'],
                    ];
                }

                $data['language_lib'] = $this->language;

                $data['widget'] = $widget++;
                
                // Generate view
                $template_setting = [
                    'location' => 'ThemeMarketplace',
                    'author' => 'com_openmvm',
                    'theme' => 'Basic',
                    'view' => 'Appearance\Marketplace\Widgets\seller_faq',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            }
        }
    }
}
