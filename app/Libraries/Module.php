<?php

namespace App\Libraries;

class Module
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
	}

  public function getModules()
  {
  	// Get Manifests
  	$manifests = $this->getManifests();

  	$modules = array();

  	foreach ($manifests as $manifest) {
    	$json = json_decode($manifest, true);

  		if (!empty($json['id'])) {
  			$id = $json['id'];
  		} else {
  			$id = '';
  		}

  		if (!empty($json['name'][$this->language->getBackEndLocale()])) {
  			$name = $json['name'][$this->language->getBackEndLocale()];
  		} else {
  			$name = '';
  		}

  		if (!empty($json['short_name'][$this->language->getBackEndLocale()])) {
  			$short_name = $json['short_name'][$this->language->getBackEndLocale()];
  		} else {
  			$short_name = '';
  		}

  		if (!empty($json['description'][$this->language->getBackEndLocale()])) {
  			$description = $json['description'][$this->language->getBackEndLocale()];
  		} else {
  			$description = '';
  		}

  		if (!empty($json['short_description'][$this->language->getBackEndLocale()])) {
  			$short_description = $json['short_description'][$this->language->getBackEndLocale()];
  		} else {
  			$short_description = '';
  		}

  		if (!empty($json['dir']['provider'])) {
  			$dir_provider = $json['dir']['provider'];
  		} else {
  			$dir_provider = '';
  		}

  		if (!empty($json['dir']['module'])) {
  			$dir_module = $json['dir']['module'];
  		} else {
  			$dir_module = '';
  		}

  		$modules[] = array(
  			'id' => $id,
  			'name' => $name,
  			'short_name' => $short_name,
  			'description' => $description,
  			'short_description' => $short_description,
  			'dir_provider' => $dir_provider,
  			'dir_module' => $dir_module,
  		);
  	}

    return $modules;
  }

  public function getSideMenus()
  {
  	// Get Manifests
  	$manifests = $this->getManifests();

  	$menus = array();

  	$sidemenus = array();

  	foreach ($manifests as $manifest) {
    	$json = json_decode($manifest, true);

  		if (!empty($json['sidemenu'])) {
  			foreach ($json['sidemenu'] as $json_sidemenu) {
  				$sidemenus[] = $json_sidemenu;
  			}
  		}
  	}

		foreach ($sidemenus as $sidemenu) {
			if (!empty($sidemenu['id'])) {
				$id = $sidemenu['id'];

				if ($sidemenu['level']) {
					$level = $sidemenu['level'];
				} else {
					$level = 1;
				}

				if ($sidemenu['parent']) {
					$parent = $sidemenu['parent'];
				} else {
					$parent = '';
				}

				if ($sidemenu['icon']) {
					$icon = $sidemenu['icon'];
				} else {
					$icon = '';
				}

				if ($sidemenu['text'][$this->language->getBackEndLocale()]) {
					$text = $sidemenu['text'][$this->language->getBackEndLocale()];
				} else {
					$text = '';
				}

				if ($sidemenu['href']) {
					$href = $sidemenu['href'];
				} else {
					$href = '';
				}

				if ($sidemenu['target']) {
					$target = $sidemenu['target'];
				} else {
					$target = '';
				}

				if ($sidemenu['sort_order']) {
					$sort_order = $sidemenu['sort_order'];
				} else {
					$sort_order = '';
				}

				if ($sidemenu['children']) {
					$children = $sidemenu['children'];
				} else {
					$children = array();
				}

	  		$menus[] = array(
	  			'id' => $id,
	  			'level' => $level,
	  			'parent' => $parent,
	  			'icon' => $icon,
	  			'text' => $text,
	  			'href' => $href,
	  			'target' => $target,
	  			'sort_order' => $sort_order,
	  			'children' => $children,
	  		);
			}
		}

    return $menus;
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
		$directories = glob(ROOTPATH . 'modules/*/*', GLOB_ONLYDIR);

    if (!$directories) {
      $directories = array();
    }

    return $directories;
  }
}