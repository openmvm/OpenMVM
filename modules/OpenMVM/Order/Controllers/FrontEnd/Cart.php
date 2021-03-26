<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd;

class Cart extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->orderModel = new \Modules\OpenMVM\Order\Models\OrderModel();
	}

	public function index()
	{
		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_shopping_cart', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/cart'),
			'active' => true,
		);

    // Totals
		$total_items = 0;
		$total_value = 0;

		$data['stores'] = array();

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

			$results = array('sub_total', 'shipping', 'total');

			foreach ($results as $result) {
				$codes = explode('_', $result);
				
				$code = array();

				foreach ($codes as $key => $value) {
					$code[] = ucwords($value);
				}

				$code = implode('', $code);

				$model = lcfirst($code . 'Model');
				$namespace = '\Modules\OpenMVM\Order\Models\Total\\' . $code . 'Model';
				$this->$model = new $namespace;

				$this->{$model}->getTotal($store['store_id'], $total_data, $this->language->getFrontEndLocale());

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}
			
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

			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name' => $store['name'],
				'thumb' => $thumb,
				'products' => $product_data,
				'totals' => $totals_data,
				'weight' => $this->weight->format($this->cart->getWeight($store['store_id'], 'frontend'), $this->setting->get('setting', 'setting_frontend_weight_class_id'), lang('Common.common_decimal_point', array(), $this->language->getFrontEndLocale()), lang('Common.common_thousand_point', array(), $this->language->getFrontEndLocale())),
			);

			$total_item += $this->cart->countProducts($store['store_id']);
		}

		$data['total_item'] = $total_item;
		$data['total_value'] = $this->currency->format($total_value, $this->currency->getFrontEndCode());

		$data['user_token'] = $this->user->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_shopping_cart', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Order\cart', $data);
	}

	public function add()
	{
    $json = array();

    if (empty($this->request->getPost('product_id'))) {
    	$json['error'] = lang('Error.error_empty_product', array(), $this->language->getFrontEndLocale());
    }

    if (empty($this->request->getPost('store_id'))) {
    	$json['error'] = lang('Error.error_empty_store', array(), $this->language->getFrontEndLocale());
    }

    if ($this->request->getPost('quantity') == null) {
    	$json['error'] = lang('Error.error_missing_quantity', array(), $this->language->getFrontEndLocale());
    }

    if (!$json['error']) {
	    if ($this->user->isLogged()) {
	    	$user_id = $this->user->getId();
	    } else {
	    	$user_id = 0;
	    }

	    $product_id = $this->request->getPost('product_id');
	    $store_id = $this->request->getPost('store_id');
	    $quantity = $this->request->getPost('quantity');
	    $option = array();
    	
    	$this->cart->add($store_id, $product_id, $quantity, $option);

			// Get Cart Stores
			$this->subTotalModel = new \Modules\OpenMVM\Order\Models\Total\SubTotalModel();
			$this->totalModel = new \Modules\OpenMVM\Order\Models\Total\TotalModel();

    	// Totals
			$total_items = 0;
			$total_value = 0;

			foreach ($this->cart->getStores() as $store) {
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

				$total_item += $this->cart->countProducts($store['store_id']);
			}

    	$json['success'] = 'SUCCESS!';
    	$json['total_item'] = $total_item;
    	$json['total_value'] = $this->currency->format($total_value, $this->currency->getFrontEndCode());
    }

    return $this->response->setJSON($json);
	}
}
