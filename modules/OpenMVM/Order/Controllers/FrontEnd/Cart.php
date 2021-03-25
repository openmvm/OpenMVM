<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd;

class Cart extends \App\Controllers\BaseController
{
	public function __construct()
	{
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
