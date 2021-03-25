<?php

namespace Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod;

class BankTransfer extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel;
		$this->orderStatusModel = new \Modules\OpenMVM\Localisation\Models\OrderStatusModel;
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/payment_methods');

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

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/payment_methods/OpenMVM/bank_transfer/edit/' . $this->administrator->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'payment_bank_transfer_bank'. $language['language_id'] => ['label' => lang('Entry.entry_bank', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/PaymentMethod/Controllers/BackEnd/PaymentMethod/BankTransfer')) {
	      // Query
	      $query = $this->settingModel->editSettings('payment_bank_transfer', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_bank_transfer_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_bank_transfer_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/payment_methods/' . $this->administrator->getToken()));
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
			'text' => lang('Heading.heading_payment_methods', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/payment_methods/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_bank_transfer', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_bank_transfer', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_bank_transfer_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		$data['payment_bank_transfer_bank'] = array();

		$languages = $this->languageModel->getLanguages();
		
		foreach ($languages as $language) {
			if ($this->request->getPost('payment_bank_transfer_bank' . $language['language_id'])) {
				$data['payment_bank_transfer_bank'][$language['language_id']] = $this->request->getPost('payment_bank_transfer_bank' . $language['language_id']);
			} else {
				$data['payment_bank_transfer_bank'][$language['language_id']] = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_bank' . $language['language_id']);
			}
		}

		$data['languages'] = $languages;

		if ($this->request->getPost('payment_bank_transfer_total')) {
			$data['payment_bank_transfer_total'] = $this->request->getPost('payment_bank_transfer_total');
		} else {
			$data['payment_bank_transfer_total'] = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_total');
		}

		if ($this->request->getPost('payment_bank_transfer_order_status_id')) {
			$data['payment_bank_transfer_order_status_id'] = $this->request->getPost('payment_bank_transfer_order_status_id');
		} else {
			$data['payment_bank_transfer_order_status_id'] = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_order_status_id');
		}

		$data['order_statuses'] = $this->orderStatusModel->getOrderStatuses();

		if ($this->request->getPost('payment_bank_transfer_status')) {
			$data['payment_bank_transfer_status'] = $this->request->getPost('payment_bank_transfer_status');
		} else {
			$data['payment_bank_transfer_status'] = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_status');
		}

		if ($this->request->getPost('payment_bank_transfer_sort_order')) {
			$data['payment_bank_transfer_sort_order'] = $this->request->getPost('payment_bank_transfer_sort_order');
		} else {
			$data['payment_bank_transfer_sort_order'] = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_sort_order');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_bank_transfer', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/PaymentMethod/Controllers/BackEnd/PaymentMethod/BankTransfer')) {
			echo $this->template->render('BackendThemes', 'PaymentMethod\PaymentMethod\bank_transfer', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
