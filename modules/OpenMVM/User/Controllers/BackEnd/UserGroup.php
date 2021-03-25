<?php

namespace Modules\OpenMVM\User\Controllers\BackEnd;

use Modules\OpenMVM\User\Models\UserGroupModel;

class UserGroup extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userGroupModel = new \Modules\OpenMVM\User\Models\UserGroupModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/user/groups');

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
			'text' => lang('Heading.heading_user_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_user_groups', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_user_groups_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/User/Controllers/BackEnd/UserGroup')) {
				foreach ($this->request->getPost('selected') as $user_group_id)
				{
					$this->userGroupModel->deleteUserGroup($user_group_id);
				}
	      
	      $this->session->set('success', lang('Success.success_user_group_delete', array(), $this->admin_locale));
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/user/groups/add');

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
			'text' => lang('Heading.heading_user_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_user_group_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/user/groups/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_user_group_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_user_groups_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/user/groups/add/' . $this->administrator->getToken());

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
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/User/Controllers/BackEnd/UserGroup')) {
	      // Query
	    	$query = $this->userGroupModel->addUserGroup($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_user_group_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_user_group_add', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/user/groups/edit/' . $this->request->uri->getSegment(5));

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
			'text' => lang('Heading.heading_user_groups', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_user_group_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/user/groups/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_user_group_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_user_groups_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/user/groups/edit/' . $this->request->uri->getSegment(5) . '/' . $this->administrator->getToken());

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
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/User/Controllers/BackEnd/UserGroup')) {
	      // Query
	    	$query = $this->userGroupModel->editUserGroup($this->request->getPost(), $this->request->uri->getSegment(5));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_user_group_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_user_group_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/user/groups/' . $this->administrator->getToken()));
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

		// Get User Groups
    if ($this->request->getPost('selected')) {
        $data['selected'] = (array)$this->request->getPost('selected');
    } else {
        $data['selected'] = array();
    }

		$data['user_groups'] = array();

		$filter_data = array(
			'sort'  => 'name',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->userGroupModel->getTotalUserGroups($filter_data);

		$results = $this->userGroupModel->getUserGroups($filter_data);

		foreach ($results as $result) {
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'                   => $result['name'],
				'edit'                   => base_url($_SERVER['app.adminDir'] . '/user/groups/edit/' . $result['user_group_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_user_groups', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/User/Controllers/BackEnd/UserGroup')) {
			echo $this->template->render('BackendThemes', 'User\user_group_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(4) == 'edit') {
			$user_group_info = $this->userGroupModel->getUserGroup($this->request->uri->getSegment(5));
		}

		if($this->request->getPost('name')) {
			$data['name'] = $this->request->getPost('name');
		} elseif ($user_group_info) {
			$data['name'] = $user_group_info['name'];
		} else {
			$data['name'] = '';
		}

		if($this->request->getPost('email_verification')) {
			$data['email_verification'] = $this->request->getPost('email_verification');
		} elseif ($user_group_info) {
			$data['email_verification'] = $user_group_info['email_verification'];
		} else {
			$data['email_verification'] = 0;
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
		if ($this->administrator->hasPermission('access','modules/OpenMVM/User/Controllers/BackEnd/UserGroup')) {
			echo $this->template->render('BackendThemes', 'User\user_group_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
