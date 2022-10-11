<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

class Customer {
	private $customer_id;
	private $customer_group_id;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $is_seller;
	private $seller_id;
    private $wallet_balance;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        if ($this->session->has('customer_session_token')) {
            if ($this->session->has('customer_id_' . $this->session->get('customer_session_token'))) {
                $builder_customer = $this->db->table('customer');
                $builder_customer->where('customer_id', $this->session->get('customer_id_' . $this->session->get('customer_session_token')));
                $builder_customer->where('status', 1);
                $customer_query = $builder_customer->get();
        
                if ($row_customer = $customer_query->getRow()) {
                    $this->customer_id = $row_customer->customer_id;
                    $this->customer_group_id = $row_customer->customer_group_id;
                    $this->username = $row_customer->username;
                    $this->firstname = $row_customer->firstname;
                    $this->lastname = $row_customer->lastname;
                    $this->email = $row_customer->email;

                    // Seller
                    $seller_builder = $this->db->table('seller');
                    $seller_builder->where('customer_id', $row_customer->customer_id);
                    $seller_builder->where('status', 1);
                    $seller_query = $seller_builder->get();

                    if ($seller_row = $seller_query->getRow()) {
                        $this->is_seller = true;
                        $this->seller_id = $seller_row->seller_id;
                    } else {
                        $this->is_seller = false;
                        $this->seller_id = 0;
                    }

                    // Wallet
                    $wallet_builder = $this->db->table('wallet');

                    $wallet_builder->select('SUM(amount) AS total');

                    $wallet_builder->where('customer_id', $row_customer->customer_id);
                    $wallet_builder->groupBy('customer_id');

                    $wallet_query = $wallet_builder->get();

                    if ($wallet_row = $wallet_query->getRow()) {
                        $this->wallet_balance = $wallet_row->total;
                    } else {
                        $this->wallet_balance = 0;
                    }

                } else {
                    $this->logout();
                }
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    /**
     * Customer login.
     *
     */
    public function login($email, $password)
    {
        $builder_customer = $this->db->table('customer');
        $builder_customer->where('email', $email);
        $customer_query = $builder_customer->get();

        $row_customer = $customer_query->getRow();

        if ($row_customer && password_verify($password, $row_customer->password)) {
            $session_token = bin2hex(random_bytes(20));

            $this->session->set('customer_session_token', $session_token);
            $this->session->set('customer_id_' . $session_token, $row_customer->customer_id);

            $this->customer_id = $row_customer->customer_id;
            $this->customer_group_id = $row_customer->customer_group_id;
            $this->username = $row_customer->username;
            $this->firstname = $row_customer->firstname;
            $this->lastname = $row_customer->lastname;
            $this->email = $row_customer->email;

            // Seller
            $seller_builder = $this->db->table('seller');
            $seller_builder->where('customer_id', $row_customer->customer_id);
            $seller_builder->where('status', 1);
            $seller_query = $seller_builder->get();

            if ($seller_row = $seller_query->getRow()) {
                $this->is_seller = true;
                $this->seller_id = $seller_row->seller_id;
            } else {
                $this->is_seller = false;
                $this->seller_id = 0;
            }

            // Wallet
            $wallet_builder = $this->db->table('wallet');

            $wallet_builder->select('SUM(amount) AS total');

            $wallet_builder->where('customer_id', $customer_id);
            $wallet_builder->groupBy('customer_id');

            $wallet_query = $wallet_builder->get();

            if ($wallet_row = $wallet_query->getRow()) {
                $this->wallet_balance = $wallet_row->total;
            } else {
                $this->wallet_balance = 0;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Customer logout.
     *
     */
    public function logout()
    {
        $this->session->remove('customer_id_' . $this->session->get('customer_session_token'));
        $this->session->remove('customer_session_token');

        $this->customer_id = '';
        $this->customer_group_id = '';
        $this->username = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->is_seller = '';
        $this->seller_id = '';
        $this->wallet_balance = '';
    }

    /**
     * Customer logged in.
     *
     */
    public function isLoggedIn()
    {
        return $this->customer_id;
    }

    /**
     * Customer id.
     *
     */
    public function getId()
    {
        return $this->customer_id;
    }

    /**
     * Customer group id.
     *
     */
    public function getGroupId()
    {
        return $this->customer_group_id;
    }

    /**
     * Customer username.
     *
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Customer firstname.
     *
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Customer lastname.
     *
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Customer email.
     *
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Customer is seller.
     *
     */
    public function isSeller()
    {
        return $this->is_seller;
    }

    /**
     * Customer seller id.
     *
     */
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * Customer wallet balance.
     *
     */
    public function getWalletBalance()
    {
        return $this->wallet_balance;
    }

    /**
     * Get token.
     *
     */
    public function getToken()
    {
        if ($this->session->has('customer_session_token')) {
            return $this->session->get('customer_session_token');
        } else {
            return false;
        }
    }

    /**
     * Verify token.
     *
     */
    public function verifyToken($token)
    {
        $verify = false;

        if ($this->session->has('customer_session_token') && !empty($token)) {
            if ($this->session->get('customer_session_token') == $token) {
                $verify = true;
            }
        }

        return $verify;
    }
}