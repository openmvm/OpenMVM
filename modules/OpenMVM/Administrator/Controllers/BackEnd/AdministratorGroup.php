<?php

namespace Modules\OpenMVM\Administrator\Controllers\BackEnd;

use Modules\OpenMVM\Administrator\Models\AdministratorGroupModel;

class AdministratorGroup extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->administratorGroupModel = new \Modules\OpenMVM\Administrator\Models\AdministratorGroupModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrator/groups');

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
			'text' => lang('Heading.heading_administrator_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_groups', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrator_groups_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/AdministratorGroup')) {
				foreach ($this->request->getPost('selected') as $administrator_group_id)
				{
					$this->administratorGroupModel->deleteAdministratorGroup($administrator_group_id);
				}
	      
	      $this->session->set('success', lang('Success.success_administrator_group_delete', array(), $this->admin_locale));
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrators/groups/add');

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
			'text' => lang('Heading.heading_administrator_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_administrator_group_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrator/groups/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_group_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrator_groups_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/administrator/groups/add/' . $this->administrator->getToken());

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
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/AdministratorGroup')) {
	      // Query
	    	$query = $this->administratorGroupModel->addAdministratorGroup($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_administrator_group_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_administrator_group_add', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrators/groups/edit/' . $this->request->uri->getSegment(5));

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
			'text' => lang('Heading.heading_administrator_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_administrator_group_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrator/groups/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_group_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrator_groups_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/administrator/groups/edit/' . $this->request->uri->getSegment(5) . '/' . $this->administrator->getToken());

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
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/AdministratorGroup')) {
	      // Query
	    	$query = $this->administratorGroupModel->editAdministratorGroup($this->request->getPost(), $this->request->uri->getSegment(5));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_administrator_group_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_administrator_group_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrator/groups/' . $this->administrator->getToken()));
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

		// Get Administrator Groups
    if ($this->request->getPost('selected')) {
        $data['selected'] = (array)$this->request->getPost('selected');
    } else {
        $data['selected'] = array();
    }

		$data['administrator_groups'] = array();

		$filter_data = array(
			'sort'  => 'name',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->administratorGroupModel->getTotalAdministratorGroups($filter_data);

		$results = $this->administratorGroupModel->getAdministratorGroups($filter_data);

		foreach ($results as $result) {
			$data['administrator_groups'][] = array(
				'administrator_group_id' => $result['administrator_group_id'],
				'name'                   => $result['name'],
				'permission'             => $result['permission'],
				'edit'                   => base_url($_SERVER['app.adminDir'] . '/administrator/groups/edit/' . $result['administrator_group_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_administrator_groups', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Administrator/Controllers/BackEnd/AdministratorGroup')) {
			echo $this->template->render('BackendThemes', 'Administrator\administrator_group_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(4) == 'edit') {
			$administrator_group_info = $this->administratorGroupModel->getAdministratorGroup($this->request->uri->getSegment(5));
		}

		if($this->request->getPost('name')) {
			$data['name'] = $this->request->getPost('name');
		} elseif ($administrator_group_info) {
			$data['name'] = $administrator_group_info['name'];
		} else {
			$data['name'] = '';
		}

		// Permissions
		$data['permissions'] = array();

		// These directories will be ignored
		$ignore = array(
			'modules/OpenMVM/Common/Controllers/BackEnd/Footer',
			'modules/OpenMVM/Common/Controllers/BackEnd/Header',
			'modules/OpenMVM/Common/Controllers/BackEnd/SideMenu',
			'modules/OpenMVM/Administrator/Controllers/BackEnd/Login',
			'modules/OpenMVM/Administrator/Controllers/BackEnd/Logout',
		);

		$files = array();

		// Modules
		$modules = $this->module->getModules();

		if ($modules) {
			foreach ($modules as $module) {
				$module_path[] = ROOTPATH . 'modules/' . $module['dir_provider'] . '/' . $module['dir_module'] . '/Controllers/BackEnd/*';
			}
		} else {
			$module_path = [];
		}

		// Backend Themes
		$backend_themes = $this->backend_theme->getThemes();

		if ($backend_themes) {
			foreach ($backend_themes as $backend_theme) {
				$backend_theme_path[] = ROOTPATH . 'backend_themes/' . $backend_theme['dir_provider'] . '/' . $backend_theme['dir_theme'] . '/Controllers/BackEnd/*';
			}
		} else {
			$backend_theme_path = [];
		}

		// Frontend Themes
		$frontend_themes = $this->frontend_theme->getThemes();

		if ($frontend_themes) {
			foreach ($frontend_themes as $frontend_theme) {
				$frontend_theme_path[] = ROOTPATH . 'frontend_themes/' . $frontend_theme['dir_provider'] . '/' . $frontend_theme['dir_theme'] . '/Controllers/BackEnd/*';
			}
		} else {
			$frontend_theme_path = [];
		}

		// Payment Methods
		$payment_method_path = [];

		$path = array_merge($module_path, $backend_theme_path, $frontend_theme_path, $payment_method_path);
		//$path = $module_path;

		// While the path array is still populated keep looping through
		while (count($path) != 0) {
			$next = array_shift($path);

			foreach (glob($next) as $file) {
				// If directory add to path array
				if (is_dir($file)) {
					$path[] = $file . '/*';
				}

				// Add the file to the files to be deleted array
				if (is_file($file)) {
					$files[] = $file;
				}
			}
		}

		// Sort the file array
		sort($files);
					
		foreach ($files as $file) {
			$controller_path = substr($file, strlen(ROOTPATH));

			$find = array();
			$replace = array('');

			$controller = str_replace($find, $replace, $controller_path);

			$permission = substr($controller, 0, strrpos($controller, '.'));

			if (!in_array($permission, $ignore)) {
				$data['permissions'][] = $permission;
			}
		}

    if (!empty($this->request->getPost('permission')['access'])) {
      $data['access'] = $this->request->getPost('permission')['access'];
    } elseif ($administrator_group_info) {
    	$permission = json_decode($administrator_group_info['permission'], true);

    	if (!empty($permission['access'])) {
      	$data['access'] = $permission['access'];
    	} else {
      	$data['access'] = array();
    	}
    } else {
      $data['access'] = array();
    }

    if (!empty($this->request->getPost('permission')['modify'])) {
      $data['modify'] = $this->request->getPost('permission')['modify'];
    } elseif ($administrator_group_info) {
    	$permission = json_decode($administrator_group_info['permission'], true);

    	if (!empty($permission['modify'])) {
      	$data['modify'] = $permission['modify'];
    	} else {
      	$data['modify'] = array();
    	}
    } else {
      $data['modify'] = array();
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
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Administrator/Controllers/BackEnd/AdministratorGroup')) {
			echo $this->template->render('BackendThemes', 'Administrator\administrator_group_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
