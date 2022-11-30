<?php

namespace Main\Marketplace\Controllers\Checkout;

class Checkout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_component_component = new \Main\Marketplace\Models\Component\Component_Model();
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_customer_customer_address = new \Main\Marketplace\Models\Customer\Customer_Address_Model();
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_checkout_order = new \Main\Marketplace\Models\Checkout\Order_Model();
    }

    public function index()
    {
        if (empty($this->cart->getSellers())) {
            return redirect()->to(base_url('marketplace/checkout/cart'));
        }

        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.checkout', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/checkout/checkout', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.checkout', [], $this->language->getCurrentCode());

        if (!empty($this->request->getGet('seller_id'))) {
            $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);
            $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
        } else {
            $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
            $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
            $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
            $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
            $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
            $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
            $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);
            $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
        }

        $data['sellers'] = $this->cart->getSellers();

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.checkout', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Checkout\checkout',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function add_address()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('firstname', lang('Entry.firstname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('address_1', lang('Entry.address_1', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('city', lang('Entry.city', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('country_id', lang('Entry.country', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('zone_id', lang('Entry.zone', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $customer_address_id = $this->model_customer_customer_address->addCustomerAddress($this->customer->getId(), $this->request->getPost());

                if (!empty($customer_address_id) && !empty($this->request->getGet('type'))) {
                    if ($this->request->getGet('type') == 'payment_address') {
                        // Set the checkout payment address session
                        $this->session->set('checkout_payment_address_id', $customer_address_id);
                    } elseif ($this->request->getGet('type') == 'shipping_address') {
                        // Set the checkout shipping address session
                        $this->session->set('checkout_shipping_address_id', $customer_address_id);
                    } else {
                        // No checkout address to be set
                    }
                }

                $json['success'] = true;
            } else {
                // Errors
                if ($this->validation->hasError('firstname')) {
                    $json['error']['firstname'] = $this->validation->getError('firstname');
                } else {
                    $json['error']['firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $json['error']['lastname'] = $this->validation->getError('lastname');
                } else {
                    $json['error']['lastname'] = '';
                }

                if ($this->validation->hasError('address_1')) {
                    $json['error']['address_1'] = $this->validation->getError('address_1');
                } else {
                    $json['error']['address_1'] = '';
                }

                if ($this->validation->hasError('city')) {
                    $json['error']['city'] = $this->validation->getError('city');
                } else {
                    $json['error']['city'] = '';
                }

                if ($this->validation->hasError('country_id')) {
                    $json['error']['country'] = $this->validation->getError('country_id');
                } else {
                    $json['error']['country'] = '';
                }

                if ($this->validation->hasError('zone_id')) {
                    $json['error']['zone'] = $this->validation->getError('zone_id');
                } else {
                    $json['error']['zone'] = '';
                }

                if ($this->validation->hasError('telephone')) {
                    $json['error']['telephone'] = $this->validation->getError('telephone');
                } else {
                    $json['error']['telephone'] = '';
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function payment_address()
    {
        if ($this->customer->isLoggedIn()) {
            // Get customer addresses
            $data['customer_addresses'] = [];

            $customer_addresses = $this->model_customer_customer_address->getCustomerAddresses($this->customer->getId());

            foreach ($customer_addresses as $customer_address) {
                // Get country info
                $country_info = $this->model_localisation_country->getCountry($customer_address['country_id']);

                if (!empty($country_info) && !empty($country_info['address_format'])) {
                    $address_format = $country_info['address_format'];
                } else {
                    $address_format = '{firstname} {lastname}, {address_1}, {address_2}, {city}, {zone}, {country} ({telephone})';
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
                    ', ,',
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
                    ', ',
                ];

                $address = nl2br(str_replace($find, $replace, $address_format));

                $data['customer_addresses'][] = [
                    'customer_address_id' => $customer_address['customer_address_id'],
                    'address' => $address,
                ];
            }

            if ($this->session->has('checkout_payment_address_id')) {
                $data['checkout_payment_address_id'] = $this->session->get('checkout_payment_address_id');
            } else {
                $data['checkout_payment_address_id'] = 0;
            }

            if (!empty($this->request->getGet('seller_id'))) {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
            } else {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', '', true);
                
                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', '', true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
            }

            $data['add_address'] = $this->url->customerLink('marketplace/checkout/checkout/add_address', '', true);

            $data['countries'] = $this->model_localisation_country->getCountries();

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_payment_address',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function set_payment_address()
    {
        $json = [];

        if (!empty($this->request->getGet('customer_address_id'))) {
            // Set the checkout payment address session
            $this->session->set('checkout_payment_address_id', $this->request->getGet('customer_address_id'));

            // Remove the checkout payment method session
            if ($this->session->has('checkout_payment_method_code')) {
                $this->session->remove('checkout_payment_method_code');
            }
        }

        return $this->response->setJSON($json);
    }

    public function shipping_address()
    {
        if ($this->customer->isLoggedIn()) {
            // Get customer addresses
            $data['customer_addresses'] = [];

            $customer_addresses = $this->model_customer_customer_address->getCustomerAddresses($this->customer->getId());

            foreach ($customer_addresses as $customer_address) {
                // Get country info
                $country_info = $this->model_localisation_country->getCountry($customer_address['country_id']);

                if (!empty($country_info) && !empty($country_info['address_format'])) {
                    $address_format = $country_info['address_format'];
                } else {
                    $address_format = '{firstname} {lastname}, {address_1}, {address_2}, {city}, {zone}, {country} ({telephone})';
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
                    ', ,',
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
                    ', ',
                ];

                $address = nl2br(str_replace($find, $replace, $address_format));

                $data['customer_addresses'][] = [
                    'customer_address_id' => $customer_address['customer_address_id'],
                    'address' => $address,
                ];
            }

            if ($this->session->has('checkout_shipping_address_id')) {
                $data['checkout_shipping_address_id'] = $this->session->get('checkout_shipping_address_id');
            } else {
                $data['checkout_shipping_address_id'] = 0;
            }

            // Get cart sellers
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

            $has_shipping = false;

            foreach ($sellers as $seller) {
                if ($this->cart->hasShipping($seller['seller_id'])) {
                    $has_shipping = true;

                    break;
                }
            }

            $data['has_shipping'] = $has_shipping;

            if (!empty($this->request->getGet('seller_id'))) {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
            } else {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', '', true);
                
                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', '', true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
            }

            $data['add_address'] = $this->url->customerLink('marketplace/checkout/checkout/add_address', '', true);

            $data['countries'] = $this->model_localisation_country->getCountries();

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_shipping_address',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function set_shipping_address()
    {
        $json = [];

        if (!empty($this->request->getGet('customer_address_id'))) {
            // Set the checkout shipping address session
            $this->session->set('checkout_shipping_address_id', $this->request->getGet('customer_address_id'));

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
                if ($this->session->has('checkout_shipping_method_' . $seller['seller_id'])) {
                    $this->session->remove('checkout_shipping_method_' . $seller['seller_id']);
                }
            }
        }

        // Remove the checkout payment method session
        if ($this->session->has('checkout_payment_method_code')) {
            $this->session->remove('checkout_payment_method_code');
        }

        return $this->response->setJSON($json);
    }

    public function shipping_method()
    {
        if ($this->customer->isLoggedIn()) {
            // Get shipping address
            if ($this->session->has('checkout_shipping_address_id')) {
                $customer_address_id = $this->session->get('checkout_shipping_address_id');
            } else {
                $customer_address_id = 0;
            }

            // Get cart sellers
            $data['sellers'] = [];

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
                // Get available shipping methods
                $shipping_method_data = [];

                $shipping_methods = $this->model_component_component->getInstalledComponents('shipping_method');

                foreach ($shipping_methods as $shipping_method) {
                    $namespace = '\Main\Marketplace\Models\Component\Shipping_Method\\' . $shipping_method['value'] . '_Model';

                    $this->{'model_component_shipping_method_' . strtolower($shipping_method['value'])} = new $namespace;

                    $method = $this->{'model_component_shipping_method_' . strtolower($shipping_method['value'])}->method($customer_address_id, $seller['seller_id']);

                    if ($method) {
                        $string = ['_', '.'];
                        $replace = ['-', '-'];

                        $shipping_method_data[] = [
                            'id' => str_replace($string, $replace, strtolower($method['code'])),
                            'code' => $method['code'],
                            'name' => $method['name'],
                            'sort_order' => $method['sort_order'],
                            'quote_data' => $method['quote_data'],
                        ];    
                    }
                }

                $sort_order = [];

                foreach ($shipping_method_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $shipping_method_data);

                $data['sellers'][] = [
                    'seller_id' => $seller['seller_id'],
                    'store_name' => $seller['store_name'],
                    'shipping_method' => $shipping_method_data,
                    'has_shipping' => $this->cart->hasShipping($seller['seller_id']),
                ];
            }

            foreach ($sellers as $seller) {
                if ($this->session->has('checkout_shipping_method_' . $seller['seller_id'])) {
                    $checkout_shipping_method = $this->session->get('checkout_shipping_method_' . $seller['seller_id']);
                    
                    $data['checkout_shipping_method_' . $seller['seller_id']]['code'] = $checkout_shipping_method['code'];
                } else {
                    $data['checkout_shipping_method_' . $seller['seller_id']]['code'] = '';
                }
            }

            // Check if cart has shipping
            $has_shipping = false;

            foreach ($sellers as $seller) {
                if ($this->cart->hasShipping($seller['seller_id'])) {
                    $has_shipping = true;

                    break;
                }
            }

            $data['has_shipping'] = $has_shipping;

            if (!empty($this->request->getGet('seller_id'))) {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
            } else {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', '', true);
                
                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', '', true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
            }

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_shipping_method',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function set_shipping_method()
    {
        $json = [];

        if (!empty($this->request->getGet('seller_id')) && !empty($this->request->getGet('code'))) {
            // Set the checkout shipping method session
            $shipping_method_data = [
                'code' => $this->request->getGet('code'),
                'cost' => $this->request->getPost('cost'),
                'text' => $this->request->getPost('text'),
            ];

            $this->session->set('checkout_shipping_method_' . $this->request->getGet('seller_id'), $shipping_method_data);

            // Remove the checkout payment method session
            if ($this->session->has('checkout_payment_method_code')) {
                $this->session->remove('checkout_payment_method_code');
            }
        }

        return $this->response->setJSON($json);
    }

    public function payment_method()
    {
        if ($this->customer->isLoggedIn()) {
            // Get payment address
            if ($this->session->has('checkout_payment_address_id')) {
                $customer_address_id = $this->session->get('checkout_payment_address_id');
            } else {
                $customer_address_id = 0;
            }

            // Get cart sellers
            $data['sellers'] = [];

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

            $total_order_amount = 0;

            foreach ($sellers as $seller) {
                // Get order totals
                $order_totals = [];
                $order_total = 0;

                $order_total_data = [
                    'totals' => &$order_totals,
                    'taxes'  => &$taxes,
                    'total'  => &$order_total
                ];

                $results = $this->model_component_component->getInstalledComponents('order_total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->setting->get('component_order_total_' . strtolower($value['value']). '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->setting->get('component_order_total_' . strtolower($result['value']) . '_status')) {
                        $namespace = '\Main\Marketplace\Models\Component\Order_Total\\' . $result['value'] . '_Model';

                        $this->{'model_component_order_total_' . strtolower($result['value'])} = new $namespace;

                        $this->{'model_component_order_total_' . strtolower($result['value'])}->getTotal($order_total_data, $seller['seller_id']);

                    }
                }

                $total_order_amount += $order_total;
            }

            // Get available payment methods
            $data['payment_methods'] = [];

            $payment_methods = $this->model_component_component->getInstalledComponents('payment_method');

            foreach ($payment_methods as $payment_method) {
                $namespace = '\Main\Marketplace\Models\Component\Payment_Method\\' . $payment_method['value'] . '_Model';

                $this->{'model_component_payment_method_' . strtolower($payment_method['value'])} = new $namespace;

                $method = $this->{'model_component_payment_method_' . strtolower($payment_method['value'])}->method($customer_address_id, $total_order_amount);

                if ($method) {
                    $data['payment_methods'][] = [
                        'id' => str_replace('_', '-', strtolower($method['code'])),
                        'code' => $method['code'],
                        'name' => $method['name'],
                        'sort_order' => $method['sort_order'],
                    ];
                }
            }

			$sort_order = array();

			foreach ($data['payment_methods'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $data['payment_methods']);

            if ($this->session->has('checkout_payment_method_code')) {
                $data['checkout_payment_method_code'] = $this->session->get('checkout_payment_method_code');
            } else {
                $data['checkout_payment_method_code'] = '';
            }

            if (!empty($this->request->getGet('seller_id'))) {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
            } else {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', '', true);
                
                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', '', true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
            }

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_payment_method',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function set_payment_method()
    {
        $json = [];

        if (!empty($this->request->getGet('code'))) {
            // Set the checkout payment method session
            $this->session->set('checkout_payment_method_code', $this->request->getGet('code'));
        }

        return $this->response->setJSON($json);
    }

    public function update_quantity()
    {
        $json = [];

        if ($this->customer->getId()) {
            $customer_id = $this->customer->getId();
        } else {
            $customer_id = 0;
        }

        if (!empty($this->request->getPost('product_id'))) {
            $product_id = $this->request->getPost('product_id');
        } else {
            $product_id = 0;
        }

        // Get product info
        $product_info = $this->model_product_product->getProduct($product_id);

        if ($product_info) {
            $seller_id = $product_info['seller_id'];
        } else {
            $seller_id = 0;
        }

        if (!empty($this->request->getPost('quantity'))) {
            $quantity = $this->request->getPost('quantity');
        } else {
            $quantity = 1;
        }

        if (!empty($this->request->getPost('product_variant'))) {
            $options = json_decode($this->request->getPost('product_variant'), true);
        } else {
            $options = '';
        }

        // Check if the minimum purchase quantity
        if (!empty($options)) {
            if (is_array($options)) {
                $option_data = $options;

                asort($option_data);
            }
                
            // Get product variant info
            $product_variant_info = $this->model_product_product->getProductVariantByOptions($product_id, json_encode($option_data));

            if (!empty($product_variant_info)) {
                $minimum_purchase = $product_variant_info['minimum_purchase'];
            } else {
                $minimum_purchase = 1;
            }
        } else {
            if ($product_info) {
                $minimum_purchase = $product_info['minimum_purchase'];
            } else {
                $minimum_purchase = 1;
            }
        }

        // Check product quantity in the cart
        if (is_array($options)) {
            $option_data = $options;

            asort($option_data);
        } else {
            $option_data = null;
        }
            
        $cart_product = $this->cart->getProduct($customer_id, $seller_id, $product_id, $option_data);

        if (!empty($cart_product)) {
            $product_quantity_in_cart = $cart_product['quantity'];
        } else {
            $product_quantity_in_cart = 0;
        }

        if (($product_quantity_in_cart + $quantity) >= $minimum_purchase) {
            $this->cart->add($customer_id, $seller_id, $product_id, $quantity, $options);

            // Remove shipping method session
            if ($this->session->has('checkout_shipping_method_' . $seller_id)) {
                $this->session->remove('checkout_shipping_method_' . $seller_id);
            }

            // Remove the checkout payment method session
            if ($this->session->has('checkout_payment_method_code')) {
                $this->session->remove('checkout_payment_method_code');
            }

            $json['message'] = $options;

        } else {
            $json['error'] = lang('Error.product_minimum_purchase', ['minimum_purchase' => $minimum_purchase], $this->language->getCurrentCode());
        }

        return $this->response->setJSON($json);
    }

    public function cart()
    {
        if ($this->customer->isLoggedIn()) {
            // Get cart sellers
            $data['sellers'] = [];

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

            $total_products = 0;

            foreach ($sellers as $seller) {
                // Get cart products
                $product_data = [];

                $products = $this->cart->getProducts($seller['seller_id']);

                foreach ($products as $product) {
                    // Image
                    if (ROOTPATH . 'public/assets/images' . $product['main_image']) {
                        $thumb = $this->image->resize($product['main_image'], 64, 64, true);
                    } else {
                        $thumb = $this->image->resize('no_image.png', 64, 64, true);
                    }

                    $product_data[] = [
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'thumb' => $thumb,
                        'price' => $this->currency->format($product['price'], $this->currency->getCurrentCode()),
                        'quantity' => $product['quantity'],
                        'total' => $this->currency->format($product['total'], $this->currency->getCurrentCode()),
                        'option' => $product['option'],
                        'product_variant' => $product['option_ids'],
                        'href' => $this->url->customerLink('marketplace/product/product/get/' . $product['slug'] . '-p' . $product['product_id']),
                    ];
                }

                // Get order totals
                $order_totals = [];
                $order_total = 0;

                $order_total_data = [
                    'totals' => &$order_totals,
                    'taxes'  => &$taxes,
                    'total'  => &$order_total
                ];

                $results = $this->model_component_component->getInstalledComponents('order_total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->setting->get('component_order_total_' . strtolower($value['value']). '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->setting->get('component_order_total_' . strtolower($result['value']) . '_status')) {
                        $namespace = '\Main\Marketplace\Models\Component\Order_Total\\' . $result['value'] . '_Model';

                        $this->{'model_component_order_total_' . strtolower($result['value'])} = new $namespace;

                        $this->{'model_component_order_total_' . strtolower($result['value'])}->getTotal($order_total_data, $seller['seller_id']);

                    }
                }

                $sort_order = array();

                foreach ($order_totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $order_totals);

                $total_data = [];

                foreach ($order_totals as $order_total) {
                    $total_data[] = array(
                        'title' => $order_total['title'],
                        'text'  => $this->currency->format($order_total['value'], $this->currency->getCurrentCode())
                    );
                }

                $data['sellers'][] = [
                    'seller_id' => $seller['seller_id'],
                    'store_name' => $seller['store_name'],
                    'product' => $product_data,
                    'weight' => $this->weight->format($this->cart->getWeight($seller['seller_id']), $this->setting->get('setting_marketplace_weight_class_id'), lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode())),
                    'order_total' => $total_data,
                ];

                $total_products += $this->cart->getTotalProducts($seller['seller_id']);
            }

            $data['total_products'] = $total_products;

            // Payment Address
            $data['payment_address'] = '';

            if ($this->session->has('checkout_payment_address_id')) {
                // Get customer payment address
                $customer_payment_address = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->session->get('checkout_payment_address_id'));

                if ($customer_payment_address) {
                    // Get country info
                    $country_info = $this->model_localisation_country->getCountry($customer_payment_address['country_id']);

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
                        $customer_payment_address['firstname'],
                        $customer_payment_address['lastname'],
                        $customer_payment_address['address_1'],
                        $customer_payment_address['address_2'],
                        $customer_payment_address['city'],
                        $customer_payment_address['zone'],
                        $customer_payment_address['country'],
                        $customer_payment_address['telephone'],
                        "\n",
                    ];

                    $customer_payment_address = nl2br(str_replace($find, $replace, $address_format));

                    $data['payment_address'] = $customer_payment_address;
                }
            }

            // Shipping Address
            $data['shipping_address'] = '';

            if ($this->session->has('checkout_shipping_address_id')) {
                // Get customer shipping address
                $customer_shipping_address = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->session->get('checkout_shipping_address_id'));

                if ($customer_shipping_address) {
                    // Get country info
                    $country_info = $this->model_localisation_country->getCountry($customer_shipping_address['country_id']);

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
                        $customer_shipping_address['firstname'],
                        $customer_shipping_address['lastname'],
                        $customer_shipping_address['address_1'],
                        $customer_shipping_address['address_2'],
                        $customer_shipping_address['city'],
                        $customer_shipping_address['zone'],
                        $customer_shipping_address['country'],
                        $customer_shipping_address['telephone'],
                        "\n",
                    ];

                    $customer_shipping_address = nl2br(str_replace($find, $replace, $address_format));

                    $data['shipping_address'] = $customer_shipping_address;
                }
            }

            // Get cart sellers
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

            $has_shipping = false;

            foreach ($sellers as $seller) {
                if ($this->cart->hasShipping($seller['seller_id'])) {
                    $has_shipping = true;

                    break;
                }
            }

            $data['has_shipping'] = $has_shipping;

            if (!empty($this->request->getGet('seller_id'))) {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout cart update quantity
                $data['checkout_cart_update_quantity'] = $this->url->customerLink('marketplace/checkout/checkout/update_quantity', ['seller_id' => $this->request->getGet('seller_id')], true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', ['seller_id' => $this->request->getGet('seller_id')], true);
            } else {
                // Checkout payment
                $data['checkout_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/payment_address', '', true);
                $data['checkout_set_payment_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_address', '', true);
                $data['checkout_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/payment_method', '', true);
                $data['checkout_set_payment_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_payment_method', '', true);
                
                // Checkout shipping
                $data['checkout_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_address', '', true);
                $data['checkout_set_shipping_address'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_address', '', true);
                $data['checkout_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/shipping_method', '', true);
                $data['checkout_set_shipping_method'] = $this->url->customerLink('marketplace/checkout/checkout/set_shipping_method', '', true);

                // Checkout cart
                $data['checkout_cart'] = $this->url->customerLink('marketplace/checkout/checkout/cart', '', true);

                // Checkout cart update quantity
                $data['checkout_cart_update_quantity'] = $this->url->customerLink('marketplace/checkout/checkout/update_quantity', '', true);

                // Checkout confirm
                $data['checkout_confirm'] = $this->url->customerLink('marketplace/checkout/checkout/confirm', '', true);
            }

            $data['cart_remove_url'] = $this->url->customerLink('marketplace/checkout/cart/remove');

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_cart',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function confirm()
    {
        if ($this->customer->isLoggedIn()) {
            // Order data
            // Get order data
            $order_data = [];

            // Invoice prefix
            $order_data['invoice'] = $this->setting->get('setting_order_invoice_prefix');

            // Customer info
            $customer_info = $this->model_customer_customer->getCustomer($this->customer->getId());

            $order_data['customer_id'] = $customer_info['customer_id'];
            $order_data['customer_group_id'] = $customer_info['customer_group_id'];
            $order_data['firstname'] = $customer_info['firstname'];
            $order_data['lastname'] = $customer_info['lastname'];
            $order_data['email'] = $customer_info['email'];
            $order_data['telephone'] = $customer_info['telephone'];

            // Check checkout payment address
            if (!$this->session->has('checkout_payment_address_id')) {
                $data['errors'][] = lang('Error.checkout_payment_address', [], $this->language->getCurrentCode());
            } else {
                // Checkout payment address
                // Get checkout payment address info
                $checkout_payment_address_info = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->session->get('checkout_payment_address_id'));

                if ($checkout_payment_address_info) {
                    $order_data['payment_firstname'] = $checkout_payment_address_info['firstname'];
                    $order_data['payment_lastname'] = $checkout_payment_address_info['lastname'];
                    $order_data['payment_address_1'] = $checkout_payment_address_info['address_1'];
                    $order_data['payment_address_2'] = $checkout_payment_address_info['address_2'];
                    $order_data['payment_city'] = $checkout_payment_address_info['city'];
                    $order_data['payment_country_id'] = $checkout_payment_address_info['country_id'];

                    // Get country info
                    $country_info = $this->model_localisation_country->getCountry($checkout_payment_address_info['country_id']);

                    $order_data['payment_country'] = $country_info['name'];
                    $order_data['payment_zone_id'] = $checkout_payment_address_info['zone_id'];

                    // Get zone info
                    $zone_info = $this->model_localisation_zone->getZone($checkout_payment_address_info['zone_id']);

                    $order_data['payment_zone'] = $zone_info['name'];
                    $order_data['payment_telephone'] = $checkout_payment_address_info['telephone'];
                } else {
                    $data['errors'][] = lang('Error.checkout_payment_address', [], $this->language->getCurrentCode());
                }
            }

            // Get cart sellers
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

            $has_shipping = false;

            foreach ($sellers as $seller) {
                if ($this->cart->hasShipping($seller['seller_id'])) {
                    $has_shipping = true;

                    break;
                }
            }

            $data['has_shipping'] = $has_shipping;

            // Check checkout shipping address
            if (!$this->session->has('checkout_shipping_address_id')) {
                $data['errors'][] = lang('Error.checkout_shipping_address', [], $this->language->getCurrentCode());
            } else {
                // Checkout shipping address
                // Get checkout shipping address info
                $checkout_shipping_address_info = $this->model_customer_customer_address->getCustomerAddress($this->customer->getId(), $this->session->get('checkout_shipping_address_id'));

                if ($checkout_shipping_address_info) {
                    $order_data['shipping_firstname'] = $checkout_shipping_address_info['firstname'];
                    $order_data['shipping_lastname'] = $checkout_shipping_address_info['lastname'];
                    $order_data['shipping_address_1'] = $checkout_shipping_address_info['address_1'];
                    $order_data['shipping_address_2'] = $checkout_shipping_address_info['address_2'];
                    $order_data['shipping_city'] = $checkout_shipping_address_info['city'];
                    $order_data['shipping_country_id'] = $checkout_shipping_address_info['country_id'];

                    // Get country info
                    $country_info = $this->model_localisation_country->getCountry($checkout_shipping_address_info['country_id']);

                    $order_data['shipping_country'] = $country_info['name'];
                    $order_data['shipping_zone_id'] = $checkout_shipping_address_info['zone_id'];

                    // Get zone info
                    $zone_info = $this->model_localisation_zone->getZone($checkout_shipping_address_info['zone_id']);

                    $order_data['shipping_zone'] = $zone_info['name'];
                    $order_data['shipping_telephone'] = $checkout_shipping_address_info['telephone'];
                } else {
                    $data['errors'][] = lang('Error.checkout_shipping_address', [], $this->language->getCurrentCode());
                }
            }

            // Get cart sellers
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
                // Check checkout shipping method for each seller
                if ($this->cart->hasShipping($seller['seller_id'])) {
                    if (!$this->session->has('checkout_shipping_method_' . $seller['seller_id'])) {
                        $data['errors'][] = sprintf(lang('Error.checkout_shipping_method', [], $this->language->getCurrentCode()), $seller['store_name']);
                    } else {
                        // Checkout shipping method
                        $order_data['checkout_shipping_method'][$seller['seller_id']] = $this->session->get('checkout_shipping_method_' . $seller['seller_id']);
                    }
                } else {
                    // Checkout shipping method
                    $order_data['checkout_shipping_method'][$seller['seller_id']] = false;
                }
            }

            // Check checkout payment method
            if (!$this->session->has('checkout_payment_method_code')) {
                $data['errors'][] = lang('Error.checkout_payment_method', [], $this->language->getCurrentCode());
            } else {
                // Checkout payment method
                $order_data['payment_method_code'] = $this->session->get('checkout_payment_method_code');
                $order_data['payment_method_title'] = lang('Text.' . strtolower($this->session->get('checkout_payment_method_code')), [], $this->language->getCurrentCode());
            }

            // Order totals
            $order_data['total'] = 0;
            $order_data['totals'] = [];

            foreach ($sellers as $seller) {
                // Get order totals
                $order_totals = [];
                $order_total = 0;

                $order_total_data = [
                    'totals' => &$order_totals,
                    'taxes'  => &$taxes,
                    'total'  => &$order_total
                ];

                $results = $this->model_component_component->getInstalledComponents('order_total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->setting->get('component_order_total_' . strtolower($value['value']). '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->setting->get('component_order_total_' . strtolower($result['value']) . '_status')) {
                        $namespace = '\Main\Marketplace\Models\Component\Order_Total\\' . $result['value'] . '_Model';

                        $this->{'model_component_order_total_' . strtolower($result['value'])} = new $namespace;

                        $this->{'model_component_order_total_' . strtolower($result['value'])}->getTotal($order_total_data, $seller['seller_id']);

                    }
                }

                $order_data['total'] += $order_total_data['total'];

                $totals[$seller['seller_id']] = $order_total_data['totals'];
            }

            $order_data['totals'] = $totals;

            // Current currency
            $order_data['currency_id'] = $this->currency->getCurrentId();
            $order_data['currency_code'] = $this->currency->getCurrentCode();
            $order_data['currency_value'] = $this->currency->getCurrentValue();

            // Products
            $order_data['products'] = [];

            foreach ($sellers as $seller) {
                // Get cart products
                $products = $this->cart->getProducts($seller['seller_id']);

                foreach ($products as $product) {
                    $order_data['products'][] = [
                        'product_id' => $product['product_id'],
                        'seller_id' => $product['seller_id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'total' => $product['total'],
                        'option' => $product['option'],
                        'option_ids' => $product['option_ids'],
                    ];
                }
            }

            if (empty($data['errors'])) {
                // Add or edit order
                if ($this->session->has('checkout_order_id')) {
                    // Edit order
                    $order_id = $this->session->get('checkout_order_id');

                    $query = $this->model_checkout_order->editOrder($this->customer->getId(), $order_id, $order_data);
                } else {
                    // Add order
                    $order_id = $this->model_checkout_order->addOrder($this->customer->getId(), $order_data);

                    // Set session checkout order id
                    $this->session->set('checkout_order_id', $order_id);
                }

                // Checkout is ready    
                $checkout_payment_method_code = $this->session->get('checkout_payment_method_code');
                
                $namespace = '\Main\Marketplace\Controllers\Component\Payment_Method\\' . $checkout_payment_method_code;

                $this->payment_method = new $namespace;

                if (!empty($this->request->getGet('seller_id'))) {
                    $seller_id = $this->request->getGet('seller_id');
                } else {
                    $seller_id = 0;
                }
                
                $data['payment_method'] = $this->payment_method->index($seller_id);

                $data['message'] = sprintf(lang('Text.checkout_selected_payment_method', [], $this->language->getCurrentCode()), lang('Text.' . strtolower($checkout_payment_method_code), [], $this->language->getCurrentCode()));

            }

            // Libraries
            $data['language_lib'] = $this->language;

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Checkout\checkout_confirm',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }
}
