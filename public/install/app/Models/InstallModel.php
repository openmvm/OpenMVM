<?php namespace App\Models;

class InstallModel extends \CodeIgniter\Model
{

	public function __construct()
	{
		// Load Configs
		$this->session = \Config\Services::session();
	}

	public function appInstalled()
	{
		clearstatcache();
		if (filesize(ROOTPATH . '../app/Config/Database.php') > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function connectDb($data = array())
	{
		if ($data['db_driver'] == 'mysqli') {
			$db_driver = 'MySQLi';
		} elseif ($data['db_driver'] == 'pdo') {
			$db_driver = 'PDO';
		} else {
			$db_driver = 'MySQLi';
		}

		$custom = array(
		  'DSN'      => '',
		  'hostname' => $data['hostname'],
		  'username' => $data['db_username'],
		  'password' => $data['db_password'],
		  'database' => $data['database'],
		  'DBDriver' => $db_driver,
		  'DBPrefix' => $data['db_prefix'],
		  'pConnect' => false,
		  'DBDebug'  => (ENVIRONMENT !== 'production'),
		  'cacheOn'  => false,
		  'cacheDir' => '',
		  'charset'  => 'utf8',
		  'DBCollat' => 'utf8_general_ci',
		  'swapPre'  => '',
		  'encrypt'  => false,
		  'compress' => false,
		  'strictOn' => false,
		  'failover' => [],
		  'port'     => 3306,
		);

		$utils = \Config\Database::utils($custom);

		if ($utils->databaseExists($data['database'])) {
			return true;
		} else {
			return false;
		}
	}

	public function configureDatabase($data = array())
	{
		if ($data['db_driver'] == 'mysqli') {
			$db_driver = 'MySQLi';
		} else {
			$db_driver = 'MySQLi';
		}

		// Check the .env file and set the app.baseURL
		$install_env_file = '../.env';
		$main_env_file = '../../../.env';

		$original_strings = array(
			'# database.default.hostname = localhost',
			'# database.default.database = ci4',
			'# database.default.username = root',
			'# database.default.password = root',
			'# database.default.DBDriver = MySQLi',
		);
		$new_strings = array(
			'database.default.hostname = ' . $data['hostname'],
			'database.default.database = ' . $data['database'],
			'database.default.username = ' . $data['db_username'],
			'database.default.password = ' . $data['db_password'],
			'database.default.DBDriver = ' . $db_driver . "\r\n" . 'database.default.DBPrefix = ' . $data['db_prefix'],
		);

		// main_env_file
		// read the entire string
		$main_env_file_content = file_get_contents($main_env_file);

		// replace something in the file string - this is a VERY simple example
		$main_env_file_content = str_replace($original_strings, $new_strings, $main_env_file_content);

		// write the entire string
		$write_main_env = file_put_contents($main_env_file, $main_env_file_content);

		// install_env_file
		// read the entire string
		$install_env_file_content = file_get_contents($install_env_file);

		// replace something in the file string - this is a VERY simple example
		$install_env_file_content = str_replace($original_strings, $new_strings, $install_env_file_content);

		// write the entire string
		$write_install_env = file_put_contents($install_env_file, $install_env_file_content);

		if ($write_main_env && $write_install_env) {
			return true;
		} else {
			return false;
		}
	}

	public function importSqlFile($data = array())
	{
		if ($data['db_driver'] == 'mysqli') {
			$db_driver = 'MySQLi';
		} else {
			$db_driver = 'MySQLi';
		}

		$custom = array(
		  'DSN'      => '',
		  'hostname' => $data['hostname'],
		  'username' => $data['db_username'],
		  'password' => $data['db_password'],
		  'database' => $data['database'],
		  'DBDriver' => $db_driver,
		  'DBPrefix' => $data['db_prefix'],
		  'pConnect' => false,
		  'DBDebug'  => (ENVIRONMENT !== 'production'),
		  'cacheOn'  => false,
		  'cacheDir' => '',
		  'charset'  => 'utf8',
		  'DBCollat' => 'utf8_general_ci',
		  'swapPre'  => '',
		  'encrypt'  => false,
		  'compress' => false,
		  'strictOn' => false,
		  'failover' => [],
		  'port'     => 3306,
		);

		$utils = \Config\Database::utils($custom);

		if ($utils->databaseExists($data['database'])) {
			// Load Database
			$db = \Config\Database::connect($custom);

			// Check Module database.sql
			if (file_exists(ROOTPATH . 'openmvm.sql')) {
				$templine = '';

				$database = file(ROOTPATH . 'openmvm.sql');

				foreach ($database as $line) {
					if (substr($line, 0, 2) == '--' || substr($line,0,2) == "/*" || $line == '') {
						continue;
					}

					$templine .= $line;

					if (substr(trim($line), -1, 1) == ';') {
						$templine = str_replace("DROP TABLE IF EXISTS `omvm_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $templine);
						$templine = str_replace("CREATE TABLE `omvm_", "CREATE TABLE `" . $data['db_prefix'], $templine);
						$templine = str_replace("INSERT INTO `omvm_", "INSERT INTO `" . $data['db_prefix'], $templine);
						$templine = str_replace("ALTER TABLE `omvm_", "ALTER TABLE `" . $data['db_prefix'], $templine);

						$db->query($templine);
						$templine = '';
					}
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function addAdministrator($data = array())
	{
		if ($data['db_driver'] == 'mysqli') {
			$db_driver = 'MySQLi';
		} else {
			$db_driver = 'MySQLi';
		}

		$custom = array(
		  'DSN'      => '',
		  'hostname' => $data['hostname'],
		  'username' => $data['db_username'],
		  'password' => $data['db_password'],
		  'database' => $data['database'],
		  'DBDriver' => $db_driver,
		  'DBPrefix' => $data['db_prefix'],
		  'pConnect' => false,
		  'DBDebug'  => (ENVIRONMENT !== 'production'),
		  'cacheOn'  => false,
		  'cacheDir' => '',
		  'charset'  => 'utf8',
		  'DBCollat' => 'utf8_general_ci',
		  'swapPre'  => '',
		  'encrypt'  => false,
		  'compress' => false,
		  'strictOn' => false,
		  'failover' => [],
		  'port'     => 3306,
		);

		// Load Database
		$db = \Config\Database::connect($custom);

		// Insert Administrator Data
		$builder = $db->table('administrator');

    // Hash password
    $salt = uniqid(mt_rand(), true);
    $hashed_password = hash('sha1', $data['password'] . $salt);

    $query_data = array(
      'administrator_group_id' => $this->getSettingValue($data, 'setting', 'setting_default_administrator_group_id'),
      'username'               => $data['username'],
      'password'               => $hashed_password,
      'salt'                   => $salt,
      'firstname'              => $data['firstname'],
      'lastname'               => $data['lastname'],
      'email'                  => $data['email'],
      //'avatar'                 => $avatar,
      'status'                 => 1,
      'date_added'             => date("Y-m-d H:i:s",now()),
    );

		$query = $builder->insert($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function getSettingValue($data = array(), $code, $key)
	{
		if ($data['db_driver'] == 'mysqli') {
			$db_driver = 'MySQLi';
		} else {
			$db_driver = 'MySQLi';
		}

		$custom = array(
		  'DSN'      => '',
		  'hostname' => $data['hostname'],
		  'username' => $data['db_username'],
		  'password' => $data['db_password'],
		  'database' => $data['database'],
		  'DBDriver' => $db_driver,
		  'DBPrefix' => $data['db_prefix'],
		  'pConnect' => false,
		  'DBDebug'  => (ENVIRONMENT !== 'production'),
		  'cacheOn'  => false,
		  'cacheDir' => '',
		  'charset'  => 'utf8',
		  'DBCollat' => 'utf8_general_ci',
		  'swapPre'  => '',
		  'encrypt'  => false,
		  'compress' => false,
		  'strictOn' => false,
		  'failover' => [],
		  'port'     => 3306,
		);

		// Load Database
		$db = \Config\Database::connect($custom);

		$result = '';
		
		$builder = $db->table('setting');

	  $query_data = array(
	    'code'       => $code,
	    'key'        => $key,
	  );

		$query = $builder->getWhere($query_data);
		
		foreach ($query->getResult() as $row)
		{
			$result = $row->value;
		}

    if ($result) {
      return $result;
    } else {
      return null;
    }
	}
}