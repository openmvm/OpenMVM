<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class HTML_Content extends \App\Controllers\BaseController
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

            $data['title'] = html_entity_decode($setting['content'][$this->language->getCurrentId()]['title'], ENT_QUOTES, 'UTF-8');
            $data['content'] = html_entity_decode($setting['content'][$this->language->getCurrentId()]['content'], ENT_QUOTES, 'UTF-8');

            $data['widget'] = $widget++;

            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Appearance\Marketplace\Widgets\html_content', $data);
        }
    }
}
