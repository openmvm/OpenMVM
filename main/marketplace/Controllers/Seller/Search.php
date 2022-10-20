<?php

namespace Main\Marketplace\Controllers\Seller;

class Search extends \App\Controllers\BaseController
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
        if (!empty($this->request->getGet('keyword'))) {
            $keyword = $this->request->getGet('keyword');
        } else {
            $keyword = '';
        }

        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/seller', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.search', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/search', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.search', [], $this->language->getCurrentCode());

        // Get sellers
        $data['sellers'] = [];

        $filter_data = [
            'filter_name' => $keyword,
        ];

        $sellers = $this->model_seller_seller->getSellers($filter_data);

        foreach ($sellers as $seller) {
            // Image
            if (is_file(ROOTPATH . 'public/assets/images/' . $seller['logo'])) {
                $thumb = $this->image->resize($seller['logo'], 72, 72, true);
            } else {
                $thumb = $this->image->resize('no_image.png', 72, 72, true);
            }

            $data['sellers'][] = [
                'seller_id' => $seller['seller_id'],
                'store_name' => $seller['store_name'],
                'thumb' => $thumb,
                'href' => $this->url->customerLink('marketplace/seller/seller/get/' . $seller['slug'] . '-s' . $seller['seller_id']),
            ];
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.search', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\search',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
