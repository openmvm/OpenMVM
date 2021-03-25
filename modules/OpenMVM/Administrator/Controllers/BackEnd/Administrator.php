<?php

namespace Modules\OpenMVM\Administrator\Controllers\BackEnd;

use Modules\OpenMVM\Administrator\Models\AdministratorGroupModel;
use Modules\OpenMVM\Administrator\Models\AdministratorModel;

class Administrator extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->administratorGroupModel = new \Modules\OpenMVM\Administrator\Models\AdministratorGroupModel();
		$this->administratorModel = new \Modules\OpenMVM\Administrator\Models\AdministratorModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrators');

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
			'text' => lang('Heading.heading_administrators', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrators', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrators_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/Administrator')) {
				foreach ($this->request->getPost('selected') as $administrator_id)
				{
					$this->administratorModel->deleteAdministrator($administrator_id);
				}
	      
	      $this->session->set('success', lang('Success.success_administrator_delete', array(), $this->language->getBackEndLocale()));
    	} else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    	}

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrators/add');

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
			'text' => lang('Heading.heading_administrators', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_administrator_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrators/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrators_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/administrators/add/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getBackEndLocale()), 'rules' => 'required|is_unique[administrator.username]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getBackEndLocale())]],
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getBackEndLocale()), 'rules' => 'required|valid_email|is_unique[administrator.email]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getBackEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getBackEndLocale())]],
				'password' => ['label' => lang('Entry.entry_password', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				'passconf' => ['label' => lang('Entry.entry_passconf', array(), $this->language->getBackEndLocale()), 'rules' => 'required|matches[password]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'matches' => lang('Error.error_matches', array(), $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/Administrator')) {
	      // Query
	    	$query = $this->administratorModel->addAdministrator($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_administrator_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_administrator_add', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/administrators/edit/' . $this->request->uri->getSegment(4));

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
			'text' => lang('Heading.heading_administrators', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_administrator_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/administrators/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_administrators_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/administrators/edit/' . $this->request->uri->getSegment(4) . '/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			// Check Username
			$username_exists = $this->administratorModel->getAdministratorByUsername($this->request->getPost('username'));

			if ($username_exists && $username_exists['administrator_id'] == $this->request->uri->getSegment(4)) {
				$this->validate([
					'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				]);
			} else {
				$this->validate([
					'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getBackEndLocale()), 'rules' => 'required|is_unique[administrator.username]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getBackEndLocale())]],
				]);
			}

			$this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
			]);

			$this->validate([
				'lastname' => ['label' => lang('Entry.entry_lastname'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
			]);

			// Check Email
			$email_exists = $this->administratorModel->getAdministratorByEmail($this->request->getPost('email'));

			if ($email_exists && $email_exists['administrator_id'] == $this->request->uri->getSegment(4)) {
				$this->validate([
					'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getBackEndLocale()), 'rules' => 'required|valid_email', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getBackEndLocale())]],
				]);
			} else {
				$this->validate([
					'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getBackEndLocale()), 'rules' => 'required|valid_email|is_unique[administrator.email]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getBackEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getBackEndLocale())]],
				]);
			}

			if ($this->request->getPost('password') !== '' || $this->request->getPost('passconf') !== '') {
				$this->validate([
					'password' => ['label' => lang('Entry.entry_password'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
					'passconf' => ['label' => lang('Entry.entry_passconf', array(), $this->language->getBackEndLocale()), 'rules' => 'required|matches[password]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale()), 'matches' => lang('Error.error_matches', array(), $this->language->getBackEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Administrator/Controllers/BackEnd/Administrator')) {
	      // Query
	    	$query = $this->administratorModel->editAdministrator($this->request->getPost(), $this->request->uri->getSegment(4));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_administrator_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_administrator_edit', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }
      
			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/administrators/' . $this->administrator->getToken()));
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

		// Get Administrators
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['administrators'] = array();

		$filter_data = array(
			'sort'  => 'username',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->administratorModel->getTotalAdministrators($filter_data);

		$results = $this->administratorModel->getAdministrators($filter_data);

		foreach ($results as $result) {
			$administrator_group_info = $this->administratorGroupModel->getAdministratorGroup($result['administrator_group_id']);

			if ($result && is_file(ROOTPATH . 'public/assets/files/' . $result['avatar'])) {
				$avatar = $this->image->resize($result['avatar'], 48, 48, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$avatar = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 48, 48, true, 'auto');
				} else {
					$avatar = $this->image->resize('placeholder.png', 48, 48, true, 'auto');
				}
			}

			$data['administrators'][] = array(
				'administrator_id'    => $result['administrator_id'],
				'firstname'           => $result['firstname'],
				'lastname'            => $result['lastname'],
				'email'               => $result['email'],
				'avatar'              => $avatar,
				'administrator_group' => $administrator_group_info['name'],
				'edit'                => base_url($_SERVER['app.adminDir'] . '/administrators/edit/' . $result['administrator_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_administrators', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Administrator/Controllers/BackEnd/Administrator')) {
			echo $this->template->render('BackendThemes', 'Administrator\administrator_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(3) == 'edit') {
			$administrator_info = $this->administratorModel->getAdministrator($this->request->uri->getSegment(4));
		}

		$data['administrator_groups'] = $this->administratorGroupModel->getAdministratorGroups();

		if($this->request->getPost('administrator_group_id')) {
			$data['administrator_group_id'] = $this->request->getPost('administrator_group_id');
		} elseif ($administrator_info) {
			$data['administrator_group_id'] = $administrator_info['administrator_group_id'];
		} else {
			$data['administrator_group_id'] = '';
		}

		if($this->request->getPost('username')) {
			$data['username'] = $this->request->getPost('username');
		} elseif ($administrator_info) {
			$data['username'] = $administrator_info['username'];
		} else {
			$data['username'] = '';
		}

		if ($this->request->getPost('avatar')) {
			$data['thumb_avatar'] = $this->image->resize($this->request->getPost('avatar'), 150, 150, true, 'auto');
		} elseif ($administrator_info && is_file(ROOTPATH . 'public/assets/files/' . $administrator_info['avatar'])) {
			$data['thumb_avatar'] = $this->image->resize($administrator_info['avatar'], 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
				$data['thumb_avatar'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 150, 150, true, 'auto');
			} else {
				$data['thumb_avatar'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('avatar')) {
			$data['avatar'] = $this->request->getPost('avatar');
		} elseif ($administrator_info && is_file(ROOTPATH . 'public/assets/files/' . $administrator_info['avatar'])) {
			$data['avatar'] = $administrator_info['avatar'];
		} else {
			$data['avatar'] = '';
		}

		if($this->request->getPost('firstname')) {
			$data['firstname'] = $this->request->getPost('firstname');
		} elseif ($administrator_info) {
			$data['firstname'] = $administrator_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if($this->request->getPost('lastname')) {
			$data['lastname'] = $this->request->getPost('lastname');
		} elseif ($administrator_info) {
			$data['lastname'] = $administrator_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if($this->request->getPost('email')) {
			$data['email'] = $this->request->getPost('email');
		} elseif ($administrator_info) {
			$data['email'] = $administrator_info['email'];
		} else {
			$data['email'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($administrator_info) {
			$data['status'] = $administrator_info['status'];
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
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Administrator/Controllers/BackEnd/Administrator')) {
			echo $this->template->render('BackendThemes', 'Administrator\administrator_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
