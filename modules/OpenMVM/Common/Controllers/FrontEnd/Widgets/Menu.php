<?php

namespace Modules\OpenMVM\Common\Controllers\FrontEnd\Widgets;

class Menu extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->user = new \App\Libraries\User;
		$this->auth = new \App\Libraries\Auth;
		$this->setting = new \App\Libraries\Setting;
		$this->image = new \App\Libraries\Image;
		// Load Model
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_menu_data = array();

		// Data Libraries
		$widget_menu_data['lang'] = $this->language;

		// Get Categories
		$widget_menu_data['categories'] = array();

		$filter_data = array(
			'filter_category' => 0,
			'sort'  => 'c1.sort_order',
			'order' => 'ASC',
		);

		$results = $this->categoryModel->getCategories($filter_data, $this->language->getFrontEndId());

		foreach ($results as $result) {
			// Level 2 Categories
			$children_data = array();

			$filter_data = array(
				'filter_category' => $result['category_id'],
				'sort'  => 'c1.sort_order',
				'order' => 'ASC',
			);

			$children = $this->categoryModel->getCategories($filter_data, $this->language->getFrontEndId());

			foreach ($children as $child) {
				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name' => $child['name'],
					'href' => base_url('/category/' . $result['category_id'] . '_' . $child['category_id'] . '/' . $child['slug']),
				);
			}

			if ($result['top']) {
				$widget_menu_data['categories'][] = array(
					'category_id' => $result['category_id'],
					'name' => $result['name'],
					'href' => base_url('/category/' . $result['category_id'] . '/' . $result['slug']),
					'children' => $children_data,
				);
			}
		}

		// Return view
		return $this->template->render('FrontendThemes', 'Common\Widgets\Menu', $widget_menu_data);
	}
}
