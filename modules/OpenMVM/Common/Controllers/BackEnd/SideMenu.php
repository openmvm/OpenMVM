<?php

namespace Modules\OpenMVM\Common\Controllers\BackEnd;

class SideMenu extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->module = new \App\Libraries\Module;
		$this->administrator = new \App\Libraries\Administrator;
	}

	public function index($sidemenu_parameter)
	{
		$sidemenu_data = array();

		// Data Libraries
		$sidemenu_data['lang'] = $this->language;

		// Menu [START]
		$sidemenu_data['menus'][] = array(
			'id' => 'menu-dashboard',
			'level' => 1,
			'parent' => '',
			'icon' => 'fas fa-tachometer-alt fa-fw',
			'text' => lang('Text.text_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard'),
			'target' => '_self',
			'sort_order' => 1,
			'children' => array()
		);

		$modules = $this->module->getSideMenus();

		foreach ($modules as $module) {
			$sidemenu_data['menus'][] = array(
				'id' => $module['id'],
				'level' => $module['level'],
				'parent' => $module['parent'],
				'icon' => $module['icon'],
				'text' => $module['text'],
				'href' => base_url($_SERVER['app.adminDir'] . $module['href']),
				'target' => $module['target'],
				'sort_order' => $module['sort_order'],
				'children' => $module['children']
			);
		}

		$menu_sort_order = array();

		foreach ($sidemenu_data['menus'] as $key => $value) {
			$menu_sort_order[$key] = $value['sort_order'];
		}

		array_multisort($menu_sort_order, SORT_ASC, $sidemenu_data['menus']);

		$sidemenu_data['administrator_token'] = $this->administrator->getToken();

		// Return view
		return $this->template->render('BackendThemes', 'Common\sidemenu', $sidemenu_data);
	}
}
