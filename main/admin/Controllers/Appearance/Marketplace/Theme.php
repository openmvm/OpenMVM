<?php

namespace Main\Admin\Controllers\Appearance\Marketplace;

class Theme extends \App\Controllers\BaseController
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
            'text' => lang('Text.marketplace_themes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.themes');

        // Get marketplace themes
        $path = ROOTPATH . '/theme_marketplace/*/*/Controllers/Admin/Appearance/Marketplace/Theme/*/*';

        $themes = array_diff(glob($path), array('.', '..'));

        foreach ($themes as $theme) {
            $segment = explode('/', $theme);
            $total_segments = count($segment);

            $theme_author = $segment[$total_segments - 2];
            $theme_name = pathinfo($segment[$total_segments - 1], PATHINFO_FILENAME);

            // Check if it is installed
            $extension_info = $this->model_extension_extension->getInstalledExtension('theme_marketplace', $theme_author . ':' . $theme_name);

            if ($extension_info) {
                $activated = true;

                $info = file_get_contents($this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/' . strtolower($theme_author) . '/' . strtolower($theme_name) . '/get_info'));

                $theme_info = json_decode($info, true);

                if (!empty($theme_info['link'])) {
                    $link = $theme_info['link'];
                } else {
                    $link = false;
                }

                if (!empty($theme_info['description'])) {
                    $description = $theme_info['description'];
                } else {
                    $description = false;
                }

                if (!empty($theme_info['image'])) {
                    $image = $theme_info['image'];
                } else {
                    $image = false;
                }
            } else {
                $activated = false;

                $link = false;

                $description = lang('Text.theme_not_installed_description');

                $image = base_url() . '/assets/images/theme_not_installed.png';
            }

            $data['themes'][] = [
                'path' => $theme,
                'image' => $image,
                'theme_author' => $theme_author,
                'theme_name' => $theme_name,
                'theme_link' => $link,
                'theme_description' => $description,
                'theme_image' => $image,
                'link' => $link,
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/' . strtolower($theme_author) . '/' . strtolower($theme_name)),
                'activated' => $activated,
                'activate' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/activate', ['theme' => $theme_author . ':' . $theme_name]),
                'deactivate' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/deactivate', ['theme' => $theme_author . ':' . $theme_name]),
                'set' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/set_marketplace_theme', ['theme' => $theme_author . ':' . $theme_name]),
                'remove' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme/remove', ['theme' => $theme_author . ':' . $theme_name]),
            ];
        }

        $data['current_theme'] = $this->setting->get('setting_marketplace_theme');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.themes'),
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
            'view' => 'Appearance\Marketplace\theme',
            'permission' => 'Appearance/Marketplace/Theme',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function upload()
    {
        $json = [];

        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            $json['error'] = lang('Error.login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
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
                $destination = ROOTPATH . '/theme_marketplace/';
    
                $this->zip->extractTo($file, $destination, true);
    
                $json['success'] = lang('Success.upload_file');
            } else {
                $json['error'] = $uploaded_file->getErrorString() . ' ( ' . $uploaded_file->getError() . ' )';
            }
        }

        return $this->response->setJSON($json);
    }

    public function set_marketplace_theme()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token') . '&error=error_permission');
        }

        if (empty($this->request->getGet('theme'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token') . '&error=error_theme');
        }

        if (empty($error)) {
            $query = $this->model_system_setting->editSettingValue('setting', 'setting_marketplace_theme', $this->request->getGet('theme'));

            $this->session->set('success', lang('Success.theme_applied'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token') . '&error=none');
        }
    }

    public function activate()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('theme'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Copy assets files
            $theme = explode(':', $this->request->getGet('theme'));

            $asset = ROOTPATH . 'theme_marketplace/' . $theme[0] . '/' . $theme[1] . '/assets';
            $destination = ROOTPATH . 'public/assets';

            if (is_dir($asset)) {
                $this->file->recursiveCopy($asset, $destination);
            }

            $query = $this->model_extension_extension->installExtension('theme_marketplace', $this->request->getGet('theme'));

            $this->session->set('success', lang('Success.theme_activated'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }

    public function deactivate()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('theme'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Delete installed assets files
            $theme = explode(':', $this->request->getGet('theme'));

            $asset = ROOTPATH . 'public/assets/marketplace/theme/' . $theme[0];

            if (is_dir($asset)) {
                delete_files($asset, true);

                rmdir($asset);
            }

            $query = $this->model_extension_extension->uninstallExtension('theme_marketplace', $this->request->getGet('theme'));

            $this->session->set('success', lang('Success.theme_deactivated'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }

    public function update()
    {
        $json = [];

        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            $json['error'] = lang('Error.login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            $json['error'] = lang('Error.access_permission');
        }

        if (!$this->request->getFile('file')) {
            $json['error'] = lang('Error.file');
        }

        $file = new \CodeIgniter\Files\File($this->request->getFile('file'));

        if ($file->getMimeType() != 'application/zip') {
            $json['error'] = lang('Error.file_type');
        }

        if (empty($this->request->getGet('theme'))) {
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
                $destination = ROOTPATH . '/theme_marketplace/';
    
                $this->zip->extractTo($file, $destination, true);
        
                // Copy assets files
                $theme = explode(':', $this->request->getGet('theme'));

                $asset = ROOTPATH . 'theme_marketplace/' . $theme[0] . '/' . $theme[1] . '/assets';
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
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if (!$this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            $error = true;

            $this->session->set('error', lang('Error.access_permission'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($this->request->getGet('theme'))) {
            $error = true;

            $this->session->set('error', lang('Error.missing_parameters'));

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }

        if (empty($error)) {
            // Delete installed theme files
            $theme = explode(':', $this->request->getGet('theme'));

            $asset = ROOTPATH . 'theme_marketplace/' . $theme[0] . '/' . $theme[1];

            delete_files($asset, true);

            rmdir($asset);

            return redirect()->to(env('app.adminUrlSegment') . '/appearance/marketplace/theme?administrator_token=' . $this->request->getGet('administrator_token'));
        }
    }
}
