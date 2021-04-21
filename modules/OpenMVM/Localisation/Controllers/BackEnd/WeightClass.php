<?php

namespace Modules\OpenMVM\Localisation\Controllers\BackEnd;

class WeightClass extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->weightClassModel = new \Modules\OpenMVM\Localisation\Models\WeightClassModel();
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/weight_classes');

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
			'text' => lang('Heading.heading_weight_classes', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_weight_classes', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_weight_classes_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/WeightClass')) {
				foreach ($this->request->getPost('selected') as $weight_classes_id)
				{
					$this->weightClassModel->deleteWeightClass($weight_classes_id);
				}
	      
	      $this->session->set('success', lang('Success.success_weight_class_delete', array(), $this->language->getBackEndLocale()));
    	} else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    	}

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/weight_classes/add');

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
			'text' => lang('Heading.heading_weight_classes', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_weight_class_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_weight_class_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_weight_classes_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/add/' . $this->administrator->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.title' => ['label' => lang('Entry.entry_title', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.unit' => ['label' => lang('Entry.entry_unit', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/WeightClass')) {
	      // Query
	    	$query = $this->weightClassModel->addWeightClass($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_weight_class_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_weight_class_add', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/' . $this->request->uri->getSegment(5));

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
			'text' => lang('Heading.heading_weight_classes', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_weight_class_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_weight_class_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_weight_classes_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/' . $this->request->uri->getSegment(5) . '/' . $this->administrator->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.title' => ['label' => lang('Entry.entry_title', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.unit' => ['label' => lang('Entry.entry_unit', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Localisation/Controllers/BackEnd/WeightClass')) {
	      // Query
	    	$query = $this->weightClassModel->editWeightClass($this->request->getPost(), $this->request->uri->getSegment(5));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_weight_class_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_weight_class_edit', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }
      
			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/' . $this->administrator->getToken()));
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

		// Get Countries
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['weight_classes'] = array();

		$filter_data = array(
			'sort'  => 'weight_class_description.title',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->weightClassModel->getTotalWeightClasses($filter_data, $this->language->getBackEndId());

		$results = $this->weightClassModel->getWeightClasses($filter_data, $this->language->getBackEndId());

		foreach ($results as $result) {
			$data['weight_classes'][] = array(
				'weight_class_id' => $result['weight_class_id'],
				'title' => $result['title'],
				'edit' => base_url($_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/' . $result['weight_class_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_weight_classes', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Localisation/Controllers/BackEnd/WeightClass')) {
			echo $this->template->render('BackendThemes', 'Localisation\weight_class_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(4) == 'edit') {
			$weight_class_info = $this->weightClassModel->getWeightClass($this->request->uri->getSegment(5));
		}

		if($this->request->getPost('value')) {
			$data['value'] = $this->request->getPost('value');
		} elseif ($weight_class_info) {
			$data['value'] = $weight_class_info['value'];
		} else {
			$data['value'] = '';
		}

		$data['languages'] = $this->languageModel->getLanguages();

		if($this->request->getPost('description')) {
			$data['description'] = $this->request->getPost('description');
		} elseif ($weight_class_info) {
			$data['description'] = $this->weightClassModel->getWeightClassDescriptions($weight_class_info['weight_class_id']);
		} else {
			$data['description'] = array();
		}

		if($this->request->getPost('sort_order')) {
			$data['sort_order'] = $this->request->getPost('sort_order');
		} elseif ($weight_class_info) {
			$data['sort_order'] = $weight_class_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($weight_class_info) {
			$data['status'] = $weight_class_info['status'];
		} else {
			$data['status'] = 1;
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
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Localisation/Controllers/BackEnd/WeightClass')) {
			echo $this->template->render('BackendThemes', 'Localisation\weight_class_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
