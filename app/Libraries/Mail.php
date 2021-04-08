<?php

namespace App\Libraries;

class Mail
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function send($from_email, $from_name, $to_email, $to_name, $subject, $body, $alert_mail = false)
  {
		// Send Mail
		$mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->SMTPDebug   = 0; // Enable verbose debug output
    $mail->isSMTP();     
    $mail->Timeout     = $this->setting->get('setting', 'setting_smtp_timeout'); // Set mailer to use SMTP
    $mail->Host        = $this->setting->get('setting', 'setting_smtp_hostname'); // Specify main and backup SMTP servers
    $mail->SMTPAuth    = true; // Enable SMTP authentication
    $mail->Username    = $this->setting->get('setting', 'setting_smtp_username'); // SMTP username
    $mail->Password    = $this->setting->get('setting', 'setting_smtp_password'); // SMTP password
    $mail->SMTPSecure  = 'ssl'; // Enable TLS encryption, `ssl` also accepted
		$mail->SMTPOptions = array(
	    'ssl' => array(
        'verify_peer' => $this->setting->get('setting', 'setting_smtp_verify_peer'),
        'verify_peer_name' => $this->setting->get('setting', 'setting_smtp_verify_peer_name'),
        'allow_self_signed' => $this->setting->get('setting', 'setting_smtp_allow_self_signed')
	    )
		);
    $mail->Port        = $this->setting->get('setting', 'setting_smtp_port'); // TCP port to connect to

    //Recipients
    $mail->setFrom($from_email, html_entity_decode($from_name, ENT_QUOTES, 'UTF-8'));
    $mail->addAddress($to_email, html_entity_decode($to_name, ENT_QUOTES, 'UTF-8')); // Add a recipient

    // Send to alert mails
    if ($alert_mail) {
    	$additional_alert_mails = preg_split('/\r\n|\n|\r/', $this->setting->get('setting', 'setting_additional_alert_mail'));

    	foreach ($additional_alert_mails as $additional_alert_mail) {
    		$alert = explode(',', $additional_alert_mail);

    		$alert_to_email = $alert[0];

    		if (!empty($alert[1])) {
    			$alert_to_name = $alert[1];
    		} else {
    			$alert_to_name = $alert[0];
    		}

  			$mail->addAddress($alert_to_email, html_entity_decode($alert_to_name, ENT_QUOTES, 'UTF-8')); // Add a recipient
    	}
    }

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');

    $mail_data = array();

    $mail->Body    = $body;
    // $mail->AltBody = 'This is just a test email.';

    // Send email
    $query = $mail->send();

    if ($query) {
    	return true;
    } else {
    	return false;
    }
  }

}