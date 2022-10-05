<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin_Auth_Filter implements FilterInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Libraries
        $this->administrator = new \App\Libraries\Administrator();
        $this->request = service('request');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(base_url(env('app.AdminUrlSegment') . '/administrator/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}