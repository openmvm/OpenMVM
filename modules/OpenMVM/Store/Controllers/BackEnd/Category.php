<?php

namespace Modules\OpenMVM\Store\Controllers\BackEnd;

class Category extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/categories');

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
			'text' => lang('Heading.heading_categories', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_categories', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_categories_lead', array(), $this->language->getBackEndLocale());

    // Delete
    if ($this->request->getPost('selected'))
    {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Store/Controllers/BackEnd/Category')) {
				foreach ($this->request->getPost('selected') as $category_id)
				{
					$this->categoryModel->deleteCategory($category_id);
				}
	      
	      $this->session->set('success', lang('Success.success_category_delete', array(), $this->language->getBackEndLocale()));
    	} else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    	}

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()));
    }

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/categories/add');

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
			'text' => lang('Heading.heading_categories', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_category_add', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/categories/add/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_category_add', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_categories_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/categories/add/' . $this->administrator->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/User/Controllers/BackEnd/User')) {
	      // Query
	    	$query = $this->categoryModel->addCategory($this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_category_add', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_category_add', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/categories/edit/' . $this->request->uri->getSegment(4));

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
			'text' => lang('Heading.heading_categories', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_category_edit', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/categories/edit/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_category_edit', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_categories_lead', array(), $this->language->getBackEndLocale());

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/categories/edit/' . $this->request->uri->getSegment(4) . '/' . $this->administrator->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Store/Controllers/BackEnd/Category')) {
	      // Query
	    	$query = $this->categoryModel->editCategory($this->request->getPost(), $this->request->uri->getSegment(4));
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_category_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_category_edit', array(), $this->language->getBackEndLocale()));
	      }
      } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
      }
      
			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/categories/' . $this->administrator->getToken()));
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

		$data['categories'] = array();

		$filter_data = array(
			'sort'  => 'path',
			'order' => 'ASC',
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_backend_items_per_page'),
		);

		$total_results = $this->categoryModel->getTotalCategories($filter_data, $this->language->getBackEndId());

		$results = $this->categoryModel->getCategories($filter_data, $this->language->getBackEndId());

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name' => $result['path'],
				'edit' => base_url($_SERVER['app.adminDir'] . '/categories/edit/' . $result['category_id'] . '/' . $this->administrator->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_backend_items_per_page'), $total_results, 'backend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getBackEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_backend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_backend_items_per_page')) + $this->setting->get('setting', 'setting_backend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_backend_items_per_page')));

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_categories', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Store/Controllers/BackEnd/Category')) {
			echo $this->template->render('BackendThemes', 'Store\category_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(3) == 'edit') {
			$category_info = $this->categoryModel->getCategory($this->request->uri->getSegment(4));
		}

		// General
		$data['languages'] = $this->languageModel->getLanguages();

		if($this->request->getPost('description')) {
			$data['description'] = $this->request->getPost('description');
		} elseif ($category_info) {
			$data['description'] = $this->categoryModel->getCategoryDescriptions($category_info['category_id']);
		} else {
			$data['description'] = array();
		}
		
    if ($this->request->getPost('category') !== null) {
			$data['category'] = $this->request->getPost('category');
    } elseif ($category_info) {
			// Get Parent Info
			$parent_info = $this->categoryModel->getCategoryDescription($category_info['parent_id'], $this->language->getBackEndId());
			
			$data['category'] = $parent_info['name'];
    } else {
			$data['category'] = '';
    }

    if ($this->request->getPost('parent_id') !== null) {
			$data['parent_id'] = $this->request->getPost('parent_id');
		} elseif ($category_info) {
			$data['parent_id'] = $category_info['parent_id'];
    } else {
			$data['parent_id'] = '';
		}

		if($this->request->getPost('top')) {
			$data['top'] = $this->request->getPost('top');
		} elseif ($category_info) {
			$data['top'] = $category_info['top'];
		} else {
			$data['top'] = '';
		}

		if($this->request->getPost('column')) {
			$data['column'] = $this->request->getPost('column');
		} elseif ($category_info) {
			$data['column'] = $category_info['column'];
		} else {
			$data['column'] = '';
		}

		if($this->request->getPost('sort_order')) {
			$data['sort_order'] = $this->request->getPost('top');
		} elseif ($category_info) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($category_info) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = 1;
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$scripts = array(
			'<script src="https://cdn.tiny.cloud/1/dbn26al47vjyo0bxis21dzudvrxslublqnw46jc6n4d9g74w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>',
		);

		$header_parameter = array(
			'title' => $data['heading_title'],
			'scripts' => $scripts,
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Store/Controllers/BackEnd/Category')) {
			echo $this->template->render('BackendThemes', 'Store\category_form', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function autocomplete()
	{
    $json = array();

    if ($this->request->getPost('filter_name') !== null) {
			$filter_data = array(
				'filter_name' => $this->request->getPost('filter_name'),
				'sort'        => 'path',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->categoryModel->getCategories($filter_data, $this->language->getBackEndId());

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['path'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

    return $this->response->setJSON($json);
  }
}
