<?php

namespace Modules\OpenMVM\PaymentMethod\Libraries;

class PaymentMethod
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function isInstalled($provider, $code)
  {
		$query = $this->db->query("SELECT * FROM " . $this->db->getPrefix() . "payment_method_install WHERE `provider` = '" . $this->db->escapeString($provider) . "' AND `code` = '" . $this->db->escapeString($code) . "'");

		if ($query->getRow()) {
			return true;
		} else {
			return false;
		}
  }

  public function list()
  {
		// Get list
    $list = array();

		$providers = glob(ROOTPATH . 'modules/*', GLOB_ONLYDIR);

		if (!$providers) {
			$providers = array();
		}

		foreach ($providers as $provider) {
			$dir = ROOTPATH . 'modules/' . basename($provider) . '/PaymentMethod/Controllers/BackEnd/PaymentMethod';

			if (is_dir($dir)) {
				$files = array_diff(scandir($dir), array('..', '.'));

				if ($files) {
					foreach ($files as $file) {
						$pathinfo = pathinfo($file);

						$list[] = array(
							'provider' => basename($provider),
							'file' => $file,
							'filename' => $pathinfo['filename'],
							'code' => strtolower(implode('_', preg_split('/(?=[A-Z])/',lcfirst($pathinfo['filename'])))),
							'path' => ROOTPATH . 'modules/' . basename($provider) . '/PaymentMethod/Controllers/BackEnd/PaymentMethod',
						);
					}
				}
			}
		}

    return $list;
  }

  public function check($provider, $code)
  {
  	$parts = explode('_', $code);

  	foreach ($parts as $part) {
  		$implode[] = ucfirst($part);
  	}

	  $filename = implode('', $implode);

  	if (is_file(ROOTPATH . 'modules/' . $provider . '/PaymentMethod/Controllers/BackEnd/PaymentMethod/' . $filename . '.php')) {
  		return true;
  	} else {
  		return false;
  	}
  }
}