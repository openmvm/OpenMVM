<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd\Widgets;

class Category extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->uri = new \CodeIgniter\HTTP\URI(uri_string());
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->user = new \App\Libraries\User;
		$this->setting = new \App\Libraries\Setting;
		$this->image = new \App\Libraries\Image;
		// Load Models
		$this->widgetModel = new \Modules\OpenMVM\Theme\Models\WidgetModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
	}

	public function index($widget_id)
	{
		static $widget = 0;

		$widget_category_data = array();

		// Data Libraries
		$widget_category_data['lang'] = $this->language;

		$widget_category_data['user_token'] = $this->user->getToken();

		$widget_category_data['widget'] = $widget++;

		// URI Params
		if ($this->uri->getTotalSegments() > 2 && $this->uri->getSegment(2)) {
			$parts = explode('_', (string)$this->uri->getSegment(2));
		} else {
			$parts = array();
		}

		if (!empty($parts[0])) {
			$widget_category_data['category_id'] = $parts[0];
		} else {
			$widget_category_data['category_id'] = 0;
		}

		if (!empty($parts[1])) {
			$widget_category_data['child_id'] = $parts[1];
		} else {
			$widget_category_data['child_id'] = 0;
		}

		// Get widget info
		$widget_info = $this->widgetModel->getWidget($widget_id);

		if ($widget_info) {
			// Widget setting
			$setting = json_decode($widget_info['setting'], true);

			$widget_category_data['name'] = $setting['name'];
			$widget_category_data['orientation'] = $setting['orientation'];

			// Get categories
			$filter_data = array(
				'filter_category' => 0,
				'filter_status' => 1,
			);

			$categories = $this->categoryModel->getCategories($filter_data, $this->language->getFrontEndId());

			foreach ($categories as $category) {
				// Thumb
				if ($category && is_file(ROOTPATH . 'public/assets/files/' . $category['image'])) {
					$thumb = $this->image->resize($category['image'], 200, 200, true, 'auto');
				} else {
			    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
						$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 200, 200, true, 'auto');
					} else {
						$thumb = $this->image->resize('placeholder.png', 200, 200, true, 'auto');
					}
				}

				// Children / Level 2 Categories
				$children_data = array();

				$filter_data = array(
					'filter_category' => $category['category_id'],
					'filter_status' => 1,
				);
				
				$children = $this->categoryModel->getCategories($filter_data, $this->language->getFrontEndId());

				foreach ($children as $child) {
					// Thumb
					if ($child && is_file(ROOTPATH . 'public/assets/files/' . $child['image'])) {
						$thumb = $this->image->resize($child['image'], 200, 200, true, 'auto');
					} else {
				    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
							$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 200, 200, true, 'auto');
						} else {
							$thumb = $this->image->resize('placeholder.png', 200, 200, true, 'auto');
						}
					}

					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'],
						'thumb' => $thumb,
						'href' => base_url('/category/' . $category['category_id'] . '_' . $child['category_id'] . '/' . $child['slug']),
					);
				}

				$widget_category_data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name' => $category['name'],
					'thumb' => $thumb,
					'children' => $children_data,
					'href' => base_url('/category/' . $category['category_id'] . '/' . $category['slug']),
				);
			}

			// Return view
			return $this->template->render('FrontendThemes', 'Store\Widgets\category', $widget_category_data);
		}
	}
}
