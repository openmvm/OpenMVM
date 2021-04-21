<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();

		// Load Libraries
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->session = \Config\Services::session();
		$this->validation = \Config\Services::validation();
		$this->pager = \Config\Services::pager();
		$this->email = \Config\Services::email();
		$this->language = new \App\Libraries\Language;
		$this->module = new \App\Libraries\Module;
		$this->template = new \App\Libraries\Template;
		$this->backend_theme = new \App\Libraries\BackendTheme;
		$this->frontend_theme = new \App\Libraries\FrontendTheme;
		$this->setting = new \App\Libraries\Setting;
		$this->config = new \App\Libraries\Config;
		$this->image = new \App\Libraries\Image;
		$this->auth = new \App\Libraries\Auth;
		$this->administrator = new \App\Libraries\Administrator;
		$this->user = new \App\Libraries\User;
		$this->pclzip = new \App\Libraries\PclZip;
		$this->text = new \App\Libraries\Text;
		$this->currency = new \App\Libraries\Currency;
		$this->widget = new \App\Libraries\Widget;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		$this->mail = new \App\Libraries\Mail;
		$this->weight = new \App\Libraries\Weight;
		$this->length = new \App\Libraries\Length;

		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		$this->weight = new \Modules\OpenMVM\Localisation\Libraries\Weight;
		$this->payment_method = new \Modules\OpenMVM\PaymentMethod\Libraries\PaymentMethod;
		$this->shipping_method = new \Modules\OpenMVM\ShippingMethod\Libraries\ShippingMethod;

		// Load Third Party Libraries

		// Load Helper
		helper(['form', 'date', 'filesystem']);

		// BackEnd Common
		$this->backend_header = new \Modules\OpenMVM\Common\Controllers\BackEnd\Header();
		$this->backend_sidemenu = new \Modules\OpenMVM\Common\Controllers\BackEnd\SideMenu();
		$this->backend_footer = new \Modules\OpenMVM\Common\Controllers\BackEnd\Footer();

		// FrontEnd Common
		$this->frontend_header = new \Modules\OpenMVM\Common\Controllers\FrontEnd\Header();
		$this->frontend_footer = new \Modules\OpenMVM\Common\Controllers\FrontEnd\Footer();
	}
}
