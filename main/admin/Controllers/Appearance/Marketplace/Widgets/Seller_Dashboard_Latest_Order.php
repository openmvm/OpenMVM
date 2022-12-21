<?php

namespace Main\Admin\Controllers\Appearance\Marketplace\Widgets;

class Seller_Dashboard_Latest_Order extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \Main\Admin\Models\Appearance\Widget_Model();
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
    }

    public function index()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/Seller_Dashboard_Latest_Order/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.marketplace_widgets'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.seller_dashboard_latest_order'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widgets/seller_dashboard_latest_order'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.seller_dashboard_latest_order');
            
        $widget_info = $this->model_appearance_widget->getWidget($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($widget_info) {
            $data['name'] = $widget_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($widget_info) {
            $data['status'] = $widget_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');

        // Header
        $header_params = array(
            'title' => lang('Heading.seller_dashboard_latest_order'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Appearance\Marketplace\Widgets\seller_dashboard_latest_order',
            'permission' => 'Appearance/Marketplace/Widgets/Seller_Dashboard_Latest_Order',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widgets/Seller_Dashboard_Latest_Order')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_appearance_widget->editWidget('marketplace', 'com_openmvm', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost(), '');

                $json['success']['toast'] = lang('Success.widget_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('name')) {
                    $json['error']['name'] = $this->validation->getError('name');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
