<?php

namespace App\Libraries;

class Widget
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function getLayoutWidgets($location, $position)
  {
  	// Get layouts by uri_string()
		if ($location === 'frontend') {
			$theme_id = str_replace('-', '_', $this->setting->get('setting', 'setting_frontend_theme'));
		} else {
			$theme_id = str_replace('-', '_', $this->setting->get('setting', 'setting_backend_theme'));
		}

		$segments = array();
		$routes = array();
		
		$uri_strings = explode('/', ltrim(uri_string(), '/'));

		$num_uri_strings = count($uri_strings);

		for ($i = 0; $i < $num_uri_strings; $i++) {
			if ($i == 0) {
			  for ($j = $i; $j < $num_uri_strings; $j++) {
					$segment = array();
			    for ($k = $i; $k <= $j; $k++) {
			      $segment[] = "/" . $uri_strings[$k];
			    }
					$segments[] = $segment;
			  }
			}
		}

		foreach ($segments as $segment) {
			$routes[] = implode('', $segment);
		}
		
		foreach ($routes as $route) {
			$query_layout_route = $this->db->query("SELECT * FROM " . $this->db->getPrefix() . "layout_route WHERE `route` = '" . $this->db->escapeString($route) . "'");

			$row_layout_route = $query_layout_route->getRow();

			$layout_widgets = $this->setting->get($theme_id, $theme_id . '_layout_widget_' . $row_layout_route->layout_id);

			$widget_ids = $layout_widgets[$position];

			if ($widget_ids) {
				foreach ($widget_ids as $widget_id) {
		  		$implode = array();
		  	
					$query_widget = $this->db->query("SELECT * FROM " . $this->db->getPrefix() . "widget WHERE `widget_id` = '" . (int)$widget_id . "' AND `status` = '1'");

					$row_widget = $query_widget->getRow();

					if ($row_widget) {
						$codes = explode('_', $row_widget->code);

						foreach ($codes as $code) {
							$implode[] = ucfirst($code);
						}

				    $namespace = '\\Modules\\' . $row_widget->provider . '\\' . $row_widget->dir . '\Controllers\FrontEnd\Widgets\\' . implode('', $implode);

				    $widget = new $namespace();

						$widgets[] = $widget->index($widget_id);
					}
				}
			}
		}

		return $widgets;
  }

  public function isInstalled($location, $provider, $dir, $code)
  {
		$query = $this->db->query("SELECT * FROM " . $this->db->getPrefix() . "widget_install WHERE `location` = '" . $this->db->escapeString($location) . "' AND `provider` = '" . $this->db->escapeString($provider) . "' AND `dir` = '" . $this->db->escapeString($dir) . "' AND `code` = '" . $this->db->escapeString($code) . "'");

		if ($query->getRow()) {
			return true;
		} else {
			return false;
		}
  }

  public function checkWidgets($location, $provider, $dir,  $code)
  {
  	if ($location == 'frontend') {
  		$dir_location = 'FrontendWidgets';
  	} elseif ($location == 'backend') {
  		$dir_location = 'BackendWidgets';
  	}

  	$parts = explode('_', $code);

  	foreach ($parts as $part) {
  		$implode[] = ucfirst($part);
  	}

	  $filename = implode('', $implode);

  	if (is_file(ROOTPATH . 'modules/' . $provider . '/' . $dir . '/Controllers/BackEnd/' . $dir_location . '/' . $filename . '.php')) {
  		return true;
  	} else {
  		return false;
  	}
  }

  public function getWidgets($location)
  {
  	if ($location == 'frontend') {
  		$dir_location = 'FrontendWidgets';
  	} elseif ($location == 'backend') {
  		$dir_location = 'BackendWidgets';
  	}

		// Get list
    $list = array();

		$providers = glob(ROOTPATH . 'modules/*', GLOB_ONLYDIR);

		if (!$providers) {
			$providers = array();
		}

		foreach ($providers as $provider) {
			$modules = glob(ROOTPATH . 'modules/' . basename($provider) . '/*', GLOB_ONLYDIR);

			if (!$modules) {
				$modules = array();
			}

			foreach ($modules as $module) {
				$dir = ROOTPATH . 'modules/' . basename($provider) . '/' . basename($module) . '/Controllers/BackEnd/' . $dir_location;

				if (is_dir($dir)) {
					$files = array_diff(scandir($dir), array('..', '.'));

					if ($files) {
						foreach ($files as $file) {
							$pathinfo = pathinfo($file);

							$list[] = array(
								'provider' => basename($provider),
								'dir' => basename($module),
								'file' => $file,
								'filename' => $pathinfo['filename'],
								'code' => strtolower(implode('_', preg_split('/(?=[A-Z])/',lcfirst($pathinfo['filename'])))),
								'path' => ROOTPATH . 'modules/' . basename($provider) . '/' . basename($module) . '/Controllers/BackEnd/' . $dir_location,
							);
						}
					}
				}
			}
		}

    return $list;
  }
}