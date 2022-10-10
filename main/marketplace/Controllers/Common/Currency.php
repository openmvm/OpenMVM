<?php

namespace Main\Marketplace\Controllers\Common;

class Currency extends \App\Controllers\BaseController
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
        $this->currency = new \App\Libraries\Currency();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_localisation_currency = new \Main\Marketplace\Models\Localisation\Currency_Model();
    }

    public function index($search_params = array())
    {
        // Currencies
        $data['currencies'] = $this->model_localisation_currency->getCurrencies();

        $data['current_currency_code'] = $this->currency->getCurrentCode();

        $data['set_currency'] = $this->url->customerLink('marketplace/common/currency/set_currency');

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\currency',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function set_currency()
    {
        $json = [];

        // Set current currency
        if (!empty($this->request->getGet('code'))) {
            $this->session->set('marketplace_currency_id', $this->currency->getId($this->request->getGet('code')));
        }

        return $this->response->setJSON($json);
    }
}
