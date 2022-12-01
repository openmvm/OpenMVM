<?php

namespace Main\Admin\Controllers\Component\Payment_Method;

class Free_Checkout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \Main\Admin\Models\Localisation\Geo_Zone_Model();
        $this->model_localisation_order_status = new \Main\Admin\Models\Localisation\Order_Status_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/Free_Checkout/save');

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
            'text' => lang('Text.payment_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.free_checkout'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/free_checkout'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.free_checkout');

        $languages = $this->model_localisation_language->getlanguages();

        foreach ($languages as $language) {
            $data['component_payment_method_free_checkout_instruction_' . $language['language_id']] = $this->model_system_setting->getSettingValue('component_payment_method_free_checkout_instruction_' . $language['language_id']);
        }

        $data['component_payment_method_free_checkout_order_status_id'] = $this->model_system_setting->getSettingValue('component_payment_method_free_checkout_order_status_id');

        $data['component_payment_method_free_checkout_sort_order'] = $this->model_system_setting->getSettingValue('component_payment_method_free_checkout_sort_order');

        $data['component_payment_method_free_checkout_status'] = $this->model_system_setting->getSettingValue('component_payment_method_free_checkout_status');

        $data['languages'] = $languages;

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = [
            'title' => lang('Heading.free_checkout'),
        ];
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = [];
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = [];
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Component\Payment_Method\free_checkout',
            'permission' => 'Component/Payment_Method/Free_Checkout',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Payment_Method/Free_Checkout')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('component_payment_method_free_checkout_instruction_' . $language['language_id'], lang('Entry.instructions') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_payment_method_free_checkout', $this->request->getPost());

                $json['success']['toast'] = lang('Success.payment_method_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('component_payment_method_free_checkout_instruction_' . $language['language_id'])) {
                        $json['error']['instruction-' . $language['language_id']] = $this->validation->getError('component_payment_method_free_checkout_instruction_' . $language['language_id']);
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
