<?php

namespace Main\Marketplace\Controllers\Page;

class Page extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_page_page = new \Main\Marketplace\Models\Page\Page_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.pages', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/page/page'),
            'active' => false,
        );

        $data['heading_title'] = lang('Heading.pages', [], $this->language->getCurrentCode());

        // Header
        $header_params = array(
            'title' => lang('Heading.pages', [], $this->language->getCurrentCode()),
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
            'view' => 'Page\page',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get($page)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.pages', [], $this->language->getCurrentCode()),
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
    
            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Page\page_info',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
    
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
