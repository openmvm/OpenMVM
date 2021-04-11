<?php

namespace Modules\OpenMVM\Order\Models;

class OrderModel extends \CodeIgniter\Model
{

  protected $table = 'order';
	protected $primaryKey = 'order_id';
  protected $allowedFields = ['order_id', 'store_id', 'invoice_no', 'invoice_prefix', 'user_id', 'user_group_id'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		$this->auth = new \App\Libraries\Auth;
		// Load Database
		$this->db = db_connect();
		// Load Models
		$this->userGroupModel = new \Modules\OpenMVM\User\Models\UserGroupModel;
	}

	public function addOrder($data = array())
	{
		$builder_order = $this->db->table('order');

		$builder_order->set('store_id', $data['store_id']);
		$builder_order->set('invoice_no', $data['invoice_no']);
		$builder_order->set('invoice_prefix', $data['invoice_prefix']);
		$builder_order->set('user_id', $data['user_id']);
		$builder_order->set('user_group_id', $data['user_group_id']);
		$builder_order->set('firstname', $data['firstname']);
		$builder_order->set('lastname', $data['lastname']);
		$builder_order->set('email', $data['email']);
		$builder_order->set('telephone', $data['telephone']);
		$builder_order->set('fax', $data['fax']);
		$builder_order->set('custom_field', $data['custom_field']);
		$builder_order->set('payment_firstname', $data['payment_firstname']);
		$builder_order->set('payment_lastname', $data['payment_lastname']);
		$builder_order->set('payment_company', $data['payment_company']);
		$builder_order->set('payment_address_1', $data['payment_address_1']);
		$builder_order->set('payment_address_2', $data['payment_address_2']);
		$builder_order->set('payment_postal_code', $data['payment_postal_code']);
		$builder_order->set('payment_country_id', $data['payment_country_id']);
		$builder_order->set('payment_country', $data['payment_country']);
		$builder_order->set('payment_state_id', $data['payment_state_id']);
		$builder_order->set('payment_state', $data['payment_state']);
		$builder_order->set('payment_city_id', $data['payment_city_id']);
		$builder_order->set('payment_city', $data['payment_city']);
		$builder_order->set('payment_district_id', $data['payment_district_id']);
		$builder_order->set('payment_district', $data['payment_district']);
		$builder_order->set('payment_address_format', $data['payment_address_format']);
		$builder_order->set('payment_custom_field', $data['payment_custom_field']);
		$builder_order->set('payment_method', $data['payment_method']);
		$builder_order->set('payment_code', $data['payment_code']);
		$builder_order->set('comment', $data['comment']);
		$builder_order->set('total', $data['total']);
		$builder_order->set('order_status_id', $data['order_status_id']);
		$builder_order->set('affiliate_id', $data['affiliate_id']);
		$builder_order->set('commission', $data['commission']);
		$builder_order->set('marketing_id', $data['marketing_id']);
		$builder_order->set('tracking', $data['tracking']);
		$builder_order->set('language_id', $data['language_id']);
		$builder_order->set('currency_id', $data['currency_id']);
		$builder_order->set('currency_code', $data['currency_code']);
		$builder_order->set('currency_value', $data['currency_value']);
		$builder_order->set('ip', $data['ip']);
		$builder_order->set('forwarded_ip', $data['forwarded_ip']);
		$builder_order->set('user_agent', $data['user_agent']);
		$builder_order->set('accept_language', $data['accept_language']);
		$builder_order->set('date_added', date("Y-m-d H:i:s",now()));
		$builder_order->set('date_modified', date("Y-m-d H:i:s",now()));

		$builder_order->insert();

		$order_id = $this->db->insertID();

		return $order_id;
	}

