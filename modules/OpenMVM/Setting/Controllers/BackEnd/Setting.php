<?php

namespace Modules\OpenMVM\Setting\Controllers\BackEnd;

class Setting extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->administratorGroupModel = new \Modules\OpenMVM\Administrator\Models\AdministratorGroupModel();
		$this->userGroupModel = new \Modules\OpenMVM\User\Models\UserGroupModel();
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel;
		$this->currencyModel = new \Modules\OpenMVM\Localisation\Models\CurrencyModel;
		$this->weightClassModel = new \Modules\OpenMVM\Localisation\Models\WeightClassModel;
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/setting');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

    // Data Notification
    if ($this->session->get('error') !== null) {
			$data['error'] = $this->session->get('error');

			$this->session->remove('error');
    } else {
			$data['error'] = '';
    }

    if ($this->session->get('success') !== null) {
			$data['success'] = $this->session->get('success');

			$this->session->remove('success');
    } else {
			$data['success'] = '';
    }

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'setting_website_name' => ['label' => lang('Entry.entry_website_name', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
				'setting_meta_title' => ['label' => lang('Entry.entry_meta_title', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
				'setting_meta_description' => ['label' => lang('Entry.entry_meta_description', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
				'setting_meta_keywords' => ['label' => lang('Entry.entry_meta_keywords', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
				'setting_backend_items_per_page' => ['label' => lang('Entry.entry_backend_items_per_page', array(),  $this->language->getBackEndLocale()), 'rules' => 'greater_than[0]', 'errors' => ['greater_than' => lang('Error.error_greater_than', array(),  $this->language->getBackEndLocale())]],
				'setting_frontend_items_per_page' => ['label' => lang('Entry.entry_frontend_items_per_page', array(),  $this->language->getBackEndLocale()), 'rules' => 'greater_than[0]', 'errors' => ['greater_than' => lang('Error.error_greater_than', array(),  $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Setting/Controllers/BackEnd/Setting')) {
	      // Query
	      $query = $this->settingModel->editSettings('setting', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_settings_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_settings_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/setting/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_settings', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/setting/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_settings', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_setting_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if($this->request->getPost('setting_website_name')) {
			$data['setting_website_name'] = $this->request->getPost('setting_website_name');
		} else {
			$data['setting_website_name'] = $this->settingModel->getSettingValue('setting', 'setting_website_name');
		}

		$data['languages'] = $this->languageModel->getLanguages();

		if($this->request->getPost('setting_description')) {
			$data['setting_description'] = $this->request->getPost('setting_description');
		} else {
			$data['setting_description'] = json_decode($this->settingModel->getSettingValue('setting', 'setting_description'), true);
		}

		if($this->request->getPost('setting_meta_title')) {
			$data['setting_meta_title'] = $this->request->getPost('setting_meta_title');
		} else {
			$data['setting_meta_title'] = $this->settingModel->getSettingValue('setting', 'setting_meta_title');
		}

		if($this->request->getPost('setting_meta_description')) {
			$data['setting_meta_description'] = $this->request->getPost('setting_meta_description');
		} else {
			$data['setting_meta_description'] = $this->settingModel->getSettingValue('setting', 'setting_meta_description');
		}

		if($this->request->getPost('setting_meta_keywords')) {
			$data['setting_meta_keywords'] = $this->request->getPost('setting_meta_keywords');
		} else {
			$data['setting_meta_keywords'] = $this->settingModel->getSettingValue('setting', 'setting_meta_keywords');
		}

		if($this->request->getPost('setting_backend_theme')) {
			$data['setting_backend_theme'] = $this->request->getPost('setting_backend_theme');
		} else {
			$data['setting_backend_theme'] = $this->settingModel->getSettingValue('setting', 'setting_backend_theme');
		}

		$data['backend_themes'] = $this->backend_theme->getThemes();

		if($this->request->getPost('setting_frontend_theme')) {
			$data['setting_frontend_theme'] = $this->request->getPost('setting_frontend_theme');
		} else {
			$data['setting_frontend_theme'] = $this->settingModel->getSettingValue('setting', 'setting_frontend_theme');
		}

		$data['frontend_themes'] = $this->frontend_theme->getThemes();

		// Options
		$data['administrator_groups'] = $this->administratorGroupModel->getAdministratorGroups();

		if($this->request->getPost('setting_default_administrator_group_id')) {
			$data['setting_default_administrator_group_id'] = $this->request->getPost('setting_default_administrator_group_id');
		} else {
			$data['setting_default_administrator_group_id'] = $this->settingModel->getSettingValue('setting', 'setting_default_administrator_group_id');
		}

		$data['user_groups'] = $this->userGroupModel->getUserGroups();

		if($this->request->getPost('setting_default_user_group_id')) {
			$data['setting_default_user_group_id'] = $this->request->getPost('setting_default_user_group_id');
		} else {
			$data['setting_default_user_group_id'] = $this->settingModel->getSettingValue('setting', 'setting_default_user_group_id');
		}

		if($this->request->getPost('setting_backend_items_per_page')) {
			$data['setting_backend_items_per_page'] = $this->request->getPost('setting_backend_items_per_page');
		} else {
			$data['setting_backend_items_per_page'] = $this->settingModel->getSettingValue('setting', 'setting_backend_items_per_page');
		}

		if($this->request->getPost('setting_frontend_items_per_page')) {
			$data['setting_frontend_items_per_page'] = $this->request->getPost('setting_frontend_items_per_page');
		} else {
			$data['setting_frontend_items_per_page'] = $this->settingModel->getSettingValue('setting', 'setting_frontend_items_per_page');
		}

		if($this->request->getPost('setting_meta_title')) {
			$data['setting_meta_title'] = $this->request->getPost('setting_meta_title');
		} else {
			$data['setting_meta_title'] = $this->settingModel->getSettingValue('setting', 'setting_meta_title');
		}

		// Localisation
		// Language
		if($this->request->getPost('setting_frontend_language')) {
			$data['setting_frontend_language'] = $this->request->getPost('setting_frontend_language');
		} else {
			$data['setting_frontend_language'] = $this->settingModel->getSettingValue('setting', 'setting_frontend_language');
		}

		if($this->request->getPost('setting_backend_language')) {
			$data['setting_backend_language'] = $this->request->getPost('setting_backend_language');
		} else {
			$data['setting_backend_language'] = $this->settingModel->getSettingValue('setting', 'setting_backend_language');
		}

		$data['languages'] = $this->languageModel->getLanguages();

		// Currency
		if($this->request->getPost('setting_frontend_currency')) {
			$data['setting_frontend_currency'] = $this->request->getPost('setting_frontend_currency');
		} else {
			$data['setting_frontend_currency'] = $this->settingModel->getSettingValue('setting', 'setting_frontend_currency');
		}

		if($this->request->getPost('setting_backend_currency')) {
			$data['setting_backend_currency'] = $this->request->getPost('setting_backend_currency');
		} else {
			$data['setting_backend_currency'] = $this->settingModel->getSettingValue('setting', 'setting_backend_currency');
		}

		$data['currencies'] = $this->currencyModel->getCurrencies();

		// Weight Class
		if($this->request->getPost('setting_frontend_weight_class_id')) {
			$data['setting_frontend_weight_class_id'] = $this->request->getPost('setting_frontend_weight_class_id');
		} else {
			$data['setting_frontend_weight_class_id'] = $this->settingModel->getSettingValue('setting', 'setting_frontend_weight_class_id');
		}

		if($this->request->getPost('setting_backend_weight_class_id')) {
			$data['setting_backend_weight_class_id'] = $this->request->getPost('setting_backend_weight_class_id');
		} else {
			$data['setting_backend_weight_class_id'] = $this->settingModel->getSettingValue('setting', 'setting_backend_weight_class_id');
		}

		$data['weight_classes'] = $this->weightClassModel->getWeightClasses();

		// Images
		if ($this->request->getPost('logo')) {
			$data['thumb_logo'] = $this->image->resize($this->request->getPost('logo'), 150, 150, true, 'auto');
		} elseif ($this->settingModel->getSettingValue('setting', 'setting_logo') && is_file(ROOTPATH . 'public/assets/files/' . $this->settingModel->getSettingValue('setting', 'setting_logo'))) {
			$data['thumb_logo'] = $this->image->resize($this->settingModel->getSettingValue('setting', 'setting_logo'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
				$data['thumb_logo'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 150, 150, true, 'auto');
			} else {
				$data['thumb_logo'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('logo')) {
			$data['logo'] = $this->request->getPost('logo');
		} elseif ($this->settingModel->getSettingValue('setting', 'setting_logo') && is_file(ROOTPATH . 'public/assets/files/' . $this->settingModel->getSettingValue('setting', 'setting_logo'))) {
			$data['logo'] = $this->settingModel->getSettingValue('setting', 'setting_logo');
		} else {
			$data['logo'] = '';
		}
		
		if (!empty($this->setting->get('setting', 'setting_placeholder'))) {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
				$data['placeholder'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 150, 150, true, 'auto');
			} else {
				$data['placeholder'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		} else {
			$data['placeholder'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
		}

		// Mail
		$data['mail_protocols'] = array(
			array(
				'name' => 'SMTP',
				'value' => 'smtp',
			),
		);

    if ($this->request->getPost('setting_mail_protocol') !== null) {
			$data['setting_mail_protocol'] = $this->request->getPost('setting_mail_protocol');
    } else {
			$data['setting_mail_protocol'] = $this->settingModel->getSettingValue('setting', 'setting_mail_protocol');
		}

    if ($this->request->getPost('setting_smtp_hostname') !== null) {
			$data['setting_smtp_hostname'] = $this->request->getPost('setting_smtp_hostname');
    } else {
			$data['setting_smtp_hostname'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_hostname');
		}

    if ($this->request->getPost('setting_smtp_username') !== null) {
			$data['setting_smtp_username'] = $this->request->getPost('setting_smtp_username');
    } else {
			$data['setting_smtp_username'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_username');
		}

    if ($this->request->getPost('setting_smtp_password') !== null) {
			$data['setting_smtp_password'] = $this->request->getPost('setting_smtp_password');
    } else {
			$data['setting_smtp_password'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_password');
		}

    if ($this->request->getPost('setting_smtp_port') !== null) {
			$data['setting_smtp_port'] = $this->request->getPost('setting_smtp_port');
    } else {
			$data['setting_smtp_port'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_port');
		}

    if ($this->request->getPost('setting_smtp_timeout') !== null) {
			$data['setting_smtp_timeout'] = $this->request->getPost('setting_smtp_timeout');
    } else {
			$data['setting_smtp_timeout'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_timeout');
		}

    if ($this->request->getPost('setting_additional_alert_mail') !== null) {
			$data['setting_additional_alert_mail'] = $this->request->getPost('setting_additional_alert_mail');
    } else {
			$data['setting_additional_alert_mail'] = $this->settingModel->getSettingValue('setting', 'setting_additional_alert_mail');
		}

    if ($this->request->getPost('setting_smtp_verify_peer') !== null) {
			$data['setting_smtp_verify_peer'] = $this->request->getPost('setting_smtp_verify_peer');
    } else {
			$data['setting_smtp_verify_peer'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_verify_peer');
		}

    if ($this->request->getPost('setting_smtp_verify_peer_name') !== null) {
			$data['setting_smtp_verify_peer_name'] = $this->request->getPost('setting_smtp_verify_peer_name');
    } else {
			$data['setting_smtp_verify_peer_name'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_verify_peer_name');
		}

    if ($this->request->getPost('setting_smtp_allow_self_signed') !== null) {
			$data['setting_smtp_allow_self_signed'] = $this->request->getPost('setting_smtp_allow_self_signed');
    } else {
			$data['setting_smtp_allow_self_signed'] = $this->settingModel->getSettingValue('setting', 'setting_smtp_allow_self_signed');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$scripts = array(
			'<script src="' . base_url('assets/plugins/tinymce-5.7.0/js/tinymce/tinymce.min.js') . '" referrerpolicy="origin"></script>',
		);

		$header_parameter = array(
			'title' => lang('Heading.heading_settings', array(), $this->language->getBackEndLocale()),
			'scripts' => $scripts,
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Setting/Controllers/BackEnd/Setting')) {
			echo $this->template->render('BackendThemes', 'Setting\setting', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
