<?php namespace App\Controllers;

use App\Controllers\Header;
use App\Controllers\Menu;
use App\Controllers\Footer;
use App\Models\Install_Model;

class Install extends BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->validation = \Config\Services::validation();
		// Load Controllers
		$this->header = new Header();
		$this->menu = new Menu();
		$this->footer = new Footer();
		// Load Models
		$this->install_model = new Install_Model();
	}

	public function index()
	{
		// Check the .env file and set the app.baseURL
		$install_env_file = '../.env';
		$main_env_file = '../../../.env';
		$install_base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		$main_base_url = str_replace('install/public/', '', $install_base_url);

		if (file_exists($main_env_file) && file_exists($install_env_file)) {
			if (base_url() == 'http://localhost:8080' || base_url() == 'http://localhost:8080/') {
				$old_string = "# app.baseURL = ''";

				$new_string = "app.VERSION = '0.4.0'\napp.baseURL = '" . str_replace('install/public/', '', $install_base_url) . "'\napp.adminUrlSegment = 'admin'";

				// main_env_file
				// read the entire string
				$main_env_file_content = file_get_contents($main_env_file);

				// replace something in the file string - this is a VERY simple example
				$main_env_file_content = str_replace($old_string, $new_string, $main_env_file_content);

				// write the entire string
				file_put_contents($main_env_file, $main_env_file_content);

				// install_env_file
				// read the entire string
				$install_env_file_content = file_get_contents($install_env_file);

				// replace something in the file string - this is a VERY simple example
				$install_env_file_content = str_replace($old_string, $new_string, $install_env_file_content);

				// write the entire string
				file_put_contents($install_env_file, $install_env_file_content);

				return redirect()->to($install_base_url);
			}
		} else {
			return redirect()->to($install_base_url . 'env');
		}

  		// Variables
		$data['heading_title'] = lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US');

		// Get Models

		// Get Locale
		$data['front_locale'] = 'en-US';

		// Load Header
		$header_parameter = array(
			'title' => lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US'),
			'front_locale' => 'en-US',
		);
		$data['header'] = $this->header->index($header_parameter);

		// Load Menu
		$menu_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['menu'] = $this->menu->index($menu_parameter);

		// Load Footer
		$footer_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['footer'] = $this->footer->index($footer_parameter);

		// View
		echo view('install', $data);
	}

	public function licenseAgreement()
	{
		if ($this->request->getMethod() == 'post') {
			$this->validate([
				'license_agreement' => ['label' => lang('Entry.entry_license_agreement', array(), 'en-US'), 'rules' => 'greater_than[0]', 'errors' => ['greater_than' => lang('Error.error_license_agreement', array(), 'en-US')]],
			]);
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
			return redirect()->to(base_url('install/public/pre_installation'));
		}

  		// Variables
		$data['heading_title'] = lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US');

		// Get license
		$data['license'] = nl2br(file_get_contents( '../../../LICENSE' ));

		// Get Locale
		$data['front_locale'] = 'en-US';

		$data['validation'] = $this->validation;

		// Load Header
		$header_parameter = array(
			'title' => lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US'),
			'front_locale' => 'en-US',
		);
		$data['header'] = $this->header->index($header_parameter);

		// Load Menu
		$menu_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['menu'] = $this->menu->index($menu_parameter);

		// Load Footer
		$footer_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['footer'] = $this->footer->index($footer_parameter);

		// View
		echo view('install_license_agreement', $data);
	}

	public function preInstallation()
	{
		if ($this->request->getMethod() == 'post') {
			if (phpversion() < '7.3' || 
				!extension_loaded('intl') || 
				!extension_loaded('curl') || 
				!extension_loaded('json') || 
				!extension_loaded('mbstring') || 
				!extension_loaded('mysqlnd') || 
				!extension_loaded('xml') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '.env') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../') . '/') . '.env') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'plugins/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_admin/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_marketplace/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/cache/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/downloads/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/logs/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/temp/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/uploads/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/admin/theme/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '/public/assets/images/marketplace/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '/public/assets/images/cache/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '/public/assets/images/') || 
				!is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/marketplace/theme/')) {

				$this->session->set('error', lang('Error.error_pre_installation', array(), 'en-US'));

				return redirect()->to(base_url('install/public/pre_installation'));
			} else {
				return redirect()->to(base_url('install/public/configuration'));
			}
		}

  		// Variables
		$data['heading_title'] = lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US');

		// PHP Version
		$data['php_version'] = phpversion();

		// PHP Extensions
		$data['intl'] = extension_loaded('intl');
		$data['curl'] = extension_loaded('curl');
		$data['json'] = extension_loaded('json');
		$data['mbstring'] = extension_loaded('mbstring');
		$data['mysqlnd'] = extension_loaded('mysqlnd');
		$data['xml'] = extension_loaded('xml');

		// Files & Directories
		$data['directories'] = array(
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '.env',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . '.env'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../') . '/') . '.env',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../') . '/') . '.env'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'plugins/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'plugins/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_admin/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_admin/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_marketplace/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'theme_marketplace/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/cache/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/cache/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/downloads/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/downloads/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/logs/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/logs/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/temp/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/temp/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/uploads/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'writable/uploads/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/admin/theme/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/admin/theme/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/marketplace/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/marketplace/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/cache/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/cache/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/images/'),
			),
			array(
				'path' => str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/marketplace/theme/',
				'writable' => is_writable(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../../') . '/') . 'public/assets/marketplace/theme/'),
			),
		);

		usort($data['directories'], function ($item1, $item2) {
		    return $item1['path'] <=> $item2['path'];
		});

		// Get Locale
		$data['front_locale'] = 'en-US';

		// Load Header
		$header_parameter = array(
			'title' => lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US'),
			'front_locale' => 'en-US',
		);
		$data['header'] = $this->header->index($header_parameter);

		// Load Menu
		$menu_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['menu'] = $this->menu->index($menu_parameter);

		// Load Footer
		$footer_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['footer'] = $this->footer->index($footer_parameter);

		// View
		echo view('install_pre_installation', $data);
	}

	public function configuration()
	{
		$data = array();

		// Server Configuration
		if($this->request->getPost('db_driver')) {
			$data['db_driver'] = $this->request->getPost('db_driver');
		} else {
			$data['db_driver'] = '';
		}

		if($this->request->getPost('hostname')) {
			$data['hostname'] = $this->request->getPost('hostname');
		} else {
			$data['hostname'] = 'localhost';
		}

		if($this->request->getPost('db_username')) {
			$data['db_username'] = $this->request->getPost('db_username');
		} else {
			$data['db_username'] = 'root';
		}

		if($this->request->getPost('db_password')) {
			$data['db_password'] = $this->request->getPost('db_password');
		} else {
			$data['db_password'] = '';
		}

		if($this->request->getPost('database')) {
			$data['database'] = $this->request->getPost('database');
		} else {
			$data['database'] = '';
		}

		if($this->request->getPost('db_prefix')) {
			$data['db_prefix'] = $this->request->getPost('db_prefix');
		} else {
			$data['db_prefix'] = '';
		}

		// Administrator
		if($this->request->getPost('firstname')) {
			$data['firstname'] = $this->request->getPost('firstname');
		} else {
			$data['firstname'] = '';
		}

		if($this->request->getPost('lastname')) {
			$data['lastname'] = $this->request->getPost('lastname');
		} else {
			$data['lastname'] = '';
		}

		if($this->request->getPost('email')) {
			$data['email'] = $this->request->getPost('email');
		} else {
			$data['email'] = '';
		}

		if($this->request->getPost('username')) {
			$data['username'] = $this->request->getPost('username');
		} else {
			$data['username'] = '';
		}

		if($this->request->getPost('admin_url_segment')) {
			$data['admin_url_segment'] = $this->request->getPost('admin_url_segment');
		} else {
			$data['admin_url_segment'] = 'admin';
		}

		$data['validation'] = $this->validation;

		// DB Drivers
		$data['mysqli'] = extension_loaded('mysqli');
	
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'db_driver' => ['label' => lang('Entry.entry_db_driver', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'hostname' => ['label' => lang('Entry.entry_hostname', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'db_username' => ['label' => lang('Entry.entry_db_username', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'database' => ['label' => lang('Entry.entry_database', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'email' => ['label' => lang('Entry.entry_email', array(), 'en-US'), 'rules' => 'required|valid_email', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US'), 'valid_email' => lang('Error.error_invalid', array(), 'en-US')]],
				'username' => ['label' => lang('Entry.entry_username', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'password' => ['label' => lang('Entry.entry_password', array(), 'en-US'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US')]],
				'passconf' => ['label' => lang('Entry.entry_passconf', array(), 'en-US'), 'rules' => 'required|matches[password]', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US'), 'matches' => lang('Error.error_matches', array(), 'en-US')]],
				'admin_url_segment' => ['label' => lang('Entry.entry_admin_url_segment', array(), 'en-US'), 'rules' => 'required|alpha_numeric', 'errors' => ['required' => lang('Error.error_required', array(), 'en-US'),'alpha_numeric' => lang('Error.error_alpha_numeric', array(), 'en-US')]],
			]);
		}

		if (!empty($validate)) {
			// Connect DB
			$connect_db = $this->install_model->connectDb($this->request->getPost());

			if ($connect_db) {
				// Database Configuration
				$configure_database = $this->install_model->configureDatabase($this->request->getPost());

				if ($configure_database) {
					// Import SQL file
					$import_sql_file = $this->install_model->importSqlFile($this->request->getPost());

					if ($import_sql_file) {
						// Add Administrator
						$add_administrator = $this->install_model->addAdministrator($this->request->getPost());

						if ($add_administrator) {
							// $this->session->set('success', lang('Success.success_install', array(), 'en-US'));

							// Check the .env file and set the app.adminDir
							$install_env_file = '../.env';
							$main_env_file = '../../../.env';

							$old_string = "app.adminUrlSegment = 'admin'";

							$new_string = "app.adminUrlSegment = '" . $this->request->getPost('admin_url_segment') . "'";

							// main_env_file
							// read the entire string
							$main_env_file_content = file_get_contents($main_env_file);

							// replace something in the file string - this is a VERY simple example
							$main_env_file_content = str_replace($old_string, $new_string, $main_env_file_content);

							// write the entire string
							file_put_contents($main_env_file, $main_env_file_content);

							// install_env_file
							// read the entire string
							$install_env_file_content = file_get_contents($install_env_file);

							// replace something in the file string - this is a VERY simple example
							$install_env_file_content = str_replace($old_string, $new_string, $install_env_file_content);

							// write the entire string
							file_put_contents($install_env_file, $install_env_file_content);

							return redirect()->to(base_url('install/public/finish'));
						} else {
							$this->session->set('error', lang('Error.error_add_administrator', array(), 'en-US'));

							return redirect()->to(base_url('install/public/configuration'));
						}
					} else {
						$this->session->set('error', lang('Error.error_import_sql_file', array(), 'en-US'));

						return redirect()->to(base_url('install/public/configuration'));
					}
				} else {
					$this->session->set('error', lang('Error.error_configure_database', array(), 'en-US'));

					return redirect()->to(base_url('install/public/configuration'));
				}
			} else {
				$this->session->set('error', lang('Error.error_connect_database'));

				return redirect()->to(base_url('install/public/configuration'));
			}
		}

  		// Variables
		$data['heading_title'] = lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US');

		// Get Models

		// Get Locale
		$data['front_locale'] = 'en-US';

		// Load Header
		$header_parameter = array(
			'title' => lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US'),
			'front_locale' => 'en-US',
		);
		$data['header'] = $this->header->index($header_parameter);

		// Load Menu
		$menu_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['menu'] = $this->menu->index($menu_parameter);

		// Load Footer
		$footer_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['footer'] = $this->footer->index($footer_parameter);

		// View
		echo view('install_configuration', $data);
	}

	public function finish()
	{
  		// Variables
		$data['heading_title'] = lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US');

		// Get Models

		// Get Locale
		$data['front_locale'] = 'en-US';

		// Data Text
		$data['admin_dir'] = $_SERVER['app.adminUrlSegment'];

		// Load Header
		$header_parameter = array(
			'title' => lang('Text.text_openmvm', array(), 'en-US') . ' - ' . lang('Heading.heading_installation', array(), 'en-US'),
			'front_locale' => 'en-US',
		);
		$data['header'] = $this->header->index($header_parameter);

		// Load Menu
		$menu_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['menu'] = $this->menu->index($menu_parameter);

		// Load Footer
		$footer_parameter = array(
			'front_locale' => 'en-US',
		);
		$data['footer'] = $this->footer->index($footer_parameter);

		// View
		echo view('install_finish', $data);
	}

	//--------------------------------------------------------------------

}
