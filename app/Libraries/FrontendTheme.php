<?php

namespace App\Libraries;

class FrontendTheme
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
		$this->setting = new \App\Libraries\Setting;
	}

  public function getCode()
  {
    return str_replace('-', '_', $this->setting->get('setting', 'setting_frontend_theme'));
	}

  public function getThemeSettings()
  {
		// Get modules
		$directories = glob(ROOTPATH . 'modules/*/FrontendTheme', GLOB_ONLYDIR);

    if (!$directories) {
      $directories = array();
    }

  	// Get Manifests
    $manifests = array();

    foreach ($directories as $directory) {
    	if (file_exists($directory . '/manifest.json')) {
    		$manifests[] = file_get_contents($directory . '/manifest.json');
  		}
    }

    $settings = array();

  	$theme_settings = array();

  	foreach ($manifests as $manifest) {
    	$json = json_decode($manifest, true);

  		if (!empty($json['theme_settings'])) {
  			foreach ($json['theme_settings'] as $json_theme_settings) {
  				$theme_settings[] = $json_theme_settings;
  			}
  		}
  	}

  	foreach ($theme_settings as $theme_setting) {
  		// Check if the setting file exists
  		if (is_file(ROOTPATH . 'modules/' . $theme_setting ['provider'] . '/FrontendTheme/Controllers/BackEnd/'. $theme_setting ['dir'] .'.php')) {
	  		$settings[] = array(
					'name' => $theme_setting ['name'],
					'provider' => $theme_setting ['provider'],
					'dir' => $theme_setting ['dir'],
					'uri_string' => $theme_setting ['uri_string'],
	  		);
  		}
  	}

    return $settings;
	}

  public function getThemes()
  {
  	// Get Manifests
  	$manifests = $this->getManifests();

  	$themes = array();

  	foreach ($manifests as $manifest) {
    	$json = json_decode($manifest, true);

  		if (!empty($json['id'])) {
  			$id = $json['id'];
  		} else {
  			$id = '';
  		}

  		if (!empty($json['name'][$this->language->getFrontEndLocale()])) {
  			$name = $json['name'][$this->language->getFrontEndLocale()];
  		} else {
  			$name = '';
  		}

  		if (!empty($json['short_name'][$this->language->getFrontEndLocale()])) {
  			$short_name = $json['short_name'][$this->language->getFrontEndLocale()];
  		} else {
  			$short_name = '';
  		}

  		if (!empty($json['description'][$this->language->getFrontEndLocale()])) {
  			$description = $json['description'][$this->language->getFrontEndLocale()];
  		} else {
  			$description = '';
  		}

  		if (!empty($json['short_description'][$this->language->getFrontEndLocale()])) {
  			$short_description = $json['short_description'][$this->language->getFrontEndLocale()];
  		} else {
  			$short_description = '';
  		}

  		if (!empty($json['dir']['provider'])) {
  			$dir_provider = $json['dir']['provider'];
  		} else {
  			$dir_provider = '';
  		}

  		if (!empty($json['dir']['theme'])) {
  			$dir_theme = $json['dir']['theme'];
  		} else {
  			$dir_theme = '';
  		}

  		$themes[] = array(
  			'id' => $id,
  			'name' => $name,
  			'short_name' => $short_name,
  			'description' => $description,
  			'short_description' => $short_description,
  			'dir_provider' => $dir_provider,
  			'dir_theme' => $dir_theme,
  		);
  	}

    return $themes;
  }

  public function getManifestById($id)
  {
  	$manifest_data = false;

  	// Get Manifests
  	$manifests = $this->getManifests();

  	foreach ($manifests as $manifest) {
    	$json = json_decode($manifest, true);

    	if (!empty($json['id']) && $json['id'] == $id) {
    		$manifest_data = $manifest;
    	}
  	}

    return $manifest_data;
  }

  public function getManifests()
  {
		// Get modules
		$directories = $this->getDirectories();

    $manifests = array();

    foreach ($directories as $directory) {
    	if (file_exists($directory . '/manifest.json')) {
    		$manifests[] = file_get_contents($directory . '/manifest.json');
  		}
    }

    return $manifests;
  }

  public function getDirectories()
  {
		// Get modules
		$directories = glob(ROOTPATH . 'frontend_themes/*/*', GLOB_ONLYDIR);

    if (!$directories) {
      $directories = array();
    }

    return $directories;
  }
}