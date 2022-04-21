<?php

namespace App\Models\Marketplace\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Reset_Password_Model extends Model
{
    protected $table = 'reset_password';
    protected $primaryKey = 'reset_password_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['reset_password_id', 'email', 'code', 'date_added'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->email = \Config\Services::email();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
    }

    public function addResetPassword($data = [])
    {
        // Delete
        $reset_password_delete_builder = $this->db->table('reset_password');

        $reset_password_delete_builder->where('email', $data['email']);
        $reset_password_delete_builder->delete();

        // Insert
        $reset_password_insert_builder = $this->db->table('reset_password');

        $token = bin2hex(random_bytes(48));

        $date_added = new Time('now');

        $reset_password_insert_data = [
            'email' => $data['email'],
            'token' => $token,
            'date_added' => $date_added,
        ];
        
        $reset_password_insert_builder->insert($reset_password_insert_data);

        $reset_password_id = $this->db->insertID();

        // Send email
        $config = [
            'mailType' => 'html',
        ];

        $this->email->initialize($config);

        $this->email->setFrom($this->setting->get('setting_email'), $this->setting->get('setting_marketplace_name'));
        $this->email->setTo($data['email']);

        $this->email->setSubject(sprintf(lang('Mail.reset_password_subject', [], $this->language->getCurrentCode()), $this->setting->get('setting_marketplace_name')));

        // Email contents
        $content['title'] = lang('Heading.reset_password', [], $this->language->getCurrentCode());
        $content['greeting'] = lang('Mail.reset_password_greeting', [], $this->language->getCurrentCode());
        $content['header'] = sprintf(lang('Mail.reset_password_header', [], $this->language->getCurrentCode()), $this->setting->get('setting_marketplace_name'));
        $content['link'] = base_url('marketplace/account/reset_password/confirm?token=' . $token);
        $content['footer'] = sprintf(lang('Mail.reset_password_footer', [], $this->language->getCurrentCode()), $this->setting->get('setting_email'), $this->setting->get('setting_email'));
        $content['marketplace_name'] = $this->setting->get('setting_marketplace_name');

        $this->email->setMessage($this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Mail\Account\reset_password', $content));

        $this->email->send();

        return $reset_password_id;
    }

    public function verifyToken($token, $email)
    {
        $reset_password_builder = $this->db->table('reset_password');
        
        $reset_password_builder->where('token', $token);
        $reset_password_builder->where('email', $email);

        $reset_password_query = $reset_password_builder->get();

        if ($row = $reset_password_query->getRow()) {
            return true;
        } else {
            return false;
        }
    }

    public function resetPassword($email, $password)
    {
        $customer_update_builder = $this->db->table('customer');

        $customer_update_data = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'date_modified' => new Time('now'),
        ];

        $customer_update_builder->where('email', $email);
        $customer_update_builder->update($customer_update_data);

        // Delete
        $reset_password_delete_builder = $this->db->table('reset_password');

        $reset_password_delete_builder->where('email', $email);
        $reset_password_delete_builder->delete();
    }
}