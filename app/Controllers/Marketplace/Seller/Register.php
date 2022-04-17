<?php

namespace App\Controllers\Marketplace\Seller;

class Register extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_seller_seller = new \App\Models\Marketplace\Seller\Seller_Model();
    }

    public function index()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        if ($this->customer->isSeller()) {
            return redirect()->to($this->url->customerLink('marketplace/seller/dashboard', '', true));
        }

        $data['action'] = $this->url->customerLink('marketplace/seller/register', '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('store_name', lang('Entry.store_name'), 'required');
            $this->validation->setRule('store_description', lang('Entry.store_description'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_seller->addSeller($this->request->getPost());

                $this->session->set('success', lang('Success.seller_add'));

                return redirect()->to($this->url->customerLink('marketplace/seller/dashboard', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('store_name')) {
                    $data['error_store_name'] = $this->validation->getError('store_name');
                } else {
                    $data['error_store_name'] = '';
                }

                if ($this->validation->hasError('store_description')) {
                    $data['error_store_description'] = $this->validation->getError('store_description');
                } else {
                    $data['error_store_description'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.register'),
            'href' => $this->url->customerLink('marketplace/seller/register'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.register');

        if ($this->request->getPost('store_name')) {
            $data['store_name'] = $this->request->getPost('store_name');
        } else {
            $data['store_name'] = '';
        }

        if ($this->request->getPost('store_description')) {
            $data['store_description'] = $this->request->getPost('store_description');
        } else {
            $data['store_description'] = '';
        }

        if ($this->request->getPost('logo')) {
            $data['logo'] = $this->request->getPost('logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->request->getPost('logo')) {
            $data['logo_thumb'] = $this->image->resize($this->request->getPost('logo'), 100, 100, true);
        } else {
            $data['logo_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($this->request->getPost('cover')) {
            $data['cover'] = $this->request->getPost('cover');
        } else {
            $data['cover'] = '';
        }

        if ($this->request->getPost('cover')) {
            $data['cover_thumb'] = $this->image->resize($this->request->getPost('cover'), 100, 100, true);
        } else {
            $data['cover_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        // Header
        $header_params = array(
            'title' => lang('Heading.register'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\register', $data);
    }
}
