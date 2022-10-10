<?php

namespace Main\Marketplace\Controllers\Seller;

class Option extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_localisation_weight_class = new \Main\Marketplace\Models\Localisation\Weight_Class_Model();
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
        $this->model_seller_option = new \Main\Marketplace\Models\Seller\Option_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/seller/option/delete', '', true);

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/option/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/option/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        return $this->get_form($data);
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
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.options', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/option', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.options', [], $this->language->getCurrentCode());

        // Get options
        $data['options'] = [];

        $options = $this->model_seller_option->getOptions($this->customer->getSellerId(), $this->customer->getId());

        foreach ($options as $option) {
            // Get option description
            $option_description_info = $this->model_seller_option->getOptionDescription($option['option_id']);

            $data['options'][] = [
                'option_id' => $option['option_id'],
                'name' => $option_description_info['name'],
                'href' => $this->url->customerLink('marketplace/seller/option/edit/' . $option['option_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/seller/option/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.options', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\option_list',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
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
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.options', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/option', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $option_info = $this->model_seller_option->getOption($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $option_info = [];
        }

        $data['heading_title'] = lang('Heading.options', [], $this->language->getCurrentCode());

        if ($option_info) {
            $data['option_description'] = $this->model_seller_option->getOptionDescriptions($option_info['option_id']);
        } else {
            $data['option_description'] = [];
        }

        if ($option_info) {
            $data['sort_order'] = $option_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($option_info) {
            $data['option_values'] = $this->model_seller_option->getOptionValues($option_info['option_id']);
        } else {
            $data['option_values'] = [];
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['cancel'] = $this->url->customerLink('marketplace/seller/option', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.options', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\option_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_option()
    {
        $json = [];

        if (!empty($this->request->getGet('option_id'))) {
            $option_id = $this->request->getGet('option_id');
        } else {
            $option_id = '';
        }

        $option_info = $this->model_seller_option->getOption($option_id);

        if (!empty($option_info)) {
            // Get option values
            $option_value_data = [];

            $option_values = $this->model_seller_option->getOptionValues($option_info['option_id']);

            foreach ($option_values as $option_value) {
                $option_value_data[] = [
                    'option_value_id' => $option_value['option_value_id'],
                    'name' => $option_value['description'][$this->language->getCurrentId()]['name'],
                ];
            }

            $json = [
                'option_id' => $option_info['option_id'],
                'name' => $option_info['name'],
                'option_values' => $option_value_data,
            ];
        }

        return $this->response->setJSON($json);
    }

    public function autocomplete()
    {
        $json = [];

        if (!empty($this->request->getGet('filter_name'))) {
            $filter_name = $this->request->getGet('filter_name');
        } else {
            $filter_name = '';
        }

        $filter_data = [
            'filter_name' => $filter_name,
        ];

        $options = $this->model_seller_option->getOptions($filter_data);

        if ($options) {
            foreach ($options as $option) {
                $json[] = [
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $option_id) {
                    // Query
                    $query = $this->model_seller_option->deleteOption($option_id);

                    $json['success']['toast'] = $this->session->set('success', lang('Success.option_delete', [], $this->language->getCurrentCode()));
                }

                $json['redirect'] = $this->url->customerLink('marketplace/seller/option', '', true);
            } else {
                $json['error']['toast'] = lang('Error.option_delete', [], $this->language->getCurrentCode());
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('option_description.' . $language['language_id'] . '.name', lang('Entry.name', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_seller_option->editOption($this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.option_edit', [], $this->language->getCurrentCode());
                } else {
                    // Query
                    $query = $this->model_seller_option->addOption($json_data);

                    $json['success']['toast'] = lang('Success.option_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/seller/option', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('option_description.' . $language['language_id'] . '.name')) {
                        $json['error']['description-name-' . $language['language_id']] = $this->validation->getError('option_description.' . $language['language_id'] . '.name');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