	public function editOrder($data = array(), $order_id)
	{
		$builder_order = $this->db->table('order');

		$builder_order->set('store_id', $data['store_id']);
		$builder_order->set('invoice_no', $data['invoice_no']);
		$builder_order->set('invoice_prefix', $data['invoice_prefix']);
		$builder_order->set('user_id', $data['user_id']);
		$builder_order->set('user_group_id', $data['user_group_id']);
		$builder_order->set('firstname', $data['firstname']);
		$builder_order->set('lastname', $data['lastname']);
		$builder_order->set('email', $data['email']);
		$builder_order->set('telephone', $data['telephone']);
		$builder_order->set('fax', $data['fax']);
		$builder_order->set('custom_field', $data['custom_field']);
		$builder_order->set('payment_firstname', $data['payment_firstname']);
		$builder_order->set('payment_lastname', $data['payment_lastname']);
		$builder_order->set('payment_company', $data['payment_company']);
		$builder_order->set('payment_address_1', $data['payment_address_1']);
		$builder_order->set('payment_address_2', $data['payment_address_2']);
		$builder_order->set('payment_postal_code', $data['payment_postal_code']);
		$builder_order->set('payment_country_id', $data['payment_country_id']);
		$builder_order->set('payment_country', $data['payment_country']);
		$builder_order->set('payment_state_id', $data['payment_state_id']);
		$builder_order->set('payment_state', $data['payment_state']);
		$builder_order->set('payment_city_id', $data['payment_city_id']);
		$builder_order->set('payment_city', $data['payment_city']);
		$builder_order->set('payment_district_id', $data['payment_district_id']);
		$builder_order->set('payment_district', $data['payment_district']);
		$builder_order->set('payment_address_format', $data['payment_address_format']);
		$builder_order->set('payment_custom_field', $data['payment_custom_field']);
		$builder_order->set('payment_method', $data['payment_method']);
		$builder_order->set('payment_code', $data['payment_code']);
		$builder_order->set('comment', $data['comment']);
		$builder_order->set('total', $data['total']);
		$builder_order->set('order_status_id', $data['order_status_id']);
		$builder_order->set('affiliate_id', $data['affiliate_id']);
		$builder_order->set('commission', $data['commission']);
		$builder_order->set('marketing_id', $data['marketing_id']);
		$builder_order->set('tracking', $data['tracking']);
		$builder_order->set('language_id', $data['language_id']);
		$builder_order->set('currency_id', $data['currency_id']);
		$builder_order->set('currency_code', $data['currency_code']);
		$builder_order->set('currency_value', $data['currency_value']);
		$builder_order->set('ip', $data['ip']);
		$builder_order->set('forwarded_ip', $data['forwarded_ip']);
		$builder_order->set('user_agent', $data['user_agent']);
		$builder_order->set('accept_language', $data['accept_language']);
		$builder_order->set('date_modified', date("Y-m-d H:i:s",now()));

		$builder_order->where('order_id', $order_id);

		$query = $builder_order->update();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function addOrderShipping($data = array(), $order_id, $store_id)
	{
		$builder = $this->db->table('order_shipping');
		$builder->where('order_id', $order_id);
		$builder->where('store_id', $store_id);
		$builder->delete();

		$builder_order_shipping = $this->db->table('order_shipping');

		$builder_order_shipping->set('order_id', $order_id);
		$builder_order_shipping->set('store_id', $store_id);
		$builder_order_shipping->set('shipping_firstname', $data['shipping_firstname']);
		$builder_order_shipping->set('shipping_lastname', $data['shipping_lastname']);
		$builder_order_shipping->set('shipping_company', $data['shipping_company']);
		$builder_order_shipping->set('shipping_address_1', $data['shipping_address_1']);
		$builder_order_shipping->set('shipping_address_2', $data['shipping_address_2']);
		$builder_order_shipping->set('shipping_postal_code', $data['shipping_postal_code']);
		$builder_order_shipping->set('shipping_country_id', $data['shipping_country_id']);
		$builder_order_shipping->set('shipping_country', $data['shipping_country']);
		$builder_order_shipping->set('shipping_state_id', $data['shipping_state_id']);
		$builder_order_shipping->set('shipping_state', $data['shipping_state']);
		$builder_order_shipping->set('shipping_city_id', $data['shipping_city_id']);
		$builder_order_shipping->set('shipping_city', $data['shipping_city']);
		$builder_order_shipping->set('shipping_district_id', $data['shipping_district_id']);
		$builder_order_shipping->set('shipping_district', $data['shipping_district']);
		$builder_order_shipping->set('shipping_address_format', $data['shipping_address_format']);
		$builder_order_shipping->set('shipping_custom_field', $data['shipping_custom_field']);
		$builder_order_shipping->set('shipping_method', $data['shipping_method']);
		$builder_order_shipping->set('shipping_code', $data['shipping_code']);

		$builder_order_shipping->insert();

		$order_shipping_id = $this->db->insertID();

		return $order_shipping_id;
	}

	public function addOrderProduct($data = array(), $order_id, $store_id)
	{
		foreach ($data['products'] as $product) {
			$builder_order_shipping = $this->db->table('order_product');

			$builder_order_shipping->set('order_id', $order_id);
			$builder_order_shipping->set('store_id', $store_id);
			$builder_order_shipping->set('product_id', $product['product_id']);
			$builder_order_shipping->set('name', $product['name']);
			$builder_order_shipping->set('model', $product['model']);
			$builder_order_shipping->set('quantity', $product['quantity']);
			$builder_order_shipping->set('price', $product['price']);
			$builder_order_shipping->set('total', $product['total']);
			$builder_order_shipping->set('tax', $product['tax']);
			$builder_order_shipping->set('reward', $product['reward']);

			$builder_order_shipping->insert();
		}
	}

	public function deleteOrderProduct($order_id)
	{
		$builder = $this->db->table('order_product');
		$builder->where('order_id', $order_id);
		$builder->delete();
	}

	public function addOrderTotal($totals = array(), $order_id, $store_id)
	{
		foreach ($totals as $data) {
			$builder_order_shipping = $this->db->table('order_total');

			$builder_order_shipping->set('order_id', $order_id);
			$builder_order_shipping->set('store_id', $store_id);
			$builder_order_shipping->set('code', $data['code']);
			$builder_order_shipping->set('title', $data['title']);
			$builder_order_shipping->set('value', $data['value']);
			$builder_order_shipping->set('sort_order', $data['sort_order']);

			$builder_order_shipping->insert();
		}
	}

	public function deleteOrderTotal($order_id)
	{
		$builder = $this->db->table('order_total');
		$builder->where('order_id', $order_id);
		$builder->delete();
	}
			
	public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false)
	{
		// Update order status
		$builder_order = $this->db->table('order');

		$builder_order->set('order_status_id', $order_status_id);
		$builder_order->set('date_modified', date("Y-m-d H:i:s",now()));

		$builder_order->where('order_id', $order_id);

		$builder_order->update();

		// Add order history
		$builder_order_history = $this->db->table('order_history');

		$builder_order_history->set('order_id', $order_id);
		$builder_order_history->set('order_status_id', $order_status_id);
		$builder_order_history->set('comment', $comment);
		$builder_order_history->set('notify', $notify);
		$builder_order_history->set('date_added', date("Y-m-d H:i:s",now()));

		$builder_order_history->insert();
	}

