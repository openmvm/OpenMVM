<?php

namespace App\Libraries;

class Language
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function getBackEndId()
  {
  	$language = $this->getLanguageByCode($this->getBackEndLocale());

  	$language_id = $language['language_id'];

    return $language_id;
  }

  public function getBackEndLocale()
  {
  	if ($this->session->has('backend_language')) {
	  	$locale = $this->session->get('backend_language');
  	} else {
	  	$locale = $this->setting->get('setting', 'setting_backend_language');
  	}

    return $locale;
  }

  public function getFrontEndId()
  {
  	$language = $this->getLanguageByCode($this->getFrontEndLocale());

  	$language_id = $language['language_id'];

    return $language_id;
  }

  public function getFrontEndLocale()
  {
  	if ($this->session->has('frontend_language')) {
	  	$locale = $this->session->get('frontend_language');
  	} else {
	  	$locale = $this->setting->get('setting', 'setting_frontend_language');
  	}

    return $locale;
  }

  public function getLanguageByCode($code)
  {
		$query = $this->db->query("SELECT * FROM `" . $this->db->getPrefix() . "language` WHERE code = '" . $this->db->escapeString($code) . "'");

		return $query->getRowArray();
  }
}