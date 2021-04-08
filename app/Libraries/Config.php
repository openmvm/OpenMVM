<?php

namespace App\Libraries;

class Config
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function mail($config = array())
  {
		$config['protocol'] = $this->setting->get('setting', 'setting_mail_protocol');
		$config['SMTPHost'] = $this->setting->get('setting', 'setting_smtp_hostname');
		$config['SMTPUser'] = $this->setting->get('setting', 'setting_smtp_username');
		$config['SMTPPass'] = $this->setting->get('setting', 'setting_smtp_password');
		$config['SMTPPort'] = $this->setting->get('setting', 'setting_smtp_port');
		$config['SMTPTimeout'] = $this->setting->get('setting', 'setting_smtp_timeout');
		$config['SMTPCrypto'] = '';
		$config['mailType'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordWrap'] = true;

		return $config;
  }
}