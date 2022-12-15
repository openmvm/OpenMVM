<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->image = new \App\Libraries\Image();
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_seller_category = new \Main\Marketplace\Models\Seller\Seller_Category_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            $data['display'] = $setting['display'];
            $data['column'] = $setting['column'];

            // Get seller ID
            $uri_strings = explode('/', uri_string());

            $explode = explode('-', end($uri_strings));

            $seller_id = str_replace('s', '', end($explode));

            // Get seller info
            $seller_info = $this->model_seller_seller->getSeller($seller_id);

            $data['seller_categories'] = [];

            $seller_categories = $this->model_seller_seller_category->getSellerCategoriesByParentId(0, $seller_id);
file_put_contents(WRITEPATH . 'temp/openmvm.log', json_encode($seller_categories));
            foreach ($seller_categories as $seller_category) {
                // Get seller category info
                $seller_category_info = $this->model_seller_seller_category->getSellerCategory($seller_category['seller_category_id'], $seller_id);

                if ($seller_category_info) {
                    // Image
                    if (!empty($seller_category_info['image']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_category_info['image'])) {
                        $image = $this->image->resize($seller_category_info['image'], 512, 512, true);
                    } else {
                        $image = $this->image->resize('no_image.png', 512, 512, true);
                    }

                    $data['seller_categories'][] = [
                        'seller_category_id' => $seller_category_info['seller_category_id'],
                        'name' => $seller_category['name'],
                        'image' => $image,
                        'sort_order' => $seller_category['sort_order'],
                        'href' => $this->url->customerLink('marketplace/seller/seller_category/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id'] . '/' . $seller_category['slug'] . '-sc' . $seller_category['seller_category_id']),
                    ];
                }
            }

            $data['widget'] = $widget++;

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Appearance\Marketplace\Widgets\seller_category',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
