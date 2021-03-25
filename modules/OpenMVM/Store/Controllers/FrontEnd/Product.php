<?php

namespace Modules\OpenMVM\Store\Controllers\FrontEnd;

class Product extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->productModel = new \Modules\OpenMVM\Store\Models\ProductModel();
		$this->categoryModel = new \Modules\OpenMVM\Store\Models\CategoryModel();
		$this->weightClassModel = new \Modules\OpenMVM\Localisation\Models\WeightClassModel();
		$this->lengthClassModel = new \Modules\OpenMVM\Localisation\Models\LengthClassModel();
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/product/products');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_products', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/products/' . $this->user->getToken()),
			'active' => true,
		);

		// Links
		$data['action'] = base_url('/account/product/products/' . $this->user->getToken());

		// Return
		return $this->getList($data);
	}

	public function add()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/store/products/add');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_products', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/products/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_product_add', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/products/add/' . $this->user->getToken()),
			'active' => true,
		);

		// Text
		$data['heading_title'] = lang('Heading.heading_product_add', array(), $this->language->getFrontEndLocale());

		// Links
		$data['action'] = base_url('/account/store/products/add/' . $this->user->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.description' => ['label' => lang('Entry.entry_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.short_description' => ['label' => lang('Entry.entry_short_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->productModel->addProduct($this->request->getPost(), $this->user->getStoreId(), $this->user->getId());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_product_add', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_product_add', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/store/products/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function edit()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account');

			return redirect()->to(base_url('/login'));
		}

		if (!$this->user->isMerchant()) {
			return redirect()->to(base_url('/account/product/add/' . $this->user->getToken()));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_products', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/products/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_product_edit', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/store/products/edit/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_product_edit', array(), $this->language->getFrontEndLocale());

		// Data Link
		$data['action'] = base_url('/account/store/products/edit/' . $this->request->uri->getSegment(5) . '/' . $this->user->getToken());

		// Form Validation
		$languages = $this->languageModel->getLanguages();

		if ($this->request->getPost()) {
    	foreach ($languages as $language) {
				$this->validate([
					'description.'. $language['language_id'] . '.name' => ['label' => lang('Entry.entry_name', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.description' => ['label' => lang('Entry.entry_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
				$this->validate([
					'description.'. $language['language_id'] . '.short_description' => ['label' => lang('Entry.entry_short_description', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->productModel->editProduct($this->request->getPost(), $this->request->uri->getSegment(5), $this->user->getStoreId(), $this->user->getId());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_product_edit', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_product_edit', array(), $this->language->getFrontEndLocale()));
      }

			return redirect()->to(base_url('/account/store/products/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getList($data = array())
	{
		// Data URL Parameters
		if ($this->request->getGet('page') !== null) {
			$page = $this->request->getGet('page');
		} else {
			$page = 1;
		}

		// Get Products
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['products'] = array();

		$filter_data = array(
			'filter_user_id' => $this->user->getId(),
		);

		$total_results = $this->productModel->getTotalProducts($filter_data);

		$results = $this->productModel->getProducts($filter_data);

		foreach ($results as $result) {
			// Thumb
			if ($result && is_file(ROOTPATH . 'public/assets/files/' . $result['image'])) {
				$thumb = $this->image->resize($result['image'], 48, 48, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 48, 48, true, 'auto');
				} else {
					$thumb = $this->image->resize('placeholder.png', 48, 48, true, 'auto');
				}
			}

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'name' => $result['name'],
				'thumb' => $thumb,
				'price' => $result['price'],
				'quantity' => $result['quantity'],
				'status' => $result['status'],
				'view' => base_url('product/view/' . $result['product_id'] . '/' . $result['slug']),
				'edit' => base_url('account/store/products/edit/' . $result['product_id'] . '/' . $this->user->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_frontend_items_per_page'), $total_results, 'frontend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getFrontEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_frontend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + $this->setting->get('setting', 'setting_frontend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_frontend_items_per_page')));

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_my_products', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Store\product_list', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}

	public function getForm($data = array())
	{
		// Data Form
		if ($this->request->uri->getSegment(4) == 'edit') {
			$product_info = $this->productModel->getProduct($this->request->uri->getSegment(5));
		}

		// General
		$data['languages'] = $this->languageModel->getLanguages();

		if($this->request->getPost('description')) {
			$data['description'] = $this->request->getPost('description');
		} elseif ($product_info) {
			$data['description'] = $this->productModel->getProductDescriptions($product_info['product_id']);
		} else {
			$data['description'] = array();
		}

		// Data
		if($this->request->getPost('price')) {
			$data['price'] = $this->request->getPost('price');
		} elseif ($product_info) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = '';
		}

		if($this->request->getPost('quantity')) {
			$data['quantity'] = $this->request->getPost('quantity');
		} elseif ($product_info) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = '';
		}

		if($this->request->getPost('shipping')) {
			$data['shipping'] = $this->request->getPost('shipping');
		} elseif ($product_info) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if($this->request->getPost('weight')) {
			$data['weight'] = $this->request->getPost('weight');
		} elseif ($product_info) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$data['weight_classes'] = $this->weightClassModel->getWeightClasses();

		if($this->request->getPost('weight_class_id')) {
			$data['weight_class_id'] = $this->request->getPost('weight_class_id');
		} elseif ($product_info) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = '';
		}

		if($this->request->getPost('length')) {
			$data['length'] = $this->request->getPost('length');
		} elseif ($product_info) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if($this->request->getPost('width')) {
			$data['width'] = $this->request->getPost('width');
		} elseif ($product_info) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if($this->request->getPost('height')) {
			$data['height'] = $this->request->getPost('height');
		} elseif ($product_info) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$data['length_classes'] = $this->lengthClassModel->getLengthClasses();

		if($this->request->getPost('length_class_id')) {
			$data['length_class_id'] = $this->request->getPost('length_class_id');
		} elseif ($product_info) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($product_info) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = 1;
		}

		// Links
		// Get product categories
		$data['product_categories'] = array();

		if($this->request->getPost('product_category')) {
			$product_categories = $this->request->getPost('product_category');
		} elseif ($product_info) {
			$product_categories = $this->productModel->getProductCategories($product_info['product_id']);
		} else {
			$product_categories = array();
		}

		foreach ($product_categories as $category_id) {
			// Get category info
			$category_info = $this->categoryModel->getCategory($category_id, $this->language->getFrontEndId());

			if ($category_info) {
			  $data['product_categories'][] = array(
			  	'category_id' => $category_info['category_id'],
			  	'name' => $category_info['path'],
			  );
			}
		}

		// Images
		if ($this->request->getPost('image')) {
			$data['thumb_image'] = $this->image->resize($this->request->getPost('image'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $product_info['image'])) {
				$data['thumb_image'] = $this->image->resize($product_info['image'], 150, 150, true, 'auto');
			} else {
				$data['thumb_image'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('image')) {
			$data['image'] = $this->request->getPost('image');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $product_info['image'])) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		if ($this->request->getPost('wallpaper')) {
			$data['thumb_wallpaper'] = $this->image->resize($this->request->getPost('wallpaper'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $product_info['wallpaper'])) {
				$data['thumb_wallpaper'] = $this->image->resize($product_info['wallpaper'], 150, 150, true, 'auto');
			} else {
				$data['thumb_wallpaper'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('wallpaper')) {
			$data['wallpaper'] = $this->request->getPost('wallpaper');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $product_info['wallpaper'])) {
			$data['wallpaper'] = $product_info['wallpaper'];
		} else {
			$data['wallpaper'] = '';
		}

		// Load Header
		$scripts = array(
			'<script src="https://cdn.tiny.cloud/1/dbn26al47vjyo0bxis21dzudvrxslublqnw46jc6n4d9g74w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>',
		);

		$header_parameter = array(
			'title' => $data['heading_title'],
			'breadcrumbs' => $data['breadcrumbs'],
			'scripts' => $scripts,
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Store\product_form', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}

	public function getInfo($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		// Get Product Info
		$product_info = $this->productModel->getProduct($this->request->uri->getSegment(3));

		if ($product_info) {
			// Get Product Description
			$product_description = $this->productModel->getProductDescription($product_info['product_id']);

			// Breadcrumbs
			$data['breadcrumbs'][] = array(
				'text' => $product_description['name'],
				'href' => base_url('/product/view/' . $product_info['product_id'] . '/' . $product_description['slug']),
				'active' => true,
			);

			// Data Text
			$data['heading_title'] = $product_description['name'];
			$data['description'] = $product_description['description'];
			$data['product_id'] = $product_info['product_id'];
			$data['store_id'] = $product_info['store_id'];
			$data['price'] = $this->currency->format($product_info['price'], $this->currency->getFrontEndCode());

			// Images
			if ($product_info['image'] && is_file(ROOTPATH . 'public/assets/files/' . $product_info['image'])) {
				$data['image'] = $this->image->resize($product_info['image'], 500, 500, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$data['image'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 500, 500, true, 'auto');
				} else {
					$data['image'] = $this->image->resize('placeholder.png', 500, 500, true, 'auto');
				}
			}

			// Store
			$store_info = $this->storeModel->getStore($product_info['store_id']);

			$data['store_name'] = $store_info['name'];

			if ($store_info['logo'] && is_file(ROOTPATH . 'public/assets/files/' . $store_info['logo'])) {
				$data['logo'] = $this->image->resize($store_info['logo'], 100, 100, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$data['logo'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 100, 100, true, 'auto');
				} else {
					$data['logo'] = $this->image->resize('placeholder.png', 100, 100, true, 'auto');
				}
			}

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
			echo $this->template->render('FrontendThemes', 'Store\product', $data);
		} else {
			// Data Text
			$data['message'] = lang('Text.text_product_not_found', array(), $this->language->getFrontEndLocale());

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
}
