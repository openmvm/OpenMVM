<?php

namespace Main\Admin\Controllers\Developer;

class Language_Editor extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Developer/Language_Editor')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'));
            }

            foreach ($this->request->getPost('selected') as $file) {
                // Query
                $languages = $this->model_localisation_language->getLanguages();

                foreach ($languages as $language) {
                    $path = ROOTPATH . '/app/Language/' . $language['code'] . '/' . $file . '.php';

                    unlink($path);
                }
            }

            $this->session->set('success', lang('Success.language_editor_delete'));

            return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
                $json['error'] = lang('Error.login');
            }

            $this->validation->setRule('filename', lang('Entry.filename'), 'required|alpha');

            if ($this->validation->withRequest($this->request)->run()) {
                $filename = ucwords($this->request->getPost('filename'));

                $languages = $this->model_localisation_language->getLanguages();
        
                foreach ($languages as $language) {
                    $file = ROOTPATH . '/app/Language/' . $language['code'] . '/' . $filename . '.php';
        
                    $content = '<?php' . "\n\n";
                    $content .= '// ' . $this->uri->getSegment($this->uri->getTotalSegments()) . "\n";
                    $content .= 'return [' . "\n";
                    $content .= '];' . "\n";
            
                    file_put_contents($file, $content);
                }
        
                $json['success'] = lang('Success.language_editor_add');
            } else {
                if ($this->validation->hasError('filename')) {
                    $json['error'] = $this->validation->getError('filename');
                } else {
                    $json['error'] = '';
                }

            }
        }

        return $this->response->setJSON($json);
    }

    public function edit()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        $data['sub_title'] = lang('Heading.edit') . ' - ' . $this->uri->getSegment($this->uri->getTotalSegments());

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Developer/Language_Editor')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            // Query
            $post = $this->request->getPost();

            if (!empty($post['string'])) {
                $strings = $post['string'];
            } else {
                $strings = [];
            }

            usort($strings, function($a, $b) {
                return $a['key'] <=> $b['key'];
            });

            $languages = $this->model_localisation_language->getLanguages();

            foreach ($languages as $language) {
                $file = ROOTPATH . '/app/Language/' . $language['code'] . '/' . $this->uri->getSegment($this->uri->getTotalSegments()) . '.php';

                $content = '<?php' . "\n\n";
                $content .= '// ' . $this->uri->getSegment($this->uri->getTotalSegments()) . "\n";
                $content .= 'return [' . "\n";

                foreach ($strings as $string) {
                    $content .= '    \'' . $string['key'] . '\'' . ' => ' . '\'' . addslashes($string['value'][$language['code']]) . '\',' . "\n";
                }

                $content .= '];' . "\n";

                file_put_contents($file, $content);
            }

            $this->session->set('success', lang('Success.language_editor_edit'));

            return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'));
        }

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
            'text' => lang('Text.language_editor'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'),
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

        $data['heading_title'] = lang('Heading.language_editor');

        // Get files
        $data['files'] = [];

        $directory = ROOTPATH . '/app/Language/' . $this->language->getDefaultCode() . '/';

        $files = array_diff(scandir($directory), array('..', '.'));

        foreach ($files as $file) {
            // Path info
            $pathinfo = pathinfo($file);

            $data['files'][] = [
                'file' => $pathinfo['filename'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor/edit/' . $pathinfo['filename']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.language_editor'),
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
            'view' => 'Developer\language_editor_list',
            'permission' => 'Developer/Language_Editor',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.language_editor'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'),
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

        $data['heading_title'] = lang('Heading.language_editor');

        // Get language strings
        $default_file = include(ROOTPATH . '/app/Language/' . $this->language->getDefaultCode() . '/' . $this->uri->getSegment($this->uri->getTotalSegments()) . '.php');

        $data['strings'] = $default_file;

        ksort($data['strings']);

        $languages = $this->model_localisation_language->getLanguages();

        $data['values'] = [];

        foreach ($languages as $language) {
            $file = include(ROOTPATH . '/app/Language/' . $language['code'] . '/' . $this->uri->getSegment($this->uri->getTotalSegments()) . '.php');

            $data['values'][$language['code']] = $file;
        }

        $data['languages'] = $languages;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor');

        // Header
        $header_params = array(
            'title' => lang('Heading.language_editor'),
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
            'view' => 'Developer\language_editor_form',
            'permission' => 'Developer/Language_Editor',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
