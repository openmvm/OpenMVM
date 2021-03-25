<?php

namespace App\Libraries;

class Cart
{
	private $sessionId;
	private $userId;

	public function __construct()
	{
		// Load Libraries
		$this->session = session();
		$this->user = new \App\Libraries\User;
		$this->auth = new \App\Libraries\Auth;
		$this->language = new \App\Libraries\Language;
		// Load Helper
		helper(['date']);
		// Load Database
		$this->db = db_connect();

		// Set cart session ID if not already set
		if ($this->session->has('cart_session_id')) {
			$this->sessionId = $this->session->get('cart_session_id');
		} else {
			$this->sessionId = $this->session->set('cart_session_id', $this->auth->sessionId());
		}

		// Define user ID
  	if ($this->user->isLogged()) {
  		$this->userId = $this->user->getId();
  	} else {
  		$this->userId = 0;
  	}

		// Get all expired carts without user ID and remove it
		$builder_cart = $this->db->table('cart');
		$builder_cart->where('user_id', 0);
		$builder_cart->where('date_added <', 'DATE_SUB(NOW(), INTERVAL 1 HOUR)');
		$builder_cart->delete();

		// If user is logged
		if ($this->user->isLogged()) {
			// Update cart session ID
			$builder_cart = $this->db->table('cart');
			$builder_cart->set('cart_session_id', $this->sessionId());
			$builder_cart->where('user_id', $this->user->getId());
			$builder_cart->update();

			// If user is logged, update the cart that has user ID = 0 and the user cart session ID
			$builder_cart = $this->db->table('cart');
			$builder_cart->where('user_id', 0);
			$builder_cart->where('cart_session_id', $this->sessionId());
			$query   = $builder_cart->get();
			foreach ($query->getResult() as $row)
			{
				// Add cart
				$this->add($row->store_id, $row->product_id, $row->quantity, $row->option);
				// Remove cart
				$builder_cart = $this->db->table('cart');
				$builder_cart->where('cart_id', $row->cart_id);
				$builder_cart->delete();
			}
		}

	}

  public function getProducts($store_id)
  {
  	$product_data = array();

  	// Get user carts
		$builder_cart = $this->db->table('cart');
		$builder_cart->where('user_id', $this->userId);
		$builder_cart->where('store_id', $store_id);
		$builder_cart->where('cart_session_id', $this->sessionId());

		$query_cart = $builder_cart->get();
  
		foreach ($query_cart->getResult() as $result_cart)
		{
			// Get product
			$builder_product = $this->db->table('product');
			$builder_product->select('*');
			$builder_product->join('product_description', 'product_description.product_id = product.product_id');
			$builder_product->where('product.store_id', $store_id);
			$builder_product->where('product.product_id', $result_cart->product_id);

			$query_product = $builder_product->get();
			
			$row_product = $query_product->getRow();

			if ($row_product && ($result_cart->quantity > 0)) {
				$product_data[] = array(
					'product_id' => $row_product->product_id,
					'store_id' => $row_product->store_id,
					'name' => $row_product->name,
					'image' => $row_product->image,
					'price' => $row_product->price,
					'quantity' => $result_cart->quantity,
				);
			} else {
				$this->remove($result_cart->cart_id);
			}
		}

		return $product_data;
	}

  public function getStores()
  {
  	// Get cart stores
  	$store_data = array();

		$builder_cart = $this->db->table('cart');
		$builder_cart->select('store_id')->distinct();
		$builder_cart->where('user_id', $this->userId);
		$builder_cart->where('cart_session_id', $this->sessionId());
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

  public function add($store_id, $product_id, $quantity = 1, $option = array())
  {
		$builder_cart = $this->db->table('cart');
		$builder_cart->where('user_id', $this->userId);
		$builder_cart->where('cart_session_id', $this->sessionId());
		$builder_cart->where('product_id', $product_id);
    
		$total = $builder_cart->countAllResults();

		if (!$total) {
			// Insert cart
			$builder_cart = $this->db->table('cart');
			$builder_cart->set('user_id', $this->userId);
			$builder_cart->set('store_id', $store_id);
			$builder_cart->set('cart_session_id', $this->sessionId());
			$builder_cart->set('product_id', $product_id);
			$builder_cart->set('option', json_encode($option));
			$builder_cart->set('quantity', $quantity);
			$builder_cart->set('date_added', date("Y-m-d H:i:s",now()));
			$builder_cart->insert();
		} else {
			// Update cart
			$builder_cart = $this->db->table('cart');
			$builder_cart->where('user_id', $this->userId);
			$builder_cart->where('store_id', $store_id);
			$builder_cart->where('cart_session_id', $this->sessionId());
			$builder_cart->where('product_id', $product_id);
			$builder_cart->where('option', json_encode($option));
			$builder_cart->set('quantity', '(quantity + ' . $quantity . ')', false);
			$builder_cart->update();
		}
  }

	public function remove($cart_id) {
		return true;
	}

	public function sessionId() {
		return $this->sessionId;
	}
}