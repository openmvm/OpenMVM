<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Link extends \App\Controllers\BaseController
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

            $data['links'] = [];

            foreach ($setting['link'] as $link) {
                $data['links'][] = [
                    'text' => $link[$this->language->getCurrentId()]['text'],
                    'url' => $link[$this->language->getCurrentId()]['url'],
                    'target' => $link[$this->language->getCurrentId()]['target'],
                ];
            }

            $data['widget'] = $widget++;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Appearance\Marketplace\Widgets\link',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
