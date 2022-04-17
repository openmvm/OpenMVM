<?php

namespace App\Controllers\Marketplace\Common;

class Widget extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \App\Models\Marketplace\Appearance\Widget_Model();
        $this->model_appearance_layout = new \App\Models\Marketplace\Appearance\Layout_Model();
    }

    public function index($widget_params = array())
    {
        $widgets = [];

        $theme_marketplace = explode(':', $this->setting->get('setting_marketplace_theme'));

        $author = $theme_marketplace[0];
        $theme = $theme_marketplace[1];

        $position = $widget_params['position'];

        if ($position == 'header') {
            $widgets = $this->setting->get('theme_marketplace_' . strtolower($author) . '_' . strtolower($theme) . '_header_widget');
        } elseif ($position == 'content') {
            $widgets = $this->setting->get('theme_marketplace_' . strtolower($author) . '_' . strtolower($theme) . '_content_layout_widget');
        } elseif ($position == 'footer') {
            $widgets = $this->setting->get('theme_marketplace_' . strtolower($author) . '_' . strtolower($theme) . '_footer_column');
        }

        return $widgets;
    }

    public function layout_id()
    {
        $uri_strings = explode('/', ltrim(uri_string(), '/'));

        $num_uri_strings = count($uri_strings);

        for ($i = 0; $i < $num_uri_strings; $i++) {
            if ($i == 0) {
              for ($j = $i; $j < $num_uri_strings; $j++) {
                    $segment = array();
                for ($k = $i; $k <= $j; $k++) {
                  $segment[] = "/" . $uri_strings[$k];
                }
                    $segments[] = $segment;
              }
            }
        }

        foreach ($segments as $segment) {
            $routes[] = implode('', $segment);
        }

        array_reverse($routes);

        $layout_id = 0;

        foreach ($routes as $route) {
            // Get layout route info
            $layout_route_info = $this->model_appearance_layout->getLayoutRouteByRoute($route);

            if ($layout_route_info) {
                $layout_id = $layout_route_info['layout_id'];
                break;
            }
        }

        return $layout_id;
    }

    public function get($widget_id)
    {
        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            if ($widget_info['author'] == 'com_openmvm') {
                $namespace = '\App\Controllers\Marketplace\Appearance\Marketplace\Widgets\\' . $widget_info['widget'];

                $this->widget = new $namespace;

                return $this->widget->index($widget_id);
            } else {
                $namespace = '\Plugins\\' . $widget_info['author'] . '\\' . $widget_info['dir'] . '\Controllers\Marketplace\Appearance\Marketplace\Widgets\\' . $widget_info['widget'];

                $this->widget = new $namespace;

                return $this->widget->index($widget_id);
            }
        } else {
            return false;
        }
    }
}
