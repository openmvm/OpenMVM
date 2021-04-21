<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd;

class ShippingMethod extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->productModel = new \Modules\OpenMVM\Store\Models\ProductModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
		$this->weightClassModel = new \Modules\OpenMVM\Localisation\Models\WeightClassModel();
		$this->lengthClassModel = new \Modules\OpenMVM\Localisation\Models\LengthClassModel();
		$this->shippingMethodModel = new \Modules\OpenMVM\ShippingMethod\Models\ShippingMethodModel();
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/store/shipping_methods');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

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
			'active' => true,
		);

		// Links
		$data['action'] = base_url('/account/store/shipping_methods/' . $this->user->getToken());

		// Return
		return $this->getList($data);
	}


	public function getList($data = array())
	{
		// Get installed shipping methods
		$data['shipping_methods'] = array();

		$shipping_methods = $this->shippingMethodModel->getInstalled();

		foreach ($shipping_methods as $shipping_method) {
			if (!empty($this->setting->get('shipping_' . $shipping_method['code'], 'shipping_' . $shipping_method['code'] . '_status'))) {
				$data['shipping_methods'][] = array(
					'name' => lang('Heading.heading_' . $shipping_method['code'], array(), $this->language->getFrontEndLocale()),
					'provider' => $shipping_method['provider'],
					'code' => $shipping_method['code'],
					'status' => $this->setting->get('vendor_' . $this->user->getStoreId() . '_shipping_' . $shipping_method['code'], 'vendor_' . $this->user->getStoreId() . '_shipping_' . $shipping_method['code'] . '_status') ? lang('Text.text_enabled', array(), $this->language->getFrontEndLocale()) : lang('Text.text_disabled', array(), $this->language->getFrontEndLocale()),
					'edit' => base_url('account/store/shipping_methods/' . $shipping_method['provider'] . '/' . $shipping_method['code'] . '/edit/' . $this->user->getToken()),
				);
			}
		}
		
		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_my_shipping_methods', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Store\shipping_method', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}