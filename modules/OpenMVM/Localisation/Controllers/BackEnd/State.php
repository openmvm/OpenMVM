<?php

namespace Modules\OpenMVM\Localisation\Controllers\BackEnd;

use Modules\OpenMVM\Localisation\Models\CountryModel;
use Modules\OpenMVM\Localisation\Models\StateModel;
use Modules\OpenMVM\Localisation\Models\CityModel;

class State extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel();
		$this->stateModel = new \Modules\OpenMVM\Localisation\Models\StateModel();
		$this->cityModel = new \Modules\OpenMVM\Localisation\Models\CityModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/states');

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

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_states', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_states', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_states_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/State')) {
				foreach ($this->request->getPost('selected') as $state_id)
				{
					$this->stateModel->deleteState($state_id);
				}
	      
	      $this->session->set('success', lang('Success.success_state_delete', array(), $this->language->getBackEndLocale()));
    	} else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    	}

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/states/add');

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

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_states', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_state_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/states/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_state_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_states_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/localisation/states/add/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'name' => ['label' => lang('Entry.entry_name', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/State')) {
	      // Query
	    	$query = $this->stateModel->addState($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_state_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_state_add', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/states/edit/' . $this->request->uri->getSegment(5));

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

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_states', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_state_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/states/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_state_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_states_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/localisation/states/edit/' . $this->request->uri->getSegment(5) . '/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'name' => ['label' => lang('Entry.entry_name', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/State')) {
	      // Query
	    	$query = $this->stateModel->editState($this->request->getPost(), $this->request->uri->getSegment(5));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_state_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_state_edit', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }
      
			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/states/' . $this->administrator->getToken()));
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

		// Get States
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['states'] = array();

		$filter_data = array(
			'sort'  => 'name',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->stateModel->getTotalStates($filter_data);

		$results = $this->stateModel->getStates($filter_data);

		foreach ($results as $result) {
			// Get Country Info
			$country_info = $this->countryModel->getCountry($result['country_id']);

			$data['states'][] = array(
				'state_id'    => $result['state_id'],
				'name'        => $result['name'],
				'country'     => $country_info['name'],
				'edit' => base_url($_SERVER['app.adminDir'] . '/localisation/states/edit/' . $result['state_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_states', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Localisation/Controllers/BackEnd/State')) {
			echo $this->template->render('BackendThemes', 'Localisation\state_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(4) == 'edit') {
			$state_info = $this->stateModel->getState($this->request->uri->getSegment(5));
		}

		$data['countries'] = $this->countryModel->getCountries();

		if($this->request->getPost('name')) {
			$data['name'] = $this->request->getPost('name');
		} elseif ($state_info) {
			$data['name'] = $state_info['name'];
		} else {
			$data['name'] = '';
		}

		if($this->request->getPost('code')) {
			$data['code'] = $this->request->getPost('code');
		} elseif ($state_info) {
			$data['code'] = $state_info['code'];
		} else {
			$data['code'] = '';
		}

		if($this->request->getPost('country_id')) {
			$data['country_id'] = $this->request->getPost('country_id');
		} elseif ($state_info) {
			$data['country_id'] = $state_info['country_id'];
		} else {
			$data['country_id'] = 0;
		}

		if($this->request->getPost('sort_order')) {
			$data['sort_order'] = $this->request->getPost('sort_order');
		} elseif ($state_info) {
			$data['sort_order'] = $state_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($state_info) {
			$data['status'] = $state_info['status'];
		} else {
			$data['status'] = 1;
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

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => $data['heading_title'],
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Localisation/Controllers/BackEnd/State')) {
			echo $this->template->render('BackendThemes', 'Localisation\state_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getStates()
	{
    $json = array();

    // Get Countries
    $filter_data = array();

    $json['states'] = $this->stateModel->getStates($filter_data);

    return $this->response->setJSON($json);
	}

	public function getState()
	{
    $json = array();

    // Get State Info
    if ($this->request->getPost('state_id') !== null) {
	    $state_info = $this->stateModel->getState($this->request->getPost('state_id'));

	    if ($state_info) {
	    	$json['name'] = $state_info['name'];
	    	$json['code'] = $state_info['code'];
	    	$json['country_id'] = $state_info['country_id'];

	    	// Get Cities by State ID
	    	$filter_data = array(
	    		'filter_state' => $state_info['state_id'],
	    	);

	    	$json['cities'] = $this->cityModel->getCities($filter_data);
	    }
    }

    return $this->response->setJSON($json);
	}
}
