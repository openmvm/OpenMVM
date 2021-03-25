<?php

namespace Modules\OpenMVM\User\Controllers\FrontEnd;

class UserAddress extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
		$this->userAddressModel = new \Modules\OpenMVM\User\Models\UserAddressModel();
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel();
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/address');

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
			'text' => lang('Heading.heading_address_book', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/address/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_address_book', array(), $this->language->getFrontEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->user->hasPermission()) {
				foreach ($this->request->getPost('selected') as $user_address_id)
				{
					$this->userAddressModel->deleteUserAddress($user_address_id, $this->user->getId());
				}
	      
	      $this->session->set('success', lang('Success.success_user_address_delete', array(), $this->language->getFrontEndLocale()));
    	} else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getFrontEndLocale()));
    	}

			return redirect()->to(base_url('/account/address/' . $this->user->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/address/add');

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
			'text' => lang('Heading.heading_address_book', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/address/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_address_add', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/address/add/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_address_add', array(), $this->language->getFrontEndLocale());

		// Data Link
		$data['action'] = base_url('/account/address/add/' . $this->user->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->user->hasPermission()) {
	      // Query
	    	$query = $this->userAddressModel->addUserAddress($this->request->getPost(), $this->user->getId());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_user_address_add', array(), $this->language->getFrontEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_user_address_add', array(), $this->language->getFrontEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/address/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/address/edit/' . $this->request->uri->getSegment(4));

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
			'text' => lang('Heading.heading_address_book', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/address/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_address_edit', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/address/edit/' . $this->request->uri->getSegment(4) . '/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_address_edit', array(), $this->language->getFrontEndLocale());

		// Data Link
		$data['action'] = base_url('/account/address/edit/' . $this->request->uri->getSegment(4) . '/' . $this->user->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->user->hasPermission()) {
	      // Query
	    	$query = $this->userAddressModel->editUserAddress($this->request->getPost(), $this->user->getId());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_user_address_edit', array(), $this->language->getFrontEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_user_address_edit', array(), $this->language->getFrontEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/address/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getList($data = array())
	{
		// Data URL Parameters
		if ($this->request->getGet('page') !== null) {
			$page = $this->request->getGet('page');
		} else {
			$page = 1;
		}

		// Get Users
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['user_addresses'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_frontend_items_per_page'),
		);

		$total_results = $this->userAddressModel->getTotalUserAddresses($filter_data, $this->user->getId());

		$results = $this->userAddressModel->getUserAddresses($filter_data, $this->user->getId());

		foreach ($results as $result) {
			if ($result['address_format']) {
				$format = $result['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{district} {city} {postal_code}' . "\n" . '{state}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{district}',
				'{city}',
				'{postal_code}',
				'{state}',
				'{state_code}',
				'{country}'
			);

			$replace = array(
				'firstname'   => $result['firstname'],
				'lastname'    => $result['lastname'],
				'company'     => $result['company'],
				'address_1'   => $result['address_1'],
				'address_2'   => $result['address_2'],
				'district'    => $result['district'],
				'city'        => $result['city'],
				'postal_code' => $result['postal_code'],
				'state'       => $result['state'],
				'state_code'  => $result['state_code'],
				'country'     => $result['country']
			);

			$data['user_addresses'][] = array(
				'user_address_id' => $result['user_address_id'],
				'address' => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
				'edit' => base_url('/account/address/edit/' . $result['user_address_id'] . '/' . $this->user->getToken()),
				'delete' => base_url('/account/address/delete/' . $result['user_address_id'] . '/' . $this->user->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_frontend_items_per_page'), $total_results, 'frontend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getFrontEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_frontend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + $this->setting->get('setting', 'setting_frontend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_frontend_items_per_page')));

		$data['user_token'] = $this->user->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_address_book', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'User\user_address_list', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(3) == 'edit') {
			$user_address_info = $this->userAddressModel->getUserAddress($this->request->uri->getSegment(4), $this->user->getId());
		}

		if($this->request->getPost('firstname')) {
			$data['firstname'] = $this->request->getPost('firstname');
		} elseif ($user_address_info) {
			$data['firstname'] = $user_address_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if($this->request->getPost('lastname')) {
			$data['lastname'] = $this->request->getPost('lastname');
		} elseif ($user_address_info) {
			$data['lastname'] = $user_address_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if($this->request->getPost('address_1')) {
			$data['address_1'] = $this->request->getPost('address_1');
		} elseif ($user_address_info) {
			$data['address_1'] = $user_address_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if($this->request->getPost('address_2')) {
			$data['address_2'] = $this->request->getPost('address_2');
		} elseif ($user_address_info) {
			$data['address_2'] = $user_address_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if($this->request->getPost('address_format')) {
			$data['address_format'] = $this->request->getPost('address_format');
		} elseif ($user_address_info) {
			$data['address_format'] = $user_address_info['address_format'];
		} else {
			$data['address_format'] = '';
		}

		$data['countries'] = $this->countryModel->getCountries(array());

		if($this->request->getPost('country_id')) {
			$data['country_id'] = $this->request->getPost('country_id');
		} elseif ($user_address_info) {
			$data['country_id'] = $user_address_info['country_id'];
		} else {
			$data['country_id'] = '';
		}

		if($this->request->getPost('state_id')) {
			$data['state_id'] = $this->request->getPost('state_id');
		} elseif ($user_address_info) {
			$data['state_id'] = $user_address_info['state_id'];
		} else {
			$data['state_id'] = '';
		}

		if($this->request->getPost('city_id')) {
			$data['city_id'] = $this->request->getPost('city_id');
		} elseif ($user_address_info) {
			$data['city_id'] = $user_address_info['city_id'];
		} else {
			$data['city_id'] = '';
		}

		if($this->request->getPost('district_id')) {
			$data['district_id'] = $this->request->getPost('district_id');
		} elseif ($user_address_info) {
			$data['district_id'] = $user_address_info['district_id'];
		} else {
			$data['district_id'] = '';
		}

		if($this->request->getPost('postal_code')) {
			$data['postal_code'] = $this->request->getPost('postal_code');
		} elseif ($user_address_info) {
			$data['postal_code'] = $user_address_info['postal_code'];
		} else {
			$data['postal_code'] = '';
		}

		if($this->request->getPost('telephone')) {
			$data['telephone'] = $this->request->getPost('telephone');
		} elseif ($user_address_info) {
			$data['telephone'] = $user_address_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		// Load Header
		$header_parameter = array(
			'title' => $data['heading_title'],
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'User\user_address_form', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}
