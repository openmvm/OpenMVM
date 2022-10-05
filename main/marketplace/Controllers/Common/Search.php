<?php

namespace Main\Marketplace\Controllers\Common;

class Search extends \App\Controllers\BaseController
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

    }

    public function index($search_params = array())
    {
        if (!empty($this->request->getGet('keyword'))) {
            $data['keyword'] = $this->request->getGet('keyword');
        } else {
            $data['keyword'] = '';
        }

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\search', $data);
    }
}
