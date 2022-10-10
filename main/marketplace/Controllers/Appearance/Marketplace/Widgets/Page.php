<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Page extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_page_page = new \Main\Marketplace\Models\Page\Page_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            $data['title'] = $setting['title'][$this->language->getCurrentId()]['title'];

            $data['pages'] = [];

            foreach ($setting['page'] as $page) {
                // Get page info
                $page_info = $this->model_page_page->getPage($page['page_id']);

                if ($page_info) {
                    // Get page description
                    $page_description = $this->model_page_page->getPageDescription($page_info['page_id']);

                    $data['pages'][] = [
                        'page_id' => $page_info['page_id'],
                        'title' => $page_description['title'],
                        'target' => $page['target'],
                        'href' => $this->url->customerLink('marketplace/page/page/get/' . $page_description['slug'] . '-pg' . $page_info['page_id']),
                    ];
                }
            }

            $data['widget'] = $widget++;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Appearance\Marketplace\Widgets\page',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
