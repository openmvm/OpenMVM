<?php

namespace Main\Marketplace\Controllers\Seller;

class Seller_Faq extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_localisation_language = new \Main\Marketplace\Models\Localisation\Language_Model();
        $this->model_seller_seller_faq = new \Main\Marketplace\Models\Seller\Seller_Faq_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/seller/seller_faq/delete', '', true);

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/seller_faq/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/seller_faq/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

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
            'text' => lang('Text.seller_faqs', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller_faq', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.seller_faqs', [], $this->language->getCurrentCode());

        // Get seller faqs
        $data['seller_faqs'] = [];

        $seller_faqs = $this->model_seller_seller_faq->getSellerFaqs([], $this->customer->getSellerId(), $this->customer->getId());

        foreach ($seller_faqs as $seller_faq) {
            $data['seller_faqs'][] = [
                'seller_faq_id' => $seller_faq['seller_faq_id'],
                'question' => $seller_faq['question'],
                'sort_order' => $seller_faq['sort_order'],
                'status' => $seller_faq['status'] ? lang('Text.enabled', [], $this->language->getCurrentCode()) : lang('Text.disabled', [], $this->language->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/seller/seller_faq/edit/' . $seller_faq['seller_faq_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/seller/seller_faq/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.seller_faqs', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\seller_faq_list',
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
            'text' => lang('Text.seller_faqs', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller_faq', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $seller_faq_info = $this->model_seller_seller_faq->getSellerFaq($this->uri->getSegment($this->uri->getTotalSegments()), $this->customer->getSellerId(), $this->customer->getId());
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $seller_faq_info = [];
        }

        $data['heading_title'] = lang('Heading.seller_faqs', [], $this->language->getCurrentCode());


        if ($seller_faq_info) {
            $data['seller_faq_description'] = $this->model_seller_seller_faq->getSellerFaqDescriptions($seller_faq_info['seller_faq_id'], $this->customer->getSellerId(), $this->customer->getId());
        } else {
            $data['seller_faq_description'] = [];
        }

        if ($seller_faq_info) {
            $data['sort_order'] = $seller_faq_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($seller_faq_info) {
            $data['status'] = $seller_faq_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($seller_faq_info) {
            $seller_faq_id = $seller_faq_info['seller_faq_id'];
        } else {
            $seller_faq_id = 0;
        }

        $data['seller_faq_id'] = $seller_faq_id;

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['cancel'] = $this->url->customerLink('marketplace/seller/seller_faq', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
        ];
        $styles = [];
        $header_params = array(
            'title' => lang('Heading.seller_faqs', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
            'scripts' => $scripts,
            'styles' => $styles,
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
            'view' => 'Seller\seller_faq_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $seller_faq_id) {
                    // Query
                    $query = $this->model_seller_seller_faq->deleteSellerFaq($seller_faq_id);

                    $json['success']['toast'] = lang('Success.seller_faq_delete', [], $this->language->getCurrentCode());

                    $json['redirect'] = $this->url->customerLink('marketplace/seller/seller_faq', '', true);
                }
            } else {
                $json['error']['toast'] = lang('Error.seller_faq_delete');
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
                $this->validation->setRule('seller_faq_description.' . $language['language_id'] . '.question', lang('Entry.question', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
                $this->validation->setRule('seller_faq_description.' . $language['language_id'] . '.answer', lang('Entry.answer', [], $this->language->getCurrentCode()) . ' ' . lang('Text.in', [], $this->language->getCurrentCode()) . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_seller_seller_faq->editSellerFaq($this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.seller_faq_edit', [], $this->language->getCurrentCode());
                } else {
                    // Query
                    $query = $this->model_seller_seller_faq->addSellerFaq($json_data);

                    $json['success']['toast'] = lang('Success.seller_faq_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/seller/seller_faq', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('seller_faq_description.' . $language['language_id'] . '.question')) {
                        $json['error']['question-' . $language['language_id']] = $this->validation->getError('seller_faq_description.' . $language['language_id'] . '.name');
                    }

                    if ($this->validation->hasError('seller_faq_description.' . $language['language_id'] . '.answer')) {
                        $json['error']['answer-' . $language['language_id']] = $this->validation->getError('seller_faq_description.' . $language['language_id'] . '.answer');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function get($seller, $seller_faq)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get seller ID
        $explode = explode('-', $seller);

        $seller_id = str_replace('s', '', end($explode));

        // Get seller info
        $seller_info = $this->model_seller_seller->getSeller($seller_id);

        if ($seller_info) {
            // Get seller faq ID
            $explode = explode('-', $seller_faq);

            $seller_faq_id = str_replace('sc', '', end($explode));

            // Get seller faq info
            $seller_faq_info = $this->model_seller_seller_faq->getSellerFaq($seller_faq_id, $seller_id);

            if ($seller_faq_info) {
                // Get seller faq description
                $seller_faq_description = $this->model_seller_seller_faq->getSellerFaqDescription($seller_faq_id, $seller_id);

                if ($seller_faq_description) {
                    $breadcrumbs[] = array(
                        'question' => $seller_faq_description['question'],
                        'href' => $this->url->customerLink('marketplace/seller/seller_faq/get/' . $seller_faq_description['slug'] . '-sf' . $seller_faq_info['seller_faq_id']),
                        'active' => true,
                    );
                }

                $data['heading_title'] = $seller_info['store_name'];
                $data['lead'] = $seller_faq_description['question'];

                // Libraries
                $data['language_lib'] = $this->language;

                // Widget
                $data['marketplace_common_widget'] = $this->marketplace_common_widget;
                // Header
                $header_params = array(
                    'title' => lang('Heading.seller_faqs', [], $this->language->getCurrentCode()),
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
                    'view' => 'Seller\seller_faq_info',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            } else {
                $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
            
                // Libraries
                $data['language_lib'] = $this->language;

                // Header
                $header_params = array(
                    'title' => lang('Heading.not_found', [], $this->language->getCurrentCode()),
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
                    'view' => 'Common\error',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            }
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
        
            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $header_params = array(
                'title' => lang('Heading.not_found', [], $this->language->getCurrentCode()),
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
                'view' => 'Common\error',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
	