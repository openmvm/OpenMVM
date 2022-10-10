<?php

namespace Main\Marketplace\Controllers\Seller\Component;

class Shipping_Method extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_component_component = new \Main\Marketplace\Models\Component\Component_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_dashboard', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.shipping_methods', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/component/shipping_method'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.shipping_methods', [], $this->language->getCurrentCode());

        // Get shipping methods
        $data['shipping_methods'] = [];

        $directory = ROOTPATH . '/Main/Marketplace/Models/Component/Shipping_Method/';

        $shipping_methods = array_diff(scandir($directory), array('..', '.'));

        foreach ($shipping_methods as $shipping_method) {
            // Path info
            $pathinfo = pathinfo($shipping_method);

            $filename = str_replace('_Model', '', $pathinfo['filename']);
            
            $name = lang('Text.' . strtolower($filename), [], $this->language->getCurrentCode());

            // Check if installed
            $component_info = $this->model_component_component->getInstalledComponent('shipping_method', 'com_openmvm', $filename);

            if ($component_info) {
                $data['shipping_methods'][] = [
                    'name' => $name,
                    'author' => 'com_openmvm',
                    'edit' => $this->url->customerLink('marketplace/seller/shipping_method/' . strtolower($filename), [], true),
                ];
            }

        }
        
		// Sort the file array
		sort($data['shipping_methods']);

        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.shipping_methods', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\Component\shipping_method',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
