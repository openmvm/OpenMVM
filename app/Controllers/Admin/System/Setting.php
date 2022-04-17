<?php

namespace App\Controllers\Admin\System;

class Setting extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_localisation_country = new \App\Models\Admin\Localisation\Country_Model();
        $this->model_localisation_currency = new \App\Models\Admin\Localisation\Currency_Model();
        $this->model_localisation_weight_class = new \App\Models\Admin\Localisation\Weight_Class_Model();
        $this->model_system_setting = new \App\Models\Admin\System\Setting_Model();
        $this->model_administrator_administrator_group = new \App\Models\Admin\Administrator\Administrator_Group_Model();
        $this->model_customer_customer_group = new \App\Models\Admin\Customer\Customer_Group_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/system/setting');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'System/Setting')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/system/setting'));
            }

            $this->validation->setRule('setting_marketplace_name', lang('Entry.marketplace_name'), 'required');

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('setting_marketplace_description_' . $language['language_id'], lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('setting_marketplace_meta_title_' . $language['language_id'], lang('Entry.meta_title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('setting', $this->request->getPost());

                $this->session->set('success', lang('Success.setting_edit'));

                return redirect()->to($this->url->administratorLink('admin/system/setting'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('setting_marketplace_name')) {
                    $data['error_setting_marketplace_name'] = $this->validation->getError('setting_marketplace_name');
                } else {
                    $data['error_setting_marketplace_name'] = '';
                }

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('setting_marketplace_description_' . $language['language_id'])) {
                        $data['error_setting_marketplace_description_' . $language['language_id']] = $this->validation->getError('setting_marketplace_description_' . $language['language_id']);
                    } else {
                        $data['error_setting_marketplace_description_' . $language['language_id']] = '';
                    }

                    if ($this->validation->hasError('setting_marketplace_meta_title_' . $language['language_id'])) {
                        $data['error_setting_marketplace_meta_title_' . $language['language_id']] = $this->validation->getError('setting_marketplace_meta_title_' . $language['language_id']);
                    } else {
                        $data['error_setting_marketplace_meta_title_' . $language['language_id']] = '';
                    }
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.settings'),
            'href' => $this->url->administratorLink('admin/system/setting'),
            'active' => true,
        );

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.settings');

        // General
        if ($this->request->getPost('setting_marketplace_name')) {
            $data['setting_marketplace_name'] = $this->request->getPost('setting_marketplace_name');
        } else {
            $data['setting_marketplace_name'] = $this->model_system_setting->getSettingValue('setting_marketplace_name');
        }

        $languages = $this->model_localisation_language->getlanguages();

        foreach ($languages as $language) {
            if ($this->request->getPost('setting_marketplace_description_' . $language['language_id'])) {
                $data['setting_marketplace_description_' . $language['language_id']] = $this->request->getPost('setting_marketplace_description_' . $language['language_id']);
            } else {
                $data['setting_marketplace_description_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_description_' . $language['language_id']);
            }
    
            if ($this->request->getPost('setting_marketplace_meta_title_' . $language['language_id'])) {
                $data['setting_marketplace_meta_title_' . $language['language_id']] = $this->request->getPost('setting_marketplace_meta_title_' . $language['language_id']);
            } else {
                $data['setting_marketplace_meta_title_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_title_' . $language['language_id']);
            }
    
            if ($this->request->getPost('setting_marketplace_meta_description_' . $language['language_id'])) {
                $data['setting_marketplace_meta_description_' . $language['language_id']] = $this->request->getPost('setting_marketplace_meta_description_' . $language['language_id']);
            } else {
                $data['setting_marketplace_meta_description_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_description_' . $language['language_id']);
            }
    
            if ($this->request->getPost('setting_marketplace_meta_keywords_' . $language['language_id'])) {
                $data['setting_marketplace_meta_keywords_' . $language['language_id']] = $this->request->getPost('setting_marketplace_meta_keywords_' . $language['language_id']);
            } else {
                $data['setting_marketplace_meta_keywords_' . $language['language_id']] = $this->model_system_setting->getSettingValue('setting_marketplace_meta_keywords_' . $language['language_id']);
            }
        }

        // Data
        if ($this->request->getPost('setting_logo')) {
            $data['setting_logo'] = $this->request->getPost('setting_logo');
        } else {
            $data['setting_logo'] = $this->model_system_setting->getSettingValue('setting_logo');
        }

        if (!empty($this->request->getPost('setting_logo')) && is_file(ROOTPATH . 'public/assets/images/' . $this->request->getPost('setting_logo'))) {
            $data['logo_thumb'] = $this->image->resize($this->request->getPost('setting_logo'), 100, 100, true);
        } elseif (!empty($this->model_system_setting->getSettingValue('setting_logo')) && is_file(ROOTPATH . 'public/assets/images/' . $this->model_system_setting->getSettingValue('setting_logo'))) {
            $data['logo_thumb'] = $this->image->resize($this->model_system_setting->getSettingValue('setting_logo'), 100, 100, true);
        } else {
            $data['logo_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($this->request->getPost('setting_favicon')) {
            $data['setting_favicon'] = $this->request->getPost('setting_favicon');
        } else {
            $data['setting_favicon'] = $this->model_system_setting->getSettingValue('setting_favicon');
        }

        if (!empty($this->request->getPost('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->request->getPost('setting_favicon'))) {
            $data['favicon_thumb'] = $this->image->resize($this->request->getPost('setting_favicon'), 100, 100, true);
        } elseif (!empty($this->model_system_setting->getSettingValue('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->model_system_setting->getSettingValue('setting_favicon'))) {
            $data['favicon_thumb'] = $this->image->resize($this->model_system_setting->getSettingValue('setting_favicon'), 100, 100, true);
        } else {
            $data['favicon_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($this->request->getPost('setting_copyright_name')) {
            $data['setting_copyright_name'] = $this->request->getPost('setting_copyright_name');
        } else {
            $data['setting_copyright_name'] = $this->model_system_setting->getSettingValue('setting_copyright_name');
        }

        if ($this->request->getPost('setting_copyright_year')) {
            $data['setting_copyright_year'] = $this->request->getPost('setting_copyright_year');
        } else {
            $data['setting_copyright_year'] = $this->model_system_setting->getSettingValue('setting_copyright_year');
        }

        if ($this->request->getPost('setting_address_1')) {
            $data['setting_address_1'] = $this->request->getPost('setting_address_1');
        } else {
            $data['setting_address_1'] = $this->model_system_setting->getSettingValue('setting_address_1');
        }

        if ($this->request->getPost('setting_address_2')) {
            $data['setting_address_2'] = $this->request->getPost('setting_address_2');
        } else {
            $data['setting_address_2'] = $this->model_system_setting->getSettingValue('setting_address_2');
        }

        if ($this->request->getPost('setting_city')) {
            $data['setting_city'] = $this->request->getPost('setting_city');
        } else {
            $data['setting_city'] = $this->model_system_setting->getSettingValue('setting_city');
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        if ($this->request->getPost('setting_country_id')) {
            $data['setting_country_id'] = $this->request->getPost('setting_country_id');
        } else {
            $data['setting_country_id'] = $this->model_system_setting->getSettingValue('setting_country_id');
        }

        if ($this->request->getPost('setting_zone_id')) {
            $data['setting_zone_id'] = $this->request->getPost('setting_zone_id');
        } else {
            $data['setting_zone_id'] = $this->model_system_setting->getSettingValue('setting_zone_id');
        }

        if ($this->request->getPost('setting_telephone')) {
            $data['setting_telephone'] = $this->request->getPost('setting_telephone');
        } else {
            $data['setting_telephone'] = $this->model_system_setting->getSettingValue('setting_telephone');
        }

        if ($this->request->getPost('setting_email')) {
            $data['setting_email'] = $this->request->getPost('setting_email');
        } else {
            $data['setting_email'] = $this->model_system_setting->getSettingValue('setting_email');
        }

        // Options
        $data['administrator_groups'] = $this->model_administrator_administrator_group->getAdministratorGroups();

        if ($this->request->getPost('setting_administrator_group_id')) {
            $data['setting_administrator_group_id'] = $this->request->getPost('setting_administrator_group_id');
        } else {
            $data['setting_administrator_group_id'] = $this->model_system_setting->getSettingValue('setting_administrator_group_id');
        }

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        if ($this->request->getPost('setting_customer_group_id')) {
            $data['setting_customer_group_id'] = $this->request->getPost('setting_customer_group_id');
        } else {
            $data['setting_customer_group_id'] = $this->model_system_setting->getSettingValue('setting_customer_group_id');
        }

        if ($this->request->getPost('setting_order_invoice_prefix')) {
            $data['setting_order_invoice_prefix'] = $this->request->getPost('setting_order_invoice_prefix');
        } else {
            $data['setting_order_invoice_prefix'] = $this->model_system_setting->getSettingValue('setting_order_invoice_prefix');
        }

        // Localisation
        if ($this->request->getPost('setting_admin_language_id')) {
            $data['setting_admin_language_id'] = $this->request->getPost('setting_admin_language_id');
        } else {
            $data['setting_admin_language_id'] = $this->model_system_setting->getSettingValue('setting_admin_language_id');
        }

        if ($this->request->getPost('setting_marketplace_language_id')) {
            $data['setting_marketplace_language_id'] = $this->request->getPost('setting_marketplace_language_id');
        } else {
            $data['setting_marketplace_language_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_language_id');
        }

        if ($this->request->getPost('setting_admin_currency_id')) {
            $data['setting_admin_currency_id'] = $this->request->getPost('setting_admin_currency_id');
        } else {
            $data['setting_admin_currency_id'] = $this->model_system_setting->getSettingValue('setting_admin_currency_id');
        }

        if ($this->request->getPost('setting_marketplace_currency_id')) {
            $data['setting_marketplace_currency_id'] = $this->request->getPost('setting_marketplace_currency_id');
        } else {
            $data['setting_marketplace_currency_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_currency_id');
        }

        if ($this->request->getPost('setting_admin_weight_class_id')) {
            $data['setting_admin_weight_class_id'] = $this->request->getPost('setting_admin_weight_class_id');
        } else {
            $data['setting_admin_weight_class_id'] = $this->model_system_setting->getSettingValue('setting_admin_weight_class_id');
        }

        if ($this->request->getPost('setting_marketplace_weight_class_id')) {
            $data['setting_marketplace_weight_class_id'] = $this->request->getPost('setting_marketplace_weight_class_id');
        } else {
            $data['setting_marketplace_weight_class_id'] = $this->model_system_setting->getSettingValue('setting_marketplace_weight_class_id');
        }

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
                'href' => $this->url->administratorLink('admin/appearance/admin/theme/' . strtolower($admin_theme_author) . '/' . strtolower($admin_theme_name)),
            ];
        }

        if ($this->request->getPost('setting_admin_theme')) {
            $data['setting_admin_theme'] = $this->request->getPost('setting_admin_theme');
        } else {
            $data['setting_admin_theme'] = $this->model_system_setting->getSettingValue('setting_admin_theme');
        }

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
                'href' => $this->url->administratorLink('admin/appearance/marketplace/theme/' . strtolower($marketplace_theme_author) . '/' . strtolower($marketplace_theme_name)),
            ];
        }

        if ($this->request->getPost('setting_marketplace_theme')) {
            $data['setting_marketplace_theme'] = $this->request->getPost('setting_marketplace_theme');
        } else {
            $data['setting_marketplace_theme'] = $this->model_system_setting->getSettingValue('setting_marketplace_theme');
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $languages;

        $data['currencies'] = $this->model_localisation_currency->getCurrencies();
        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'System/Setting')) {
            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/tinymce-5.10.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
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

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'System\setting', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.settings'),
                'href' => $this->url->administratorLink('admin/system/setting'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.settings');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.settings'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }
}
