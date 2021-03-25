<?php namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_lib
{
  function load()
  {
    // Include PHPMailer library files
    require_once APPPATH . 'Libraries/PHPMailer/Exception.php';
    require_once APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require_once APPPATH . 'Libraries/PHPMailer/SMTP.php';
    
    $mail = new PHPMailer;
    return $mail;
  }
}