<?php

namespace Main\Admin\Controllers\Administrator;

class Administrator_Group extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_administrator_administrator_group = new \Main\Admin\Models\Administrator\Administrator_Group_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.administrator_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group'),
            'active' => true,
        );

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.administrator_groups');

        // Get administrator groups
        $data['administrator_groups'] = [];

        $administrator_groups = $this->model_administrator_administrator_group->getAdministratorGroups();

        foreach ($administrator_groups as $administrator_group) {
            $data['administrator_groups'][] = [
                'administrator_group_id' => $administrator_group['administrator_group_id'],
                'name' => $administrator_group['name'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group/edit/' . $administrator_group['administrator_group_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Administrator/Administrator_Group')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.administrator_groups'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\administrator_group_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.administrator_groups'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.administrator_groups');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.administrator_groups'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.administrator_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $administrator_group_info = $this->model_administrator_administrator_group->getAdministratorGroup($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $administrator_group_info = [];
        }

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.administrator_groups');

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($administrator_group_info) {
            $data['name'] = $administrator_group_info['name'];
        } else {
            $data['name'] = '';
        }

		$ignore = array(
			'Administrator/Login',
			'Administrator/Logout',
			'Common/Column_Left',
			'Common/Dashboard',
			'Common/Footer',
			'Common/Header',
		);

		$data['permissions'] = [];

		$files = [];

		// Make core path into an array
		$path = array(ROOTPATH . 'main/admin/Controllers/*');

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
			$controller = substr($file, strlen(ROOTPATH . 'main/admin/Controllers/'));

			$permission = substr($controller, 0, strrpos($controller, '.'));

			if (!in_array($permission, $ignore)) {
				$data['permissions'][] = $permission;
			}
		}

        // Make plugin path into an array
        $plugin_path = array(ROOTPATH . 'plugins/*/*/Controllers/Admin/*');

        // While the path array is still populated keep looping through
        while (count($plugin_path) != 0) {
            $plugin_next = array_shift($plugin_path);

            foreach (glob($plugin_next) as $plugin_file) {
                // If directory add to path array
                if (is_dir($plugin_file)) {
                    $plugin_path[] = $plugin_file . '/*';
                }

                // Add the file to the files to be deleted array
                if (is_file($plugin_file)) {
                    $plugin_files[] = $plugin_file;
                }
            }
        }

        // Sort the file array
        sort($plugin_files);
                    
        foreach ($plugin_files as $plugin_file) {
            $controller = substr($plugin_file, strlen(ROOTPATH));

            $permission = substr($controller, 0, strrpos($controller, '.'));

            if (!in_array($permission, $ignore)) {
                $data['permissions'][] = $permission;
            }
        }

		if (isset($this->request->getPost('permission')['access'])) {
			$data['access'] = $this->request->getPost('permission')['access'];
		} elseif (isset($administrator_group_info['permission']['access'])) {
			$data['access'] = $administrator_group_info['permission']['access'];
		} else {
			$data['access'] = [];
		}

		if (isset($this->request->getPost('permission')['modify'])) {
			$data['modify'] = $this->request->getPost('permission')['modify'];
		} elseif (isset($administrator_group_info['permission']['modify'])) {
			$data['modify'] = $administrator_group_info['permission']['modify'];
		} else {
			$data['modify'] = [];
		}

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Administrator/Administrator_Group')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.administrator_groups'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\administrator_group_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.administrator_groups'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group'),
                'active' => false,
            );

            if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.edit'),
                    'href' => '',
                    'active' => true,
                );
            } else {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.add'),
                    'href' => '',
                    'active' => true,
                );
            }

            $data['heading_title'] = lang('Heading.administrator_groups');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.administrator_groups'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Administrator/Administrator_Group')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $administrator_group_id) {
                    // Query
                    $query = $this->model_administrator_administrator_group->deleteAdministratorGroup($administrator_group_id);
                }

                $json['success']['toast'] = lang('Success.administrator_group_delete');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group');
            } else {
                $json['error']['toast'] = lang('Error.administrator_group_delete');
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Administrator/Administrator_Group')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_administrator_administrator_group->editAdministratorGroup($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.administrator_group_edit');
                    } else {
                        // Query
                        $query = $this->model_administrator_administrator_group->addAdministratorGroup($this->request->getPost());

                        $json['success']['toast'] = lang('Success.administrator_group_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');
     
                    if ($this->validation->hasError('name')) {
                        $json['error']['name'] = $this->validation->getError('name');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
