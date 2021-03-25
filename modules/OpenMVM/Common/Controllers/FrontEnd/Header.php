<?php

namespace Modules\OpenMVM\Common\Controllers\FrontEnd;

class Header extends \App\Controllers\BaseController
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
		$this->widget_language = new \Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets\Language();
		$this->widget_currency = new \Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets\Currency();
		$this->widget_cart = new \Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\Cart();
		$this->widget_menu = new \Modules\OpenMVM\Common\Controllers\FrontEnd\Widgets\Menu();
	}

	public function index($header_parameter = array())
	{
		$header_data = array();

		// Data Scripts & Styles
		if (!empty($header_parameter['scripts'])) {
			$header_data['scripts'] = array_unique($header_parameter['scripts']);
		} else {
			$header_data['scripts'] = array();
		}

		if (!empty($header_parameter['styles'])) {
			$header_data['styles'] = array_unique($header_parameter['styles']);
		} else {
			$header_data['styles'] = array();
		}

		// Data Libraries
		$header_data['lang'] = $this->language;
		$header_data['user'] = $this->user;
		$header_data['auth'] = $this->auth;

    // Data Notification
    if ($this->session->get('error') !== null) {
			$header_data['error'] = $this->session->get('error');

			$this->session->remove('error');
    } else {
			$header_data['error'] = '';
    }

    if ($this->session->get('success') !== null) {
			$header_data['success'] = $this->session->get('success');

			$this->session->remove('success');
    } else {
			$header_data['success'] = '';
    }

		// Data Breadcrumbs
		if (!empty($header_parameter['breadcrumbs'])) {
			$header_data['breadcrumbs'] = $header_parameter['breadcrumbs'];
		} else {
			$header_data['breadcrumbs'] = array();
		}

		// Data User
		if ($this->user->isLogged()) {
			$header_data['is_logged']= true;
		} else {
			$header_data['is_logged']= false;
		}

		$header_data['is_merchant']= $this->user->isMerchant();
		$header_data['store_id']= $this->user->getStoreId();
		$header_data['user_id']= $this->user->getId();

		// Data Text
		$header_data['title'] = $header_parameter['title'];
		$header_data['website_name'] = $this->setting->get('setting', 'setting_website_name');

		// Data Logo
		if ($this->setting->get('setting', 'setting_logo') && is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_logo'))) {
			$header_data['logo'] = $this->image->render($this->setting->get('setting', 'setting_logo'));
		} else {
			$header_data['logo'] = '';
		}

		$header_data['user_token'] = $this->user->getToken();

		// Load Widget Language
		$widget_language_parameter = array();
		$header_data['widget_language'] = $this->widget_language->index($widget_language_parameter);

		// Load Widget Currency
		$widget_currency_parameter = array();
		$header_data['widget_currency'] = $this->widget_currency->index($widget_currency_parameter);

		// Load Widget Cart
		$widget_cart_parameter = array();
		$header_data['widget_cart'] = $this->widget_cart->index($widget_cart_parameter);

		// Load Widget Menu
		$widget_menu_parameter = array();
		$header_data['widget_menu'] = $this->widget_menu->index($widget_menu_parameter);

		// Return view
		return $this->template->render('FrontendThemes', 'Common\header', $header_data);
	}
}
