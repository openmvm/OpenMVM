<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\FrontEnd\ShippingMethod;

class Fedex extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/store/shipping_methods');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

		// Data Link
		$data['action'] = base_url('/account/store/shipping_methods/OpenMVM/fedex/edit/' . $this->user->getToken());

		// Form Validation
		if ($this->request->getMethod() === 'post') {
			$this->validate([
				'vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number' => ['label' => lang('Entry.entry_account_number', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
      $query = $this->settingModel->editSettings('vendor_' . $this->user->getStoreId() . '_shipping_fedex', $this->request->getPost());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_fedex_edit', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_fedex_edit', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url('/account/store/shipping_methods/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_shipping_methods', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/shipping_methods/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_fedex', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data form
		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_fedex', 'vendor_' . $this->user->getStoreId() . '_shipping_fedex_account_number');
		}

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_fedex_status')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_fedex_status'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_fedex_status');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_fedex_status'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_fedex', 'vendor_' . $this->user->getStoreId() . '_shipping_fedex_status');
		}

		$data['vendor_id'] = $this->user->getStoreId();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_fedex', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'ShippingMethod\ShippingMethod\fedex', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}
