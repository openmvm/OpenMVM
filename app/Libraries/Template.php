<?php

namespace App\Libraries;

class Template
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
		$this->setting = new \App\Libraries\Setting;
		$this->backend_theme = new \App\Libraries\BackendTheme;
		$this->frontend_theme = new \App\Libraries\FrontendTheme;
		// Load Database
		$this->db = db_connect();
	}

  public function render($type, $dir, $data)
  {
  	// Back-end
  	$backend_default_provider = 'OpenMVM';
  	$backend_default_theme = 'ThemeDefault';

  	// Front-end
  	$frontend_default_provider = 'OpenMVM';
  	$frontend_default_theme = 'ThemeDefault';

  	if ($type == 'BackendThemes') { // Back-end
  		// Type DIR
  		$type_dir = 'backend_themes/';
  		// Backend Theme ID
  		$backend_theme_id = $this->setting->get('setting', 'setting_backend_theme');
  		// Get Backend Theme Manifest By ID
  		$backend_theme_manifest = json_decode($this->backend_theme->getManifestById($backend_theme_id), true);

  		if (!empty($backend_theme_manifest['dir']['provider'])) {
  			$dir_provider = $backend_theme_manifest['dir']['provider'];
  		} else {
  			$dir_provider = $backend_default_provider;
  		}

  		if (!empty($backend_theme_manifest['dir']['theme'])) {
  			$dir_theme = $backend_theme_manifest['dir']['theme'];
  		} else {
  			$dir_theme = $backend_default_theme;
  		}

	  	$default_provider = $backend_default_provider;
	  	$default_theme = $backend_default_theme;
  	} else { // Front-end
  		$type_dir = 'frontend_themes/';
  		// Frontend Theme ID
  		$frontend_theme_id = $this->setting->get('setting', 'setting_frontend_theme');
  		// Get Frontend Theme Manifest By ID
  		$frontend_theme_manifest = json_decode($this->frontend_theme->getManifestById($frontend_theme_id), true);

  		if (!empty($frontend_theme_manifest['dir']['provider'])) {
  			$dir_provider = $frontend_theme_manifest['dir']['provider'];
  		} else {
  			$dir_provider = $frontend_default_provider;
  		}

  		if (!empty($frontend_theme_manifest['dir']['theme'])) {
  			$dir_theme = $frontend_theme_manifest['dir']['theme'];
  		} else {
  			$dir_theme = $frontend_default_theme;
  		}

	  	$default_provider = $frontend_default_provider;
	  	$default_theme = $frontend_default_theme;
  	}

  	$selected_provider = $dir_provider;
  	$selected_theme = $dir_theme;

  	if (file_exists(ROOTPATH . $type_dir . $selected_provider . '/' . $selected_theme . '/Views/' . $dir . '.php')) {
  		$route = $type . '\\' . $selected_provider . '\\' . $selected_theme . '\\' . $dir;
  	} else {
  		$route = $type . '\\' . $default_provider . '\\' . $default_theme . '\\' . $dir;
  	}

  	$cache = array();

    return view($route, $data, $cache);
  }
}