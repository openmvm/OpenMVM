<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd;

class Store extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel();
	}

	public function index()
	{
		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		// Return
		return $this->getInfo($data);
	}

	public function add()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

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
			'text' => lang('Heading.heading_my_store', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/add/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_my_store', array(), $this->language->getFrontEndLocale());

		// Data Link
		$data['action'] = base_url('/account/store/add/' . $this->user->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
			$this->validate([
				'name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.description' => ['label' => lang('Entry.entry_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.short_description' => ['label' => lang('Entry.entry_short_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->storeModel->addStore($this->request->getPost(), $this->user->getId());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_store_add', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_store_add', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account');

			return redirect()->to(base_url('/login'));
		}

		if (!$this->user->isMerchant()) {
			return redirect()->to(base_url('/account/store/add/' . $this->user->getToken()));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

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
			'text' => lang('Heading.heading_my_store', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/edit/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_my_store', array(), $this->language->getFrontEndLocale());

		// Data Link
		$data['action'] = base_url('/account/store/edit/' . $this->user->getStoreId() . '/' . $this->user->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
			$this->validate([
				'name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.description' => ['label' => lang('Entry.entry_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.short_description' => ['label' => lang('Entry.entry_short_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->storeModel->editStore($this->request->getPost(), $this->user->getStoreId(), $this->user->getId());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_store_edit', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_store_edit', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getInfo($data = array())
	{
		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Store\store', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->user->isMerchant()) {
			$store_info = $this->storeModel->getStore($this->user->getStoreId());
		}

		// General
		if($this->request->getPost('name')) {
			$data['name'] = $this->request->getPost('name');
		} elseif ($store_info) {
			$data['name'] = $store_info['name'];
		} else {
			$data['name'] = '';
		}

		$data['languages'] = $this->languageModel->getLanguages();

		if($this->request->getPost('description')) {
			$data['description'] = $this->request->getPost('description');
		} elseif ($store_info) {
			$data['description'] = $this->storeModel->getStoreDescriptions($store_info['store_id']);
		} else {
			$data['description'] = array();
		}

		// Images
		if ($this->request->getPost('logo')) {
			$data['thumb_logo'] = $this->image->resize($this->request->getPost('logo'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $store_info['logo'])) {
				$data['thumb_logo'] = $this->image->resize($store_info['logo'], 150, 150, true, 'auto');
			} else {
				$data['thumb_logo'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('logo')) {
			$data['logo'] = $this->request->getPost('logo');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $store_info['logo'])) {
			$data['logo'] = $store_info['logo'];
		} else {
			$data['logo'] = '';
		}

		if ($this->request->getPost('wallpaper')) {
			$data['thumb_wallpaper'] = $this->image->resize($this->request->getPost('wallpaper'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $store_info['wallpaper'])) {
				$data['thumb_wallpaper'] = $this->image->resize($store_info['wallpaper'], 150, 150, true, 'auto');
			} else {
				$data['thumb_wallpaper'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('wallpaper')) {
			$data['wallpaper'] = $this->request->getPost('wallpaper');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $store_info['wallpaper'])) {
			$data['wallpaper'] = $store_info['wallpaper'];
		} else {
			$data['wallpaper'] = '';
		}

		// Shipping
		if($this->request->getPost('shipping_origin_country_id')) {
			$data['shipping_origin_country_id'] = $this->request->getPost('shipping_origin_country_id');
		} elseif ($store_info) {
			$data['shipping_origin_country_id'] = $store_info['shipping_origin_country_id'];
		} else {
			$data['shipping_origin_country_id'] = 0;
		}

		if($this->request->getPost('shipping_origin_state_id')) {
			$data['shipping_origin_state_id'] = $this->request->getPost('shipping_origin_state_id');
		} elseif ($store_info) {
			$data['shipping_origin_state_id'] = $store_info['shipping_origin_state_id'];
		} else {
			$data['shipping_origin_state_id'] = 0;
		}

		if($this->request->getPost('shipping_origin_state')) {
			$data['shipping_origin_state'] = $this->request->getPost('shipping_origin_state');
		} elseif ($store_info) {
			$data['shipping_origin_state'] = $store_info['shipping_origin_state'];
		} else {
			$data['shipping_origin_state'] = '';
		}

		if($this->request->getPost('shipping_origin_city_id')) {
			$data['shipping_origin_city_id'] = $this->request->getPost('shipping_origin_city_id');
		} elseif ($store_info) {
			$data['shipping_origin_city_id'] = $store_info['shipping_origin_city_id'];
		} else {
			$data['shipping_origin_city_id'] = 0;
		}

		if($this->request->getPost('shipping_origin_city')) {
			$data['shipping_origin_city'] = $this->request->getPost('shipping_origin_city');
		} elseif ($store_info) {
			$data['shipping_origin_city'] = $store_info['shipping_origin_city'];
		} else {
			$data['shipping_origin_city'] = '';
		}

		if($this->request->getPost('shipping_origin_district_id')) {
			$data['shipping_origin_district_id'] = $this->request->getPost('shipping_origin_district_id');
		} elseif ($store_info) {
			$data['shipping_origin_district_id'] = $store_info['shipping_origin_district_id'];
		} else {
			$data['shipping_origin_district_id'] = 0;
		}

		if($this->request->getPost('shipping_origin_district')) {
			$data['shipping_origin_district'] = $this->request->getPost('shipping_origin_district');
		} elseif ($store_info) {
			$data['shipping_origin_district'] = $store_info['shipping_origin_district'];
		} else {
			$data['shipping_origin_district'] = '';
		}

		if($this->request->getPost('shipping_origin_postal_code')) {
			$data['shipping_origin_postal_code'] = $this->request->getPost('shipping_origin_postal_code');
		} elseif ($store_info) {
			$data['shipping_origin_postal_code'] = $store_info['shipping_origin_postal_code'];
		} else {
			$data['shipping_origin_postal_code'] = '';
		}

		$data['countries'] = $this->countryModel->getCountries();

		// Load Header
		$scripts = array(
			'<script src="' . base_url('assets/plugins/tinymce-5.7.0/js/tinymce/tinymce.min.js') . '" referrerpolicy="origin"></script>',
		);

		$header_parameter = array(
			'title' => lang('Heading.heading_my_store', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
			'scripts' => $scripts,
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Store\store_form', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}
