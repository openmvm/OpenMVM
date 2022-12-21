<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
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
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

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
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        
        // Libraries
        $this->administrator = new \App\Libraries\Administrator();
        $this->calendar = new \App\Libraries\Calendar();
        $this->cart = new \App\Libraries\Cart();
        $this->currency = new \App\Libraries\Currency();
        $this->customer = new \App\Libraries\Customer();
        $this->email = \Config\Services::email();
        $this->file = new \App\Libraries\File();
        $this->language = new \App\Libraries\Language();
        $this->image = new \App\Libraries\Image();
        $this->request = service('request');
        $this->session = \Config\Services::session();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->text = new \App\Libraries\Text();
        $this->timezone = new \App\Libraries\Timezone();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        $this->url = new \App\Libraries\Url();
        $this->validation =  \Config\Services::validation();
        $this->weight = new \App\Libraries\Weight();
        $this->wishlist = new \App\Libraries\Wishlist();
        $this->zip = new \App\Libraries\Zip();

        // Helper
        helper('form');
        helper('filesystem');
        
        // Admin
        // Common Controllers
        $this->admin_header = new \Main\Admin\Controllers\Common\Header();
        $this->admin_column_left = new \Main\Admin\Controllers\Common\Column_Left();
        $this->admin_footer = new \Main\Admin\Controllers\Common\Footer();
        
        // Marketplace
        // Common Controllers
        $this->marketplace_header = new \Main\Marketplace\Controllers\Common\Header();
        $this->marketplace_offcanvas_left = new \Main\Marketplace\Controllers\Common\Offcanvas_Left();
        $this->marketplace_footer = new \Main\Marketplace\Controllers\Common\Footer();
        $this->marketplace_common_widget = new \Main\Marketplace\Controllers\Common\Widget();
    }
}