	public function getOrders($data = array(), $user_id, $language_id) {
		$builder = $this->db->table('order o');
    $builder->select('o.order_id, o.firstname, o.lastname, os.name as status, o.date_added, o.total, o.currency_code, o.currency_value', false);
    $builder->join('order_status os', 'o.order_status_id = os.order_status_id', 'left');

		$builder->where('o.user_id', $user_id);
		$builder->where('o.order_status_id >', 0);
		$builder->where('os.language_id', $language_id);

    $builder->orderBy('o.order_id', 'DESC');

    if (!empty($data['start']) || !empty($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $builder->limit($data['limit'], $data['start']);
    }

    $query = $builder->get();

		return $query->getResultArray();
	}

	public function getOrder($order_id, $user_id) {
		$builder_order = $this->db->table('order');
		$builder_order->where('order_id', $order_id);
		$builder_order->where('user_id', $user_id);
		$builder_order->where('user_id !=', 0);
		$builder_order->where('order_status_id >', 0);

    $query_order = $builder_order->get();

    $row_order = $query_order->getRow();

    if ($row_order) {
			return array(
				'order_id'                => $row_order->order_id,
				'invoice_no'              => $row_order->invoice_no,
				'invoice_prefix'          => $row_order->invoice_prefix,
				'store_id'                => $row_order->store_id,
				'store_name'              => $row_order->store_name,
				'store_url'               => $row_order->store_url,
				'customer_id'             => $row_order->customer_id,
				'firstname'               => $row_order->firstname,
				'lastname'                => $row_order->lastname,
				'telephone'               => $row_order->telephone,
				'email'                   => $row_order->email,
				'payment_firstname'       => $row_order->payment_firstname,
				'payment_lastname'        => $row_order->payment_lastname,
				'payment_company'         => $row_order->payment_company,
				'payment_address_1'       => $row_order->payment_address_1,
				'payment_address_2'       => $row_order->payment_address_2,
				'payment_postal_code'     => $row_order->payment_postal_code,
				'payment_country_id'      => $row_order->payment_country_id,
				'payment_country'         => $row_order->payment_country,
				'payment_state_id'        => $row_order->payment_state_id,
				'payment_state'           => $row_order->payment_state,
				'payment_city_id'         => $row_order->payment_city_id,
				'payment_city'            => $row_order->payment_city,
				'payment_district_id'     => $row_order->payment_district_id,
				'payment_district'        => $row_order->payment_district,
				'payment_address_format'  => $row_order->payment_address_format,
				'payment_method'          => $row_order->payment_method,
				'shipping_firstname'      => $row_order->shipping_firstname,
				'shipping_lastname'       => $row_order->shipping_lastname,
				'shipping_company'        => $row_order->shipping_company,
				'shipping_address_1'      => $row_order->shipping_address_1,
				'shipping_address_2'      => $row_order->shipping_address_2,
				'shipping_postal_code'    => $row_order->shipping_postal_code,
				'shipping_country_id'     => $row_order->shipping_country_id,
				'shipping_country'        => $row_order->shipping_country,
				'shipping_state_id'       => $row_order->shipping_state_id,
				'shipping_state'          => $row_order->shipping_state,
				'shipping_city_id'        => $row_order->shipping_city_id,
				'shipping_city'           => $row_order->shipping_city,
				'shipping_district_id'    => $row_order->shipping_district_id,
				'shipping_district'       => $row_order->shipping_district,
				'shipping_address_format' => $row_order->shipping_address_format,
				'shipping_method'         => $row_order->shipping_method,
				'comment'                 => $row_order->comment,
				'total'                   => $row_order->total,
				'order_status_id'         => $row_order->order_status_id,
				'language_id'             => $row_order->language_id,
				'currency_id'             => $row_order->currency_id,
				'currency_code'           => $row_order->currency_code,
				'currency_value'          => $row_order->currency_value,
				'date_modified'           => $row_order->date_modified,
				'date_added'              => $row_order->date_added,
				'ip'                      => $row_order->ip
			);
    } else {
			return false;
    }
	}

  public function getOrderStores($order_id)
  {
  	// Get cart stores
  	$store_data = array();

		$builder_cart = $this->db->table('order_product');
		$builder_cart->select('store_id')->distinct();
		$builder_cart->where('order_id', $order_id);
		$query_cart = $builder_cart->get();
  
		foreach ($query_cart->getResult() as $result_cart)
		{
			// Get store
			$builder_store = $this->db->table('store');
			$builder_store->select('*');
			$builder_store->join('store_description', 'store_description.store_id = store.store_id');
			$builder_store->where('store.store_id', $result_cart->store_id);

			$query_store = $builder_store->get();
			
			$row_store = $query_store->getRow();

			if ($row_store) {
				$store_data[] = array(
					'store_id' => $row_store->store_id,
					'name' => $row_store->name,
					'logo' => $row_store->logo,
				);
			}
		}

		return $store_data;
	}

	public function getOrderProduct($order_id, $store_id, $order_product_id) {
		$builder = $this->db->table('order_product');
		$builder->where('order_id', $order_id);
		$builder->where('store_id', $store_id);
		$builder->where('order_product_id', $order_product_id);

		$query = $builder->get();

		return $query->getRowArray();
	}

	public function getOrderProducts($order_id, $store_id) {
		$builder = $this->db->table('order_product');
		$builder->where('order_id', $order_id);
		$builder->where('store_id', $store_id);

		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getOrderShipping($order_id, $store_id) {
		$builder = $this->db->table('order_shipping');
		$builder->where('order_id', $order_id);
		$builder->where('store_id', $store_id);

		$query = $builder->get();

		return $query->getRowArray();
	}

	public function getOrderTotals($order_id, $store_id) {
		$builder = $this->db->table('order_total');
		$builder->where('order_id', $order_id);
		$builder->where('store_id', $store_id);

    $builder->orderBy('sort_order', 'ASC');

		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getOrderHistories($order_id, $language_id) {
		$builder = $this->db->table('order_history oh');
    $builder->select('date_added, os.name AS status, oh.comment, oh.notify', false);
    $builder->join('order_status os', 'oh.order_status_id = os.order_status_id', 'left');

		$builder->where('oh.order_id', $order_id);
		$builder->where('os.language_id', $language_id);

    $builder->orderBy('oh.date_added', 'DESC');

		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getTotalOrders($data = array(), $user_id, $language_id) {
		$builder = $this->db->table('order o');
    $builder->join('order_status os', 'o.order_status_id = os.order_status_id', 'left');

		$builder->where('o.user_id', $user_id);
		$builder->where('o.order_status_id >', 0);
		$builder->where('os.language_id', $language_id);
		
    $query = $builder->countAllResults();

    return $query;
	}

	public function getTotalOrderProductsByOrderId($order_id, $store_id = null) {
		$builder = $this->db->table('order_product');

		$builder->where('order_id', $order_id);

		if ($store_id !== null) {
			$builder->where('store_id', $store_id);
		}
		
    $query = $builder->countAllResults();

    return $query;
	}
}