<?php

namespace Main\Marketplace\Controllers\Common;

class Language extends \App\Controllers\BaseController
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
        $this->language = new \App\Libraries\Language();
        $this->url = new \App\Libraries\Url();
       // Model
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
    }

    public function index($search_params = array())
    {
        // Languages
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['current_language_code'] = $this->language->getCurrentCode();

        $data['set_language'] = $this->url->customerLink('marketplace/common/language/set_language');

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\language', $data);
    }

    public function set_language()
    {
        $json = [];

        // Set current language
        if (!empty($this->request->getGet('code'))) {
            $this->session->set('marketplace_language_id', $this->language->getId($this->request->getGet('code')));
        }

        return $this->response->setJSON($json);
    }
}
