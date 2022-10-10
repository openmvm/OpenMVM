<?php

namespace Main\Admin\Controllers\File_Manager;

class Image_Manager extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.image_manager'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.image_manager');

        $data['image_manager_workspace'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/workspace');

        // Header
        $header_params = array(
            'title' => lang('Heading.image_manager'),
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
            'view' => 'File_Manager\image_manager',
            'permission' => 'File_Manager/Image_Manager',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function workspace()
    {
        $data['create_directory'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/create_directory');
        $data['upload'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/upload');
        $data['compress'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/compress');
        $data['download'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/download');
        $data['rebuild_cache'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/rebuild_cache');
        $data['refresh'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/refresh');
        $data['remove'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager/remove');

        // Header
        $header_params = array(
            'title' => lang('Heading.image_manager'),
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
            'view' => 'File_Manager\image_manager_workspace',
            'permission' => 'File_Manager/Image_Manager',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function create_directory()
    {
        $json = [];

        $error = '';

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('folder_name', lang('Entry.folder_name'), 'required|alpha_dash|min_length[1]|max_length[24]');

            if ($this->validation->withRequest($this->request)->run()) {
                if (!empty($this->request->getGet('current_dir'))) {
                    $current_dir = $this->request->getGet('current_dir') . '/';
                } else {
                    $current_dir = '';
                }

                $folder_name = $this->request->getPost('folder_name');

                $dir = ROOTPATH . 'public/assets/images/marketplace/' . $current_dir . $folder_name;

                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                    file_put_contents($dir . '/' . 'index.html', '');

                    $json['success'] = lang('Success.directory_create');
                } else {
                    $json['error'] = lang('Error.directory_exists');
                }
            } else {
                if ($this->validation->hasError('folder_name')) {
                    $json['error'] = $this->validation->getError('folder_name');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function upload()
    {
        $json = [];

        if (!empty($this->request->getGet('current_dir'))) {
            $current_dir = $this->request->getGet('current_dir') . '/';
        } else {
            $current_dir = '';
        }

        $dir_image = ROOTPATH . 'public/assets/images/marketplace/' . $current_dir;

        $imagefile = $this->request->getFiles();

        foreach ($imagefile['file'] as $img) {
            $newName = $img->getRandomName();

            if (!$img->hasMoved()) {
                $img->move($dir_image);
            }
        }

        return $this->response->setJSON($json);
    }

    public function compress()
    {
        $json = [];

        if (!empty($this->request->getGet('current_dir'))) {
            $current_dir = $this->request->getGet('current_dir') . '/';
        } else {
            $current_dir = '';
        }

        $dir_image = ROOTPATH . 'public/assets/images/marketplace/' . $current_dir;

        $files = $this->request->getPost('filename');

        foreach ($files as $file) {
            $zip_files[] = $dir_image . $file;
        }

        $zip_date = date('YmdHis');

        $zip_name = ROOTPATH . 'writable/temp/' . 'image_manager' . '_' . $zip_date . '.zip';

        $this->zip->zipIt($zip_name, $zip_files);

        $json['archive'] = $zip_name;

        return $this->response->setJSON($json);
    }

    public function download()
    {
        if ($this->request->getGet('archive') !== null && $this->request->getPost('archive') !== '') {
            // Get Archive Data
            $file_content = file_get_contents($this->request->getGet('archive')); 
            $name = basename($this->request->getGet('archive'));
            // If File Exists
            if (file_exists($this->request->getGet('archive'))) {
                // Delete the Archive
                unlink($this->request->getGet('archive'));
                // Download it!
                return $this->response->download($name, $file_content);
            }
        }
    }

    public function rebuild_cache()
    {
        $json = [];

        $cache_dir = ROOTPATH . 'public/assets/images/cache/';

        delete_files($cache_dir, true);

        file_put_contents($cache_dir . 'index.html', '');

        return $this->response->setJSON($json);
    }

    public function refresh()
    {
        $json = [];

        $json['contents'] = [];

        if (!empty($this->request->getGet('current_dir'))) {
            $current_dir = $this->request->getGet('current_dir') . '/';
        } else {
            $current_dir = '';
        }

        $image_dir = ROOTPATH . 'public/assets/images/marketplace/' . $current_dir;

        $contents = scandir($image_dir);

        $contents = array_diff($contents, array('..', '.'));

        foreach ($contents as $content) {
            $path = $image_dir . $content;

            if (strlen($content) > 16) {
                $name = substr($content, 0, 16) . '...';
            } else {
                $name = $content;
            }

            if (is_file($path)) {
                $file_info = get_file_info($path, ['name', 'size', 'date']);

                $mime_type = mime_content_type($path);

                if ($mime_type == 'image/gif' || $mime_type == 'image/jpeg' || $mime_type == 'image/png') {
                    $json['contents'][] = [
                        'path' => $path,
                        'type' => 'file',
                        'fullname' => $content,
                        'name' => $name,
                        'thumb' => $this->image->resize(str_replace(ROOTPATH . 'public/assets/images/' , '', $image_dir . $content), 100, 100, true),
                        'size' => round(filesize($path) / 1024),
                        'mime_type' => $mime_type,
                        'date' => date(lang('Common.datetime_format'), $file_info['date']),
                        'dir_path' => str_replace('//', '/', 'marketplace/' . $current_dir . $content),
                    ];
                }
            } else {
                $json['contents'][] = [
                    'path' => $path,
                    'type' => 'directory',
                    'fullname' => $content,
                    'name' => $name,
                    'thumb' => null,
                    'size' => round($this->calculate_dir_size($path) / 1024),
                    'mime_type' => 'directory',
                    'date' => date(lang('Common.datetime_format'), filectime($path)),
                    'dir_path' => str_replace('//', '/', 'marketplace/' . $current_dir . $content),
                ];
            }

        }

        $sort_order = array();

        foreach ($json['contents'] as $key => $row)
        {
            $sort_order[$key] = $row['type'];
        }

        array_multisort($sort_order, SORT_ASC, $json['contents']);

        return $this->response->setJSON($json);
    }

    public function remove()
    {
        $json = [];

        if (!empty($this->request->getGet('current_dir'))) {
            $current_dir = $this->request->getGet('current_dir') . '/';
        } else {
            $current_dir = '';
        }

        $dir_image = ROOTPATH . 'public/assets/images/marketplace/' . $current_dir;

        $files = $this->request->getPost('filename');

        foreach ($files as $file) {
            if (is_file($dir_image . $file)) {
                unlink($dir_image . $file);
            } elseif (is_dir($dir_image . $file)) {
                delete_files($dir_image . $file, true);
                rmdir($dir_image . $file);
            }
        }

        return $this->response->setJSON($json);
    }

    function calculate_dir_size($path){
        $bytestotal = 0;

        $path = realpath($path);

        if($path!==false && $path!='' && file_exists($path))
        {
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $object)
            {
                $bytestotal += $object->getSize();
            }
        }

        return $bytestotal;
    }
}
