<?php

namespace Main\Admin\Controllers\Plugin;

class Plugin extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_extension_extension = new \Main\Admin\Models\Extension\Extension_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.plugins'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin'),
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

        $data['heading_title'] = lang('Heading.plugins');

        // Get marketplace plugins
        $path = ROOTPATH . 'plugins/*/*';

        $plugins = array_diff(glob($path), array('.', '..'));

        foreach ($plugins as $plugin) {
            $segment = explode('/', $plugin);
            $total_segments = count($segment);

            $plugin_author = $segment[$total_segments - 2];
            $plugin_name = pathinfo($segment[$total_segments - 1], PATHINFO_FILENAME);

            // Check if it is installed
            $extension_info = $this->model_extension_extension->getInstalledExtension('plugin', $plugin_author . ':' . $plugin_name);

            if ($extension_info) {
                $activated = true;

                $info = file_get_contents($this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin/' . $plugin_author . '/' . $plugin_name . '/get_info'));

                $plugin_info = json_decode($info, true);

                if (!empty($plugin_info['link'])) {
                    $link = $plugin_info['link'];
                } else {
                    $link = false;
                }

                if (!empty($plugin_info['description'])) {
                    $description = $plugin_info['description'];
                } else {
                    $description = false;
                }

                if (!empty($plugin_info['image'])) {
                    $image = $plugin_info['image'];
                } else {
                    $image = false;
                }
            } else {
                $activated = false;

                $link = false;

                $description = lang('Text.plugin_not_installed_description');

                $image = base_url() . '/assets/images/plugin_not_installed.png';
            }

            $data['plugins'][] = [
                'path' => $plugin,
                'image' => $image,
                'plugin_author' => $plugin_author,
                'plugin_name' => lang('Text.' . strtolower($plugin_name)),
                'plugin_link' => $link,
                'plugin_description' => $description,
                'plugin_image' => $image,
                'link' => $link,
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin/' . $plugin_author . '/' . $plugin_name),
                'activated' => $activated,
                'activate' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin/activate', ['plugin' => $plugin_author . ':' . $plugin_name]),
                'deactivate' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin/deactivate', ['plugin' => $plugin_author . ':' . $plugin_name]),
                'remove' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin/remove', ['plugin' => $plugin_author . ':' . $plugin_name]),
            ];
        }

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.plugins'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Plugin\plugin',
            'permission' => 'Plugin/Plugin',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function upload()
    {
        $json = [];

        if (!$this->administrator->hasPermission('access', 'Plugin/Plugin')) {
            $json['error'] = lang('Error.access_permission');
        }

        if (!$this->request->getFile('file')) {
            $json['error'] = lang('Error.file');
        }

        $file = new \CodeIgniter\Files\File($this->request->getFile('file'));

        if ($file->getMimeType() != 'application/zip') {
            $json['error'] = lang('Error.file_type');
        }

        if (empty($json['error'])) {
            $uploaded_file = $this->request->getFile('file');

            if ($uploaded_file->isValid() && !$uploaded_file->hasMoved()) {
                $newName = $uploaded_file->getRandomName();

                // Upload
                $uploaded_file->move(ROOTPATH . '/writable/uploads/', $newName);

                // Extract
                $file = ROOTPATH . '/writable/uploads/' . $newName;
                $destination = ROOTPATH . '/plugins/';
    
                $this->zip->extractTo($file, $destination, true);
    
                $json['success'] = lang('Success.upload_file');
            } else {
                $json['error'] = $uploaded_file->getErrorString() . ' ( ' . $uploaded_file->getError() . ' )';
            }
        }

        return $this->response->setJSON($json);
    }

    public function activate()
    {
        if (!$this->administrator->hasPermission('access', 'Plugin/Plugin')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('plugin'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Copy assets files
            $plugin = explode(':', $this->request->getGet('plugin'));

            $asset = ROOTPATH . 'plugins/' . $plugin[0] . '/' . $plugin[1] . '/assets';
            $destination = ROOTPATH . 'public/assets';

            if (is_dir($asset)) {
                $this->file->recursiveCopy($asset, $destination);
            }

            $query = $this->model_extension_extension->installExtension('plugin', $this->request->getGet('plugin'));

            $this->session->set('success', lang('Success.plugin_activated'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }

    public function deactivate()
    {
        if (!$this->administrator->hasPermission('access', 'Plugin/Plugin')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('plugin'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Delete installed assets files
            $plugin = explode(':', $this->request->getGet('plugin'));

            $admin_asset = ROOTPATH . 'public/assets/admin/plugins/' . $plugin[0];

            if (is_dir($admin_asset)) {
                delete_files($admin_asset, true);

                rmdir($admin_asset);
            }

            $marketplace_asset = ROOTPATH . 'public/assets/marketplace/plugins/' . $plugin[0];

            if (is_dir($marketplace_asset)) {
                delete_files($marketplace_asset, true);

                rmdir($marketplace_asset);
            }

            $query = $this->model_extension_extension->uninstallExtension('plugin', $this->request->getGet('plugin'));

            $this->session->set('success', lang('Success.plugin_deactivated'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }

    public function update()
    {
        $json = [];

        if (!$this->administrator->hasPermission('access', 'Plugin/Plugin')) {
            $json['error'] = lang('Error.access_permission');
        }

        if (!$this->request->getFile('file')) {
            $json['error'] = lang('Error.file');
        }

        $file = new \CodeIgniter\Files\File($this->request->getFile('file'));

        if ($file->getMimeType() != 'application/zip') {
            $json['error'] = lang('Error.file_type');
        }

        if (empty($this->request->getGet('plugin'))) {
            $json['error'] = lang('Error.missing_parameters');
        }

        if (empty($json['error'])) {
            $uploaded_file = $this->request->getFile('file');

            if ($uploaded_file->isValid() && !$uploaded_file->hasMoved()) {
                $newName = $uploaded_file->getRandomName();

                // Upload
                $uploaded_file->move(ROOTPATH . '/writable/uploads/', $newName);

                // Extract
                $file = ROOTPATH . '/writable/uploads/' . $newName;
                $destination = ROOTPATH . '/plugins/';
    
                $this->zip->extractTo($file, $destination, true);
        
                // Copy assets files
                $plugin = explode(':', $this->request->getGet('plugin'));

                $asset = ROOTPATH . 'plugins/' . $plugin[0] . '/' . $plugin[1] . '/assets';
                $destination = ROOTPATH . 'public/assets';

                if (is_dir($asset)) {
                    $this->file->recursiveCopy($asset, $destination);
                }

                $json['success'] = lang('Success.upload_file');
            } else {
                $json['error'] = $uploaded_file->getErrorString() . ' ( ' . $uploaded_file->getError() . ' )';
            }
        }

        return $this->response->setJSON($json);
    }

    public function remove()
    {
        if (!$this->administrator->hasPermission('access', 'Plugin/Plugin')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('plugin'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Delete installed plugin files
            $plugin = explode(':', $this->request->getGet('plugin'));

            $asset = ROOTPATH . 'plugins/' . $plugin[0] . '/' . $plugin[1];

            delete_files($asset, true);

            rmdir($asset);

            return redirect()->to(env('app.adminUrlSegment') . '/plugin/plugin?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }
}
