<?php

namespace Main\Marketplace\Controllers\Seller;

class Register extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index()
    {
        if ($this->customer->isSeller()) {
            return redirect()->to($this->url->customerLink('marketplace/seller/dashboard', '', true));
        }

        $data['action'] = $this->url->customerLink('marketplace/seller/register/go', '', true);

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.register', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/register'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.register', [], $this->language->getCurrentCode());

        $data['store_name'] = '';

        $data['store_description'] = '';

        $data['logo'] = '';

        $data['logo_thumb'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['cover'] = '';

        $data['cover_thumb'] = $this->image->resize('no_image.png', 100, 100, true);

        // Header
        $header_params = array(
            'title' => lang('Heading.register', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\register',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function go()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('store_name', lang('Entry.store_name', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('store_description', lang('Entry.store_description', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_seller_seller->addSeller($json_data);

                $json['success']['toast'] = lang('Success.seller_add', [], $this->language->getCurrentCode());

                $json['redirect'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                if ($this->validation->hasError('store_name')) {
                    $json['error']['store-name'] = $this->validation->getError('store_name');
                }

                if ($this->validation->hasError('store_description')) {
                    $json['error']['store-description'] = $this->validation->getError('store_description');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
