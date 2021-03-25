<?php

namespace Modules\OpenMVM\Filemanager\Controllers\BackEnd;

class Filemanager extends \App\Controllers\BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/filemanager');

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

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_filemanager', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/filemanager/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_filemanager', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_filemanager_lead', array(), $this->language->getBackEndLocale());

		// Data Form

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_filemanager', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Filemanager/Controllers/BackEnd/Filemanager')) {
			echo $this->template->render('BackendThemes', 'Filemanager\filemanager', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getWorkspace($data = array())
	{
		// Data Libraries
		$data['lang'] = $this->language;

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Filemanager/Controllers/BackEnd/Filemanager')) {
			echo $this->template->render('BackendThemes', 'Filemanager\filemanager_workspace', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getPopUp($data = array())
	{
		// Data Libraries
		$data['lang'] = $this->language;

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Filemanager/Controllers/BackEnd/Filemanager')) {
			echo $this->template->render('BackendThemes', 'Filemanager\filemanager_popup', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}

	public function getContents($data = array())
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    if (!$json['error']) {
	    // Files directory
	    if ($this->request->getPost('path') !== null) {
				$directory = rtrim(ROOTPATH . 'public/assets/files/' . str_replace('*', '', $this->request->getPost('path')), '/');
			} else {
				$directory = ROOTPATH . 'public/assets/files';
			}

	    // Get directories
	    $directories = glob($directory . '/*', GLOB_ONLYDIR);

	    if (!$directories) {
	      $directories = array();
	    }

	    // Get files
	    $files = glob($directory . '/*.{jpg,jpeg,png,gif,mp3,mp4,pdf,zip,doc,docx,xls,xlsx,ppt,pptx,JPG,JPEG,PNG,GIF,MP3,MP4,PDF,ZIP,DOC,DOCX,XLS,XLSX,PPT,PPTX}', GLOB_BRACE);

	    if (!$files) {
	      $files = array();
	    }

	    // Get directory before
	    if ($this->request->getPost('path') !== null) {
	      $pos = strrpos($this->request->getPost('path'), '/');

				if ($pos) {
					$json['directory'] = substr($this->request->getPost('path'), 0, $pos);
				}
	      $json['path'] = $this->request->getPost('path');
	    } else {
	      $json['directory'] = null;
	      $json['path'] = '';
	    }

			// Merge directories and files
			$contents = array_merge($directories, $files);

			foreach ($contents as $content) {
				$name = str_split(basename($content), 12);

				if (is_dir($content)) {
					$json['contents'][] = array(
						'thumb'    => '',
						'content'  => $content,
						'basename' => basename($content),
						'type'     => 'directory',
						'name'     => implode(' ', $name),
						'source'   => '',
						'path'     => substr($content, strlen(ROOTPATH . 'public/assets/files/')),
					);
				} elseif (is_file($content)) {
					$ext = strtolower(pathinfo(basename($content), PATHINFO_EXTENSION));

					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$mime_type = 'image';
						$thumb = $this->image->resize(str_replace(ROOTPATH . 'public/assets/files/', '', $content), 150, 150, true, 'auto');
					} elseif ($ext == 'mp3') {
						$mime_type = 'audio';
						$thumb = '';
					} elseif ($ext == 'mp4') {
						$mime_type = 'video';
						$thumb = '';
	        } elseif ($ext == 'pdf') {
	          $mime_type = 'pdf';
						$thumb = '';
					} elseif ($ext == 'zip') {
	          $mime_type = 'archive';
						$thumb = '';
					} elseif ($ext == 'doc' || $ext == 'docx') {
	          $mime_type = 'word';
						$thumb = '';
					} elseif ($ext == 'xls' || $ext == 'xlsx') {
	          $mime_type = 'excel';
						$thumb = '';
					} elseif ($ext == 'ppt' || $ext == 'pptx') {
	          $mime_type = 'powerpoint';
						$thumb = '';
					} else {
	          $mime_type = 'document';
						$thumb = '';
					}

					$json['contents'][] = array(
						'thumb'    => $thumb,
						'content'  => $content,
						'basename' => basename($content),
						'type'     => $mime_type,
						'name'     => implode(' ', $name),
						'source'   => base_url('assets/files/' . substr($content, strlen(ROOTPATH . 'public/assets/files/'))),
						'path'     => substr($content, strlen(ROOTPATH . 'public/assets/files/')),
					);
				} else {
	        $json['contents'][] = array();
	      }

			}
    }

    return $this->response->setJSON($json);
	}
	
	public function createDirectory()
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    // Make sure we have the correct directory
    if ($this->request->getPost('path') !== null) {
			$directory = rtrim(ROOTPATH . 'public/assets/files/' . str_replace('*', '', $this->request->getPost('path')), '/');
		} else {
			$directory = ROOTPATH . 'public/assets/files/';
		}

		if ($this->request->getPost('path') !== null) {
    	$folder = basename(html_entity_decode($this->request->getPost('folder_name'), ENT_QUOTES, 'UTF-8'));

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = lang('Error.error_directory_exists', array(), $this->language->getBackEndLocale());
			}
		}

		if (!$json['error']) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);

			@touch($directory . '/' . $folder . '/' . 'index.html');

			$json['success'] = lang('Success.success_new_folder', array(), $this->language->getBackEndLocale());
		}

    return $this->response->setJSON($json);
	}
	
	public function upload()
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    if (!$json['error']) {
	    // Make sure we have the correct directory
	    if ($this->request->getPost('path') !== null) {
				$directory = rtrim(ROOTPATH . 'public/assets/files/' . str_replace('*', '', $this->request->getPost('path')), '/');
			} else {
				$directory = ROOTPATH . 'public/assets/files/';
			}

			if($imagefile = $this->request->getFiles())
			{
				foreach($imagefile['file'] as $img)
				{
					if ($img->isValid() && ! $img->hasMoved())
					{
						$img->move($directory);
					}
				}
			}

	    $json['path'] = $this->request->getPost('path');
    }

    return $this->response->setJSON($json);
	}
	
	public function compress()
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    if ($this->request->getPost('selected') == null) {
			$json['error'] = lang('Error.error_select_file', array(), $this->language->getBackEndLocale());
    }

    if (!$json['error']) {
	    helper('filesystem');

			if ($this->request->getPost('selected') !== null) {
				$paths = $this->request->getPost('selected');
			} else {
				$paths = array();
			}

			$current_datetime = date("YmdHis", now());

			$this->pclzip->PclZip(ROOTPATH . 'writable/temp/' . 'archive-' . $current_datetime . '.zip');

	    foreach ($paths as $path) {
	    	$compressed_files[] = ROOTPATH . 'public/assets/files/' . $path;
	    }

	    $compressed = implode(',', $compressed_files);

	    if ($this->pclzip->create($compressed, PCLZIP_OPT_REMOVE_PATH, ROOTPATH . 'public/assets/files/', PCLZIP_OPT_ADD_PATH, $current_datetime) == 0) {
	    	$json['error'] = $this->pclzip->errorInfo(true);
	    } else {
	    	$json['success'] = ROOTPATH . 'writable/temp/' . 'archive-' . $current_datetime . '.zip';
	    }
			
  	}

    return $this->response->setJSON($json);
	}
	
	public function download()
	{
		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

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
	
	public function clearCache()
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    if (!$json['error']) {
	    helper('filesystem');

	    delete_files(ROOTPATH . 'public/assets/cache/');

			@touch(ROOTPATH . 'public/assets/cache/' . 'index.html');
		}

    return $this->response->setJSON($json);
	}
	
	public function delete()
	{
    $json = array();

		// Check CSRF Token
		$headers = apache_request_headers();

		if ($headers['Csrf-Token'] !== null) {
			$csrf_token = $headers['Csrf-Token'];
		} elseif ($headers['csrf-token'] !== null) {
			$csrf_token = $headers['csrf-token'];
		} else {
			$csrf_token = false;
		}

    if (!$json['error']) {
	    helper('filesystem');

			if ($this->request->getPost('selected') !== null) {
				$paths = $this->request->getPost('selected');
			} else {
				$paths = array();
			}

	    foreach ($paths as $path) {
	      if(is_file(ROOTPATH . 'public/assets/files/' . $path)) {
	        unlink(ROOTPATH . 'public/assets/files/' . $path);
	      } elseif(is_dir(ROOTPATH . 'public/assets/files/' . $path)) {
	        delete_files(ROOTPATH . 'public/assets/files/' . $path, TRUE);
	        rmdir(ROOTPATH . 'public/assets/files/' . $path);
	      }
	    }
  	}

    return $this->response->setJSON($json);
	}
}
