<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd\Widgets;

class Latest extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->user = new \App\Libraries\User;
		$this->setting = new \App\Libraries\Setting;
		$this->image = new \App\Libraries\Image;
		$this->currency = new \App\Libraries\Currency;
		// Load Models
		$this->widgetModel = new \Modules\OpenMVM\Theme\Models\WidgetModel();
		$this->productModel = new \Modules\OpenMVM\Store\Models\ProductModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
	}

	public function index($widget_id)
	{
		static $widget = 0;

		$widget_category_data = array();

		// Data Libraries
		$widget_category_data['lang'] = $this->language;

		$widget_category_data['user_token'] = $this->user->getToken();

		$widget_category_data['widget'] = $widget++;

		// Get widget info
		$widget_info = $this->widgetModel->getWidget($widget_id);

		if ($widget_info) {
			$widget_category_data['name'] = $widget_info['name'];

			$widget_category_data['products'] = array();

			$results = $this->productModel->getLatestProducts();

			foreach ($results as $result) {
				// Get store info
				$store_info = $this->storeModel->getStore($result['store_id']);

				// Get product description
				$product_description = $this->productModel->getProductDescription($result['product_id']);

				// Thumb
				if ($result && is_file(ROOTPATH . 'public/assets/files/' . $result['image'])) {
					$thumb = $this->image->resize($result['image'], 200, 200, true, 'auto');
				} else {
			    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
						$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 200, 200, true, 'auto');
					} else {
						$thumb = $this->image->resize('placeholder.png', 200, 200, true, 'auto');
					}
				}

				$widget_category_data['products'][] = array(
					'product_id' => $result['product_id'],
					'store' => $store_info['name'],
					'name' => $product_description['name'],
					'thumb' => $thumb,
					'price' => $this->currency->format($result['price'], $this->currency->getFrontEndCode()),
					'quantity' => $result['quantity'],
					'status' => $result['status'],
					'view' => base_url('product/view/' . $result['product_id'] . '/' . $result['slug']),
					'href' => base_url('product/view/' . $result['product_id'] . '/' . $result['slug']),
				);
			}

			// Return view
			return $this->template->render('FrontendThemes', 'Store\Widgets\latest', $widget_category_data);
		}
	}
}
