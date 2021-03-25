<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
	/**
	 * -------------------------------------------------------------------
	 * Namespaces
	 * -------------------------------------------------------------------
	 * This maps the locations of any namespaces in your application to
	 * their location on the file system. These are used by the autoloader
	 * to locate files the first time they have been instantiated.
	 *
	 * The '/app' and '/system' directories are already mapped for you.
	 * you may change the name of the 'App' namespace if you wish,
	 * but this should be done prior to creating any namespaced classes,
	 * else you will need to modify all of those classes for this to work.
	 *
	 * Prototype:
	 *
	 *   $psr4 = [
	 *       'CodeIgniter' => SYSTEMPATH,
	 *       'App'	       => APPPATH
	 *   ];
	 *
	 * @var array<string, string>
	 */
	public $psr4 = [
		APP_NAMESPACE => APPPATH, // For custom app namespace
		'Config'      => APPPATH . 'Config',
		// Modules
		'Modules\OpenMVM\Administrator' => ROOTPATH . 'modules/OpenMVM/Administrator',
		'Modules\OpenMVM\Common' => ROOTPATH . 'modules/OpenMVM/Common',
		'Modules\OpenMVM\Filemanager' => ROOTPATH . 'modules/OpenMVM/Filemanager',
		'Modules\OpenMVM\FrontendTheme' => ROOTPATH . 'modules/OpenMVM/FrontendTheme',
		'Modules\OpenMVM\Localisation' => ROOTPATH . 'modules/OpenMVM/Localisation',
		'Modules\OpenMVM\Order' => ROOTPATH . 'modules/OpenMVM/Order',
		'Modules\OpenMVM\PaymentMethod' => ROOTPATH . 'modules/OpenMVM/PaymentMethod',
		'Modules\OpenMVM\ShippingMethod' => ROOTPATH . 'modules/OpenMVM/ShippingMethod',
		'Modules\OpenMVM\Setting' => ROOTPATH . 'modules/OpenMVM/Setting',
		'Modules\OpenMVM\Store' => ROOTPATH . 'modules/OpenMVM/Store',
		'Modules\OpenMVM\Theme' => ROOTPATH . 'modules/OpenMVM/Theme',
		'Modules\OpenMVM\User' => ROOTPATH . 'modules/OpenMVM/User',
		// Third Party Modules
		'Modules\Example\FrontendTheme' => ROOTPATH . 'modules/Example/FrontendTheme',
		// BackEnd Themes
		'BackendThemes\OpenMVM\ThemeDefault' => ROOTPATH . 'backend_themes/OpenMVM/ThemeDefault',
		// Third Party BackEnd Themes
		'BackendThemes\Example\Example' => ROOTPATH . 'backend_themes/Example/Example',
		// FrontEnd Themes
		'FrontendThemes\OpenMVM\ThemeDefault' => ROOTPATH . 'frontend_themes/OpenMVM/ThemeDefault',
		// Third Party FrontEnd Themes
		'FrontendThemes\Example\Example' => ROOTPATH . 'frontend_themes/Example/Example',
	];

	/**
	 * -------------------------------------------------------------------
	 * Class Map
	 * -------------------------------------------------------------------
	 * The class map provides a map of class names and their exact
	 * location on the drive. Classes loaded in this manner will have
	 * slightly faster performance because they will not have to be
	 * searched for within one or more directories as they would if they
	 * were being autoloaded through a namespace.
	 *
	 * Prototype:
	 *
	 *   $classmap = [
	 *       'MyClass'   => '/path/to/class/file.php'
	 *   ];
	 *
	 * @var array<string, string>
	 */
	public $classmap = [];
}
