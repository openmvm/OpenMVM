<?php

namespace App\Controllers\Marketplace\Appearance\Marketplace\Widgets;

class Category extends \App\Controllers\BaseController
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
        $this->model_appearance_widget = new \App\Models\Marketplace\Appearance\Widget_Model();
        $this->model_product_category = new \App\Models\Marketplace\Product\Category_Model();
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

            $categories = $setting['category'];

            foreach ($categories as $category) {
                // Get category info
                $category_info = $this->model_product_category->getCategory($category['category_id']);

                if ($category_info) {
                    // Level 2
                    $children_data = [];

                    $children = $this->model_product_category->getCategories($category_info['category_id']);

                    foreach ($children as $child) {
                        // Image
                        if (!empty($child['image']) && is_file(ROOTPATH . 'public/assets/images/' . $child['image'])) {
                            $image = $this->image->resize($child['image'], 512, 512, true);
                        } else {
                            $image = $this->image->resize('no_image.png', 512, 512, true);
                        }

                        $children_data[] = [
                            'category_id' => $child['category_id'],
                            'name' => $child['name'],
                            'image' => $image,
                            'href' => $this->url->customerLink('marketplace/product/category/get/' . $child['slug'] . '-c' . $child['category_id']),
                        ];
                    }

                    // Image
                    if (!empty($category_info['image']) && is_file(ROOTPATH . 'public/assets/images/' . $category_info['image'])) {
                        $image = $this->image->resize($category_info['image'], 512, 512, true);
                    } else {
                        $image = $this->image->resize('no_image.png', 512, 512, true);
                    }

                    // Get category description
                    $category_description = $this->model_product_category->getCategoryDescription($category_info['category_id']);

                    $data['categories'][] = [
                        'category_id' => $category_info['category_id'],
                        'name' => $category_description['name'],
                        'image' => $image,
                        'display_image' => $category['image'],
                        'column_width' => $category['width'],
                        'sort_order' => $category['sort_order'],
                        'show_sub_categories' => $category['show_sub_categories'],
                        'limit_sub_categories' => $category['limit_sub_categories'],
                        'image_sub_categories' => $category['image_sub_categories'],
                        'children' => $children_data,
                        'href' => $this->url->customerLink('marketplace/product/category/get/' .  $category_description['slug'] . '-c' . $category_info['category_id']),
                    ];
                }
            }

            $data['widget'] = $widget++;

            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Appearance\Marketplace\Widgets\category', $data);
        }
    }
}
