<?php

namespace Main\Admin\Controllers\System;

class Setting extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_country = new \Main\Admin\Models\Localisation\Country_Model();
        $this->model_localisation_currency = new \Main\Admin\Models\Localisation\Currency_Model();
        $this->model_localisation_order_status = new \Main\Admin\Models\Localisation\Order_Status_Model();
        $this->model_localisation_weight_class = new \Main\Admin\Models\Localisation\Weight_Class_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
        $this->model_administrator_administrator_group = new \Main\Admin\Models\Administrator\Administrator_Group_Model();
        $this->model_customer_customer_group = new \Main\Admin\Models\Customer\Customer_Group_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/setting/save');

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
            'text' => lang('Text.settings'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/system/setting'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.settings');

        // General
        $data['setting_marketplace_name'] = $this->model_system_setting->getSettingValue('setting_marketplace_name');

        $languages = $this->model_localisation_language->getlanguages();

        foreach ($languages as $language) {
            $data['setting_marketplace_description_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_description_' . $language['language_id']);

            $data['setting_marketplace_meta_title_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_title_' . $language['language_id']);

            $data['setting_marketplace_meta_description_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_description_' . $language['language_id']);

            $data['setting_marketplace_meta_keywords_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_keywords_' . $language['language_id']);
        }

        // Data
        $data['setting_logo'] = $this->model_system_setting->getSettingValue('setting_logo');

        if (!empty($this->model_system_setting->getSettingValue('setting_logo')) && is_file(ROOTPATH . 'public/assets/images/' . $this->model_system_setting->getSettingValue('setting_logo'))) {
            $data['logo_thumb'] = $this->image->resize($this->model_system_setting->getSettingValue('setting_logo'), 100, 100, true);
        } else {
            $data['logo_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        $data['setting_favicon'] = $this->model_system_setting->getSettingValue('setting_favicon');

        if (!empty($this->model_system_setting->getSettingValue('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->model_system_setting->getSettingValue('setting_favicon'))) {
            $data['favicon_thumb'] = $this->image->resize($this->model_system_setting->getSettingValue('setting_favicon'), 100, 100, true);
        } else {
            $data['favicon_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        $data['setting_copyright_name'] = $this->model_system_setting->getSettingValue('setting_copyright_name');

        $data['setting_copyright_year'] = $this->model_system_setting->getSettingValue('setting_copyright_year');

        $data['setting_address_1'] = $this->model_system_setting->getSettingValue('setting_address_1');

        $data['setting_address_2'] = $this->model_system_setting->getSettingValue('setting_address_2');

        $data['setting_city'] = $this->model_system_setting->getSettingValue('setting_city');

        $data['countries'] = $this->model_localisation_country->getCountries();

        $data['setting_country_id'] = $this->model_system_setting->getSettingValue('setting_country_id');

        $data['setting_zone_id'] = $this->model_system_setting->getSettingValue('setting_zone_id');

        $data['setting_telephone'] = $this->model_system_setting->getSettingValue('setting_telephone');

        $data['setting_email'] = $this->model_system_setting->getSettingValue('setting_email');

        // Options
        $data['administrator_groups'] = $this->model_administrator_administrator_group->getAdministratorGroups();

        $data['setting_administrator_group_id'] = $this->model_system_setting->getSettingValue('setting_administrator_group_id');

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $data['setting_customer_group_id'] = $this->model_system_setting->getSettingValue('setting_customer_group_id');

        $data['setting_order_invoice_prefix'] = $this->model_system_setting->getSettingValue('setting_order_invoice_prefix');

        // Localisation
        $data['setting_admin_language_id'] = $this->model_system_setting->getSettingValue('setting_admin_language_id');

        $data['setting_marketplace_language_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_language_id');

        $data['setting_admin_currency_id'] = $this->model_system_setting->getSettingValue('setting_admin_currency_id');

        $data['setting_marketplace_currency_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_currency_id');

        $data['setting_admin_weight_class_id'] = $this->model_system_setting->getSettingValue('setting_admin_weight_class_id');

        $data['setting_marketplace_weight_class_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_weight_class_id');

        // Appearance
        // Get admin themes
        $admin_theme_path = ROOTPATH . '/theme_admin/*/*/Controllers/Admin/Appearance/Admin/Theme/*/*';

        $admin_themes = array_diff(glob($admin_theme_path), array('.', '..'));

        foreach ($admin_themes as $admin_theme) {
            $admin_theme_segment = explode('/', $admin_theme);
            $total_segments = count($admin_theme_segment);

            $admin_theme_author = str_replace('_', ' ', $admin_theme_segment[$total_segments - 2]);
            $admin_theme_name = str_replace('_', ' ', pathinfo($admin_theme_segment[$total_segments - 1], PATHINFO_FILENAME));

            $data['admin_themes'][] = [
                'path' => $admin_theme,
                'theme_author' => $admin_theme_author,
                'theme_name' => $admin_theme_name,
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/admin/theme/' . strtolower($admin_theme_author) . '/' . strtolower($admin_theme_name)),
            ];
        }

        $data['setting_admin_theme'] = $this->model_system_setting->getSettingValue('setting_admin_theme');

        // Get marketplace themes
        $marketplace_theme_path = ROOTPATH . '/theme_marketplace/*/*/Controllers/Admin/Appearance/Marketplace/Theme/*/*';

        $marketplace_themes = array_diff(glob($marketplace_theme_path), array('.', '..'));

        foreach ($marketplace_themes as $marketplace_theme) {
            $marketplace_theme_segment = explode('/', $marketplace_theme);
            $total_segments = count($marketplace_theme_segment);

            $marketplace_theme_author = str_replace('_', ' ', $marketplace_theme_segment[$total_segments - 2]);
            $marketplace_theme_name = str_replace('_', ' ', pathinfo($marketplace_theme_segment[$total_segments - 1], PATHINFO_FILENAME));

            $data['marketplace_themes'][] = [
                'path' => $marketplace_theme,
                'theme_author' => $marketplace_theme_author,
                'theme_name' => $marketplace_theme_name,
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/' . strtolower($marketplace_theme_author) . '/' . strtolower($marketplace_theme_name)),
            ];
        }

        $data['setting_marketplace_theme'] = $this->model_system_setting->getSettingValue('setting_marketplace_theme');

        // Order statuses
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        // Seller
        $data['setting_processing_order_statuses'] = $this->model_system_setting->getSettingValue('setting_processing_order_statuses');

        $data['setting_completed_order_statuses'] = $this->model_system_setting->getSettingValue('setting_completed_order_statuses');

        $data['setting_non_rejectable_order_statuses'] = $this->model_system_setting->getSettingValue('setting_non_rejectable_order_statuses');

        $data['setting_rejected_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_rejected_order_status_id'));

        $data['setting_rejected_order_status_id'] = $this->model_system_setting->getSettingValue('setting_rejected_order_status_id');

        $data['setting_non_acceptable_order_statuses'] = $this->model_system_setting->getSettingValue('setting_non_acceptable_order_statuses');

        $data['setting_accepted_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_accepted_order_status_id'));

        $data['setting_accepted_order_status_id'] = $this->model_system_setting->getSettingValue('setting_accepted_order_status_id');

        $data['setting_shipped_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_shipped_order_status_id'));

        $data['setting_shipped_order_status_id'] = $this->model_system_setting->getSettingValue('setting_shipped_order_status_id');

        $data['setting_delivered_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_delivered_order_status_id'));

        $data['setting_delivered_order_status_id'] = $this->model_system_setting->getSettingValue('setting_delivered_order_status_id');

        // Customer
        $data['setting_non_cancelable_order_statuses'] = $this->model_system_setting->getSettingValue('setting_non_cancelable_order_statuses');

        $data['setting_canceled_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_canceled_order_status_id'));

        $data['setting_canceled_order_status_id'] = $this->model_system_setting->getSettingValue('setting_canceled_order_status_id');

        $data['setting_completed_order_status'] = $this->model_localisation_order_status->getOrderStatusDescription($this->model_system_setting->getSettingValue('setting_completed_order_status_id'));

        $data['setting_completed_order_status_id'] = $this->model_system_setting->getSettingValue('setting_completed_order_status_id');

        // Mail
        $data['mail_protocols'] = ['smtp'];

        $data['setting_mail_protocol'] = $this->model_system_setting->getSettingValue('setting_mail_protocol');

        $data['smtp_encryptions'] = ['none', 'ssl', 'tls'];

        $data['setting_smtp_encryption'] = $this->model_system_setting->getSettingValue('setting_smtp_encryption');

        $data['setting_smtp_host'] = $this->model_system_setting->getSettingValue('setting_smtp_host');

        $data['setting_smtp_username'] = $this->model_system_setting->getSettingValue('setting_smtp_username');

        $data['setting_smtp_password'] = $this->model_system_setting->getSettingValue('setting_smtp_password');

        $data['setting_smtp_port'] = $this->model_system_setting->getSettingValue('setting_smtp_port');

        $data['setting_smtp_timeout'] = $this->model_system_setting->getSettingValue('setting_smtp_timeout');

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $languages;

        $data['currencies'] = $this->model_localisation_currency->getCurrencies();
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
        $data['order_status_autocomplete'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/autocomplete');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
        ];
        $header_params = [
            'title' => lang('Heading.settings'),
            'scripts' => $scripts,
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
            'view' => 'System\setting',
            'permission' => 'System/Setting',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('setting_marketplace_name', lang('Entry.marketplace_name'), 'required');

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('setting_marketplace_description_' . $language['language_id'], lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('setting_marketplace_meta_title_' . $language['language_id'], lang('Entry.meta_title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            $this->validation->setRule('setting_smtp_host', lang('Entry.smtp_host'), 'required');
            $this->validation->setRule('setting_smtp_username', lang('Entry.smtp_username'), 'required');
            $this->validation->setRule('setting_smtp_password', lang('Entry.smtp_password'), 'required');
            $this->validation->setRule('setting_smtp_port', lang('Entry.smtp_port'), 'required');
            $this->validation->setRule('setting_smtp_timeout', lang('Entry.smtp_timeout'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('setting', $this->request->getPost());

                $json['success']['toast'] = lang('Success.setting_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/setting');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('setting_marketplace_name')) {
                    $json['error']['marketplace-name'] = $this->validation->getError('setting_marketplace_name');
                }

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('setting_marketplace_description_' . $language['language_id'])) {
                        $json['error']['marketplace-description-language-' . $language['language_id']] = $this->validation->getError('setting_marketplace_description_' . $language['language_id']);
                    }

                    if ($this->validation->hasError('setting_marketplace_meta_title_' . $language['language_id'])) {
                        $json['error']['marketplace-meta-title-language-' . $language['language_id']] = $this->validation->getError('setting_marketplace_meta_title_' . $language['language_id']);
                    }
                }

                if ($this->validation->hasError('setting_smtp_host')) {
                    $json['error']['smtp-host'] = $this->validation->getError('setting_smtp_host');
                }

                if ($this->validation->hasError('setting_smtp_username')) {
                    $json['error']['smtp-username'] = $this->validation->getError('setting_smtp_username');
                }

                if ($this->validation->hasError('setting_smtp_password')) {
                    $json['error']['smtp-password'] = $this->validation->getError('setting_smtp_password');
                }

                if ($this->validation->hasError('setting_smtp_port')) {
                    $json['error']['smtp-port'] = $this->validation->getError('setting_smtp_port');
                }

                if ($this->validation->hasError('setting_smtp_timeout')) {
                    $json['error']['smtp-timeout'] = $this->validation->getError('setting_smtp_timeout');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
