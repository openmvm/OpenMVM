<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd;

class Search extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
		$this->productModel = new \Modules\OpenMVM\Store\Models\ProductModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
	}

	public function index()
	{
		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['widget'] = $this->widget;
		$data['template'] = $this->template;

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_search', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data text
		$data['heading_title'] = lang('Heading.heading_search', array(), $this->language->getFrontEndLocale());

		// Search Parameters
		if (!empty($this->request->getGet('search'))) {
			$search = $this->request->getGet('search');
		} else {
			$search = '';
		}

		if (!empty($this->request->getGet('sort'))) {
			$sort = $this->request->getGet('sort');
		} else {
			$sort = 'product.sort_order';
		}

		if (!empty($this->request->getGet('order'))) {
			$order = $this->request->getGet('order');
		} else {
			$order = 'ASC';
		}

		if (!empty($this->request->getGet('page'))) {
			$page = (int)$this->request->getGet('page');
		} else {
			$page = 1;
		}

		if (!empty($this->request->getGet('limit'))) {
			$limit = (int)$this->request->getGet('limit');
		} else {
			$limit = $this->setting->get('setting', 'setting_frontend_items_per_page');
		}

		// Get products
		$data['products'] = array();

		$filter_data = array(
			'filter_keyword'      => $search,
			'sort'                => $sort,
			'order'               => $order,
			'start'               => ($page - 1) * $limit,
			'limit'               => $limit
		);

		$total_results = $this->productModel->getTotalProducts($filter_data);

		$results = $this->productModel->getProducts($filter_data);

		foreach ($results as $result) {
			// Get store info
			$store_info = $this->storeModel->getStore($result['store_id']);

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

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'store' => $store_info['name'],
				'name' => $result['name'],
				'thumb' => $thumb,
				'price' => $this->currency->format($result['price'], $this->currency->getFrontEndCode()),
				'quantity' => $result['quantity'],
				'status' => $result['status'],
				'view' => base_url('product/view/' . $result['product_id'] . '/' . $result['slug']),
				'href' => base_url('product/view/' . $result['product_id'] . '/' . $result['slug']),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $limit, $total_results, 'frontend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getFrontEndLocale()), ($total_results) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total_results - $limit)) ? $total_results : ((($page - 1) * $limit) + $limit), $total_results, ceil($total_results / $limit));

		// Load Header
		$header_parameter = array(
			'title' => $data['heading_title'],
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Store\search', $data);
	}
}
