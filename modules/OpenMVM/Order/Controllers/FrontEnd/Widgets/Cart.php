<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class Cart extends \App\Controllers\BaseController
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
		$this->currency = new \App\Libraries\Currency;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Models
		$this->subTotalModel = new \Modules\OpenMVM\Order\Models\Total\SubTotalModel();
		$this->totalModel = new \Modules\OpenMVM\Order\Models\Total\TotalModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_cart_data = array();

		// Data Libraries
		$widget_cart_data['lang'] = $this->language;

		// Get Cart Stores
    // Totals
		$total_item = 0;
		$total_value = 0;

		$widget_cart_data['stores'] = array();

		foreach ($this->cart->getStores() as $store) {
			// Store logo
			if ($store['logo'] && is_file(ROOTPATH . 'public/assets/files/' . $store['logo'])) {
				$thumb = $this->image->resize($store['logo'], 24, 24, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 24, 24, true, 'auto');
				} else {
					$thumb = $this->image->resize('placeholder.png', 24, 24, true, 'auto');
				}
			}

			// Get store products
			$product_data = array();

			foreach ($this->cart->getProducts($store['store_id']) as $product) {
				if ($product['image'] && is_file(ROOTPATH . 'public/assets/files/' . $product['image'])) {
					$thumb_product = $this->image->resize($product['image'], 48, 48, true, 'auto');
				} else {
			    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
						$thumb_product = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 48, 48, true, 'auto');
					} else {
						$thumb_product = $this->image->resize('placeholder.png', 48, 48, true, 'auto');
					}
				}

				$total = $this->currency->format($product['price'] * $product['quantity'], $this->currency->getFrontEndCode());

				$product_data[] = array(
					'product_id' => $product['product_id'],
					'name' => $product['name'],
					'thumb' => $thumb_product,
					'quantity' => $product['quantity'],
					'price' => $this->currency->format($product['price'], $this->currency->getFrontEndCode()),
					'total' => $total,
				);
			}

			// Get store totals
			$totals = array();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'total'  => &$total
			);

			$this->{'subTotalModel'}->getTotal($store['store_id'], $total_data, $this->language->getFrontEndLocale());
			$this->{'totalModel'}->getTotal($store['store_id'], $total_data, $this->language->getFrontEndLocale());

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);

			$total_value += $total;

			$totals_data = array();

			foreach ($totals as $total) {
				$totals_data[] = array(
					'code'  => $total['code'],
					'title' => $total['title'],
					'value' => $total['value'],
					'text'  => $this->currency->format($total['value'], $this->currency->getFrontEndCode()),
				);
			}

			$widget_cart_data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name' => $store['name'],
				'thumb' => $thumb,
				'products' => $product_data,
				'totals' => $totals_data,
			);

			$total_item += $this->cart->countProducts($store['store_id']);
		}

		$widget_cart_data['total_item'] = $total_item;
		$widget_cart_data['total_value'] = $this->currency->format($total_value, $this->currency->getFrontEndCode());

		$widget_cart_data['user_token'] = $this->user->getToken();

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\cart', $widget_cart_data);
	}

	public function info() {
		return $this->index();
	}
}
