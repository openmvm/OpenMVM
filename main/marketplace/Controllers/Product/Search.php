<?php

namespace Main\Marketplace\Controllers\Product;

class Search extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_product_category = new \Main\Marketplace\Models\Product\Category_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
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
            'text' => lang('Text.search', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/product/search'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.search', [], $this->language->getCurrentCode());

        // Get products
        $data['products'] = [];

        $filter_data = [
            'filter_name' => $keyword,
        ];

        $products = $this->model_product_product->getProducts($filter_data);

        foreach ($products as $product) {
            // Image
            if (is_file(ROOTPATH . 'public/assets/images/' . $product['main_image'])) {
                $thumb = $this->image->resize($product['main_image'], 512, 512, true);
            } else {
                $thumb = $this->image->resize('no_image.png', 512, 512, true);
            }

            $data['products'][] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'thumb' => $thumb,
                'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
            ];
        }

        // Header
        $header_params = array(
            'title' => lang('Heading.search', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Product\search', $data);
    }
}
