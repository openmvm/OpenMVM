<?php

namespace App\Controllers\Marketplace\Page;

class Page extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_page_page = new \App\Models\Marketplace\Page\Page_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.pages'),
            'href' => $this->url->customerLink('marketplace/page/page'),
            'active' => false,
        );

        $data['heading_title'] = lang('Heading.pages');

        // Header
        $header_params = array(
            'title' => lang('Heading.pages'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Page\page', $data);
    }

    public function get($page)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.pages'),
            'href' => $this->url->customerLink('marketplace/page/page'),
            'active' => false,
        );

        // Get page ID
        $explode = explode('-', $page);

        $page_id = str_replace('pg', '', end($explode));

        // Get page info
        $page_info = $this->model_page_page->getPage($page_id);

        if ($page_info) {
            // Get page description
            $page_description = $this->model_page_page->getPageDescription($page_info['page_id']);

            $breadcrumbs[] = array(
                'text' => $page_description['title'],
                'href' => $this->url->customerLink('marketplace/page/page/get/' . $page_description['slug'] . '-pg' . $page_info['page_id']),
                'active' => true,
            );
    
            $data['heading_title'] = $page_description['title'];
            $data['description'] = html_entity_decode($page_description['description'], ENT_QUOTES, 'UTF-8');

            // Header
            $header_params = array(
                'title' => $page_description['title'],
                'breadcrumbs' => $breadcrumbs,
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Page\page_info', $data);    
        } else {
            $data['message'] = lang('Error.no_data_found');
    
            // Header
            $header_params = array(
                'title' => lang('Heading.not_found'),
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\error', $data);    
        }
    }
}
