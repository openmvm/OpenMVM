<?php

namespace App\Controllers\Marketplace\Account;

class Address extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_customer_customer = new \App\Models\Marketplace\Customer\Customer_Model();
        $this->model_customer_customer_address = new \App\Models\Marketplace\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \App\Models\Marketplace\Localisation\Country_Model();
        $this->model_localisation_zone = new \App\Models\Marketplace\Localisation\Zone_Model();
    }

    public function index()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data = [];

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['heading_title'] = lang('Heading.address_add');

        $data['action'] = $this->url->customerLink('marketplace/account/address/add', '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('address_1', lang('Entry.address_1'), 'required');
            $this->validation->setRule('city', lang('Entry.city'), 'required');
            $this->validation->setRule('country_id', lang('Entry.country'), 'required');
            $this->validation->setRule('zone_id', lang('Entry.zone'), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_customer_customer_address->addCustomerAddress($this->customer->getId(), $this->request->getPost());

                $this->session->set('success', lang('Success.customer_address_add'));

                return redirect()->to($this->url->customerLink('marketplace/account/address', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('firstname')) {
                    $data['error_firstname'] = $this->validation->getError('firstname');
                } else {
                    $data['error_firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $data['error_lastname'] = $this->validation->getError('lastname');
                } else {
                    $data['error_lastname'] = '';
                }

                if ($this->validation->hasError('address_1')) {
                    $data['error_address_1'] = $this->validation->getError('address_1');
                } else {
                    $data['error_address_1'] = '';
                }

                if ($this->validation->hasError('city')) {
                    $data['error_city'] = $this->validation->getError('city');
                } else {
                    $data['error_city'] = '';
                }

                if ($this->validation->hasError('country_id')) {
                    $data['error_country'] = $this->validation->getError('country_id');
                } else {
                    $data['error_country'] = '';
                }

                if ($this->validation->hasError('zone_id')) {
                    $data['error_zone'] = $this->validation->getError('zone_id');
                } else {
                    $data['error_zone'] = '';
                }

                if ($this->validation->hasError('telephone')) {
                    $data['error_telephone'] = $this->validation->getError('telephone');
                } else {
                    $data['error_telephone'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function edit()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['heading_title'] = lang('Heading.address_edit');

        $data['action'] = $this->url->customerLink('marketplace/account/address/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('address_1', lang('Entry.address_1'), 'required');
            $this->validation->setRule('city', lang('Entry.city'), 'required');
            $this->validation->setRule('country_id', lang('Entry.country'), 'required');
            $this->validation->setRule('zone_id', lang('Entry.zone'), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_customer_customer_address->editCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.customer_address_edit'));

                // Remove the checkout payment method session
                $this->session->remove('checkout_payment_method_code');

                // Remove the checkout shipping method session
                if (!empty($this->request->getGet('seller_id'))) {
                    $seller_info = $this->model_seller_seller->getSeller($this->request->getGet('seller_id'));

                    if ($seller_info) {
                        $sellers = [$seller_info];
                    } else {
                        $sellers = [];
                    }
                } else {
                    $sellers = $this->cart->getSellers();
                }

                foreach ($sellers as $seller) {
                    if ($this->session->has('checkout_shipping_method_code_' . $seller['seller_id'])) {
                        $this->session->remove('checkout_shipping_method_code_' . $seller['seller_id']);
                    }
                }

                return redirect()->to($this->url->customerLink('marketplace/account/address', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('firstname')) {
                    $data['error_firstname'] = $this->validation->getError('firstname');
                } else {
                    $data['error_firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $data['error_lastname'] = $this->validation->getError('lastname');
                } else {
                    $data['error_lastname'] = '';
                }

                if ($this->validation->hasError('address_1')) {
                    $data['error_address_1'] = $this->validation->getError('address_1');
                } else {
                    $data['error_address_1'] = '';
                }

                if ($this->validation->hasError('city')) {
                    $data['error_city'] = $this->validation->getError('city');
                } else {
                    $data['error_city'] = '';
                }

                if ($this->validation->hasError('country_id')) {
                    $data['error_country'] = $this->validation->getError('country_id');
                } else {
                    $data['error_country'] = '';
                }

                if ($this->validation->hasError('zone_id')) {
                    $data['error_zone'] = $this->validation->getError('zone_id');
                } else {
                    $data['error_zone'] = '';
                }

                if ($this->validation->hasError('telephone')) {
                    $data['error_telephone'] = $this->validation->getError('telephone');
                } else {
                    $data['error_telephone'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function delete()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        // Query
        $query = $this->model_customer_customer_address->deleteCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

        $this->session->set('success', lang('Success.customer_address_delete'));

        return redirect()->to($this->url->customerLink('marketplace/account/address', '', true));
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_address_book'),
            'href' => $this->url->customerLink('marketplace/account/address', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_address_book');

        // Get customer addresses
        $data['customer_addresses'] = [];

        $customer_addresses = $this->model_customer_customer_address->getCustomerAddresses($this->customer->getId());

        foreach ($customer_addresses as $customer_address) {
            // Get country info
            $country_info = $this->model_localisation_country->getCountry($customer_address['country_id']);

            if (!empty($country_info) && !empty($country_info['address_format'])) {
                $address_format = $country_info['address_format'];
            } else {
                $address_format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city}, {zone}, {country}' . "\n" . lang('Text.telephone') . ': ' . '{telephone}';
            }

            $find = [
                '{firstname}',
                '{lastname}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{zone}',
                '{country}',
                '{telephone}',
                "\n\n",
            ];

            $replace = [
                $customer_address['firstname'],
                $customer_address['lastname'],
                $customer_address['address_1'],
                $customer_address['address_2'],
                $customer_address['city'],
                $customer_address['zone'],
                $customer_address['country'],
                $customer_address['telephone'],
                "\n",
            ];

            $address = nl2br(str_replace($find, $replace, $address_format));

            $data['customer_addresses'][] = [
                'address' => $address,
                'edit' => $this->url->customerLink('marketplace/account/address/edit/' . $customer_address['customer_address_id'], '', true),
                'delete' => $this->url->customerLink('marketplace/account/address/delete/' . $customer_address['customer_address_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/account/address/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/account/address', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.my_address_book'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\address_list', $data);

    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_address_book'),
            'href' => $this->url->customerLink('marketplace/account/address', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $customer_address_info = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $customer_address_info = [];
        }

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif ($customer_address_info) {
            $data['firstname'] = $customer_address_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif ($customer_address_info) {
            $data['lastname'] = $customer_address_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('address_1')) {
            $data['address_1'] = $this->request->getPost('address_1');
        } elseif ($customer_address_info) {
            $data['address_1'] = $customer_address_info['address_1'];
        } else {
            $data['address_1'] = '';
        }

        if ($this->request->getPost('address_2')) {
            $data['address_2'] = $this->request->getPost('address_2');
        } elseif ($customer_address_info) {
            $data['address_2'] = $customer_address_info['address_2'];
        } else {
            $data['address_2'] = '';
        }

        if ($this->request->getPost('city')) {
            $data['city'] = $this->request->getPost('city');
        } elseif ($customer_address_info) {
            $data['city'] = $customer_address_info['city'];
        } else {
            $data['city'] = '';
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        if ($this->request->getPost('country_id')) {
            $data['country_id'] = $this->request->getPost('country_id');
        } elseif ($customer_address_info) {
            $data['country_id'] = $customer_address_info['country_id'];
        } else {
            $data['country_id'] = '';
        }

        if ($this->request->getPost('zone_id')) {
            $data['zone_id'] = $this->request->getPost('zone_id');
        } elseif ($customer_address_info) {
            $data['zone_id'] = $customer_address_info['zone_id'];
        } else {
            $data['zone_id'] = '';
        }

        if ($this->request->getPost('telephone')) {
            $data['telephone'] = $this->request->getPost('telephone');
        } elseif ($customer_address_info) {
            $data['telephone'] = $customer_address_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->customerLink('marketplace/account/address', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.my_address_book'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\address_form', $data);
    }
}
