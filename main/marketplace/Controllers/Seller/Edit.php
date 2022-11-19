<?php

namespace Main\Marketplace\Controllers\Seller;

class Edit extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->customerLink('marketplace/seller/edit/save', '', true);

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
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller_edit', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/edit', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.seller_edit', [], $this->language->getCurrentCode());
            
        $seller_info = $this->model_seller_seller->getSeller($this->customer->getSellerId(), $this->customer->getId());

        if ($seller_info) {
            $data['store_name'] = $seller_info['store_name'];
        } else {
            $data['store_name'] = '';
        }

        if ($seller_info) {
            $data['store_description'] = $seller_info['store_description'];
        } else {
            $data['store_description'] = '';
        }

        if (!empty($seller_info['logo']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_info['logo'])) {
            $data['logo'] = $seller_info['logo'];
        } else {
            $data['logo'] = '';
        }

        if (!empty($seller_info['logo']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_info['logo'])) {
            $data['logo_thumb'] = $this->image->resize($seller_info['logo'], 100, 100, true);
        } else {
            $data['logo_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if (!empty($seller_info['cover']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_info['cover'])) {
            $data['cover'] = $seller_info['cover'];
        } else {
            $data['cover'] = '';
        }

        if (!empty($seller_info['cover']) && is_file(ROOTPATH . 'public/assets/images/' . $seller_info['cover'])) {
            $data['cover_thumb'] = $this->image->resize($seller_info['cover'], 100, 100, true);
        } else {
            $data['cover_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($seller_info) {
            $data['timezone'] = $seller_info['timezone'];
        } else {
            $data['timezone'] = '';
        }

        $data['timezones'] = $this->timezone->getList();

        $data['upload'] = $this->url->customerLink('marketplace/tool/upload', [], true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.seller_edit', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\edit',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('store_name', lang('Entry.store_name', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('store_description', lang('Entry.store_description', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_seller_seller->editSeller($this->customer->getSellerId(), $this->customer->getId(), $json_data);

                $json['success']['toast'] = lang('Success.seller_edit', [], $this->language->getCurrentCode());

                $json['redirect'] = $this->url->customerLink('marketplace/seller/edit', '', true);
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
