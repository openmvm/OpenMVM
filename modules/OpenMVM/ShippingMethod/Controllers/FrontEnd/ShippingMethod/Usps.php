<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\FrontEnd\ShippingMethod;

class Usps extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->lengthClassModel = new \Modules\OpenMVM\Localisation\Models\LengthClassModel;
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
		$data['action'] = base_url('/account/store/shipping_methods/OpenMVM/usps/edit/' . $this->user->getToken());

		// Form
		if ($this->request->getMethod() === 'post') {
      // Query
      $query = $this->settingModel->editSettings('vendor_' . $this->user->getStoreId() . '_shipping_usps', $this->request->getPost());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_usps_edit', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_usps_edit', array(), $this->language->getFrontEndLocale()));
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
			'text' => lang('Heading.heading_usps', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data form
		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_length')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_length'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_length');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_length'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_length');
		}

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_width')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_width'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_width');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_width'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_width');
		}

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_height')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_height'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_height');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_height'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_package_dimension_height');
		}

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_length_class_id')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_length_class_id'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_length_class_id');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_length_class_id'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_length_class_id');
		}

		$data['length_classes'] = $this->lengthClassModel->getLengthClasses();

		// Size
		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_size')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_size'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_size');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_size'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_size');
		}

		$data['sizes'] = array();

		$data['sizes'][] = array(
			'text'  => lang('Text.text_regular', array(), $this->language->getFrontEndLocale()),
			'value' => 'REGULAR'
		);

		$data['sizes'][] = array(
			'text'  => lang('Text.text_large', array(), $this->language->getFrontEndLocale()),
			'value' => 'LARGE'
		);

		// Container
		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_container')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_container'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_container');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_container'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_container');
		}

		$data['containers'] = array();

		$data['containers'][] = array(
			'text'  => lang('Text.text_rectangular', array(), $this->language->getFrontEndLocale()),
			'value' => 'RECTANGULAR'
		);

		$data['containers'][] = array(
			'text'  => lang('Text.text_non_rectangular', array(), $this->language->getFrontEndLocale()),
			'value' => 'NONRECTANGULAR'
		);

		$data['containers'][] = array(
			'text'  => lang('Text.text_variable', array(), $this->language->getFrontEndLocale()),
			'value' => 'VARIABLE'
		);

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_machinable')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_machinable'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_machinable');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_machinable'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_machinable');
		}

		if ($this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_status')) {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_status'] = $this->request->getPost('vendor_' . $this->user->getStoreId() . '_shipping_usps_status');
		} else {
			$data['vendor_' . $this->user->getStoreId() . '_shipping_usps_status'] = $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_usps', 'vendor_' . $this->user->getStoreId() . '_shipping_usps_status');
		}

		$data['vendor_id'] = $this->user->getStoreId();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_usps', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'ShippingMethod\ShippingMethod\usps', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}
