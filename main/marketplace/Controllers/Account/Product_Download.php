<?php

namespace Main\Marketplace\Controllers\Account;

class Product_Download extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_account_product_download = new \Main\Marketplace\Models\Account\Product_Download_Model();
    }

    public function index()
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
            'text' => lang('Text.my_downloads', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/product_download', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_downloads', [], $this->language->getCurrentCode());

        // Get product_downloads
        $data['product_downloads'] = [];

        $product_downloads = $this->model_account_product_download->getProductDownloads($this->customer->getId());

        foreach ($product_downloads as $product_download) {
            $data['product_downloads'][] = [
                'product_download_id' => $product_download['product_download_id'],
                'name' => $product_download['name'],
                'filename' => $product_download['filename'],
                'mask' => $product_download['mask'],
                'order_id' => $product_download['order_id'],
                'product_id' => $product_download['product_id'],
                'product_name' => $product_download['product_name'],
                'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_download['date_added'])),
                'download' => $this->url->customerLink('marketplace/account/product_download/get/' . $product_download['product_download_id'], '', true),
            ];
        }

        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.my_downloads', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\product_download',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get($product_download_id)
    {
        // Get product download info
        $product_download_info = $this->model_account_product_download->getProductDownload($product_download_id);

        if ($product_download_info) {
            $file_path = WRITEPATH . 'uploads/customer/' . $product_download_info['customer_id'] . '/' . $product_download_info['mask'];

            if (file_exists($file_path)) {
                $file_content = file_get_contents($file_path);
                     
                // Download it!
                return $this->response->download($product_download_info['filename'], $file_content);
            }
        }
    }
}
