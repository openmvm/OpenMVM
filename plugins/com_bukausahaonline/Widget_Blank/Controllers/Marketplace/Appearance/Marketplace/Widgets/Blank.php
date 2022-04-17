<?php

namespace Plugins\com_bukausahaonline\Widget_Blank\Controllers\Marketplace\Appearance\Marketplace\Widgets;

class Blank extends \App\Controllers\BaseController
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
        $this->model_appearance_widget = new \App\Models\Marketplace\Appearance\Widget_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            $data['height'] = $setting['height'];
            $data['background_color'] = $setting['background_color'];

            $data['widget'] = $widget++;

            return $this->template->render('Plugins', 'com_bukausahaonline', 'Widget_Blank', 'Marketplace\Appearance\Marketplace\Widgets\blank', $data);
        }
    }
}
