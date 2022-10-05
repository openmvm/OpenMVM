<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Marketplace_Auth_Filter implements FilterInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Libraries
        $this->customer = new \App\Libraries\Customer();
        $this->request = service('request');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to(base_url('marketplace/account/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}