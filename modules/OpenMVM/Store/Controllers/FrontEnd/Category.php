<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd;

class Category extends \App\Controllers\BaseController
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

		if (!empty($this->request->uri->getSegment(2))) {
			$path = '';

			$parts = explode('_', (string)$this->request->uri->getSegment(2));

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->categoryModel->getCategory($path_id);

				if ($category_info) {
					// Get category description
					$category_description = $this->categoryModel->getCategoryDescription($category_info['category_id'], $this->language->getFrontEndId());

					$data['breadcrumbs'][] = array(
						'text' => $category_description['name'],
						'href' => base_url('/category/' . $path . '/' . $category_description['slug']),
						'active' => false,
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->categoryModel->getCategory($category_id);

		if ($category_info) {
			// Get category description
			$category_description = $this->categoryModel->getCategoryDescription($category_info['category_id'], $this->language->getFrontEndId());

			$data['breadcrumbs'][] = array(
				'text' => $category_description['name'],
				'href' => base_url('/category/' . $this->request->uri->getSegment(2) . '/' . $category_description['slug']),
				'active' => true,
			);

			$data['heading_title'] = $category_description['name'];
			$data['description'] = $category_description['description'];

			// Get products
			$data['products'] = array();

			$filter_data = array(
				'filter_category' => $category_info['category_id'],
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
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
				'title' => $category_description['name'],
				'breadcrumbs' => $data['breadcrumbs'],
			);
			$data['header'] = $this->frontend_header->index($header_parameter);

			// Load Footer
			$footer_parameter = array();
			$data['footer'] = $this->frontend_footer->index($footer_parameter);

			// Echo view
			echo $this->template->render('FrontendThemes', 'Store\category', $data);
		} else {
			// Data Text
			$data['message'] = lang('Text.text_category_not_found', array(), $this->language->getFrontEndLocale());

			// Load Header
			$header_parameter = array(
				'title' => lang('Heading.heading_not_found', array(), $this->language->getFrontEndLocale()),
				'breadcrumbs' => $data['breadcrumbs'],
			);
			$data['header'] = $this->frontend_header->index($header_parameter);

			// Load Footer
			$footer_parameter = array();
			$data['footer'] = $this->frontend_footer->index($footer_parameter);

			// Echo view
			echo $this->template->render('FrontendThemes', 'Common\not_found', $data);
		}
	}

	public function autocomplete()
	{
    $json = array();

    if ($this->request->getPost('filter_name') !== null) {
			$filter_data = array(
				'filter_name' => $this->request->getPost('filter_name'),
				'sort'        => 'path',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->categoryModel->getCategories($filter_data, $this->language->getFrontEndId());

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['path'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

    return $this->response->setJSON($json);
  }
}
