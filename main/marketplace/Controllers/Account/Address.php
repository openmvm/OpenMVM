<?php

namespace Main\Marketplace\Controllers\Account;

class Address extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
    }

    public function add()
    {
        $data['heading_title'] = lang('Heading.address_add', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/account/address/save', '', true);

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['heading_title'] = lang('Heading.address_edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/account/address/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        return $this->get_form($data);
    }

    public function delete()
    {
        // Query
        $query = $this->model_customer_customer_address->deleteCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

        $this->session->set('success', lang('Success.customer_address_delete', [], $this->language->getCurrentCode()));

        return redirect()->to($this->url->customerLink('marketplace/account/address', '', true));
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_address_book', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/address', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_address_book', [], $this->language->getCurrentCode());

        // Get customer addresses
        $data['customer_addresses'] = [];

        $customer_addresses = $this->model_customer_customer_address->getCustomerAddresses($this->customer->getId());

        foreach ($customer_addresses as $customer_address) {
            // Get country info
            $country_info = $this->model_localisation_country->getCountry($customer_address['country_id']);

            if (!empty($country_info) && !empty($country_info['address_format'])) {
                $address_format = $country_info['address_format'];
            } else {
                $address_format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city}, {zone}, {country}' . "\n" . lang('Text.telephone', [], $this->language->getCurrentCode()) . ': ' . '{telephone}';
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
            'title' => lang('Heading.my_address_book', [], $this->language->getCurrentCode()),
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
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_address_book', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/address', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );
            
            $customer_address_info = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add', [], $this->language->getCurrentCode()),
                'href' => '',
                'active' => true,
            );

            $customer_address_info = [];
        }

        if ($customer_address_info) {
            $data['firstname'] = $customer_address_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($customer_address_info) {
            $data['lastname'] = $customer_address_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($customer_address_info) {
            $data['address_1'] = $customer_address_info['address_1'];
        } else {
            $data['address_1'] = '';
        }

        if ($customer_address_info) {
            $data['address_2'] = $customer_address_info['address_2'];
        } else {
            $data['address_2'] = '';
        }

        if ($customer_address_info) {
            $data['city'] = $customer_address_info['city'];
        } else {
            $data['city'] = '';
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        if ($customer_address_info) {
            $data['country_id'] = $customer_address_info['country_id'];
        } else {
            $data['country_id'] = '';
        }

        if ($customer_address_info) {
            $data['zone_id'] = $customer_address_info['zone_id'];
        } else {
            $data['zone_id'] = '';
        }

        if ($customer_address_info) {
            $data['telephone'] = $customer_address_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->customerLink('marketplace/account/address', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.my_address_book', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\address_form', $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('firstname', lang('Entry.firstname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('address_1', lang('Entry.address_1', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('city', lang('Entry.city', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('country_id', lang('Entry.country', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('zone_id', lang('Entry.zone', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_customer_customer_address->editCustomerAddress($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()), $json_data);

                    $json['success']['toast'] = lang('Success.customer_address_edit', [], $this->language->getCurrentCode());

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
                } else {
                    // Query
                    $query = $this->model_customer_customer_address->addCustomerAddress($this->customer->getId(), $json_data);

                    $json['success']['toast'] = lang('Success.customer_address_add', [], $this->language->getCurrentCode());
                }

                $json['redirect'] = $this->url->customerLink('marketplace/account/address', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                if ($this->validation->hasError('firstname')) {
                    $json['error']['firstname'] = $this->validation->getError('firstname');
                }

                if ($this->validation->hasError('lastname')) {
                    $json['error']['lastname'] = $this->validation->getError('lastname');
                }

                if ($this->validation->hasError('address_1')) {
                    $json['error']['address-1'] = $this->validation->getError('address_1');
                }

                if ($this->validation->hasError('city')) {
                    $json['error']['city'] = $this->validation->getError('city');
                }

                if ($this->validation->hasError('country_id')) {
                    $json['error']['country'] = $this->validation->getError('country_id');
                }

                if ($this->validation->hasError('zone_id')) {
                    $json['error']['zone'] = $this->validation->getError('zone_id');
                }

                if ($this->validation->hasError('telephone')) {
                    $json['error']['telephone'] = $this->validation->getError('telephone');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
