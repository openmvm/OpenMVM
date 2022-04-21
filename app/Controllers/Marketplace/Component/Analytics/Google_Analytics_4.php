<?php

namespace App\Controllers\Marketplace\Component\Analytics;

class Google_Analytics_4 extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->setting = new \App\Libraries\Setting();
    }

    public function index()
    {
        if ($this->setting->get('component_analytics_google_analytics_4_status')) {
            return html_entity_decode($this->setting->get('component_analytics_google_analytics_4_global_site_tag'), ENT_QUOTES, 'UTF-8');
        } else {
            return;
        }
    }
}