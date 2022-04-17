<?php

namespace App\Controllers;

class Env extends BaseController
{
    public function index()
    {
        $data['install_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

        return view('env', $data);
    }
}
