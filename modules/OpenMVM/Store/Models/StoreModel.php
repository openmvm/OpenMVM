<?php

namespace Modules\OpenMVM\Store\Models;

class StoreModel extends \CodeIgniter\Model
{

  protected $table = 'store';
	protected $primaryKey = 'store_id';
  protected $allowedFields = ['store_id', 'user_id', 'image', 'sort_order', 'status', 'date_added', 'date_modified'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		$this->auth = new \App\Libraries\Auth;
		$this->text = new \App\Libraries\Text;
		// Load Database
		$this->db = db_connect();
	}

	public function addStore($data = array(), $user_id)
	{
		$builder = $this->db->table('store');

		if ($user_id !== null) {
			$builder->set('user_id', $user_id);
		}

		if ($data['name'] !== null) {
			$builder->set('name', $data['name']);
			$builder->set('slug', $this->text->slugify($data['name']));
		}

		if ($data['logo'] !== null) {
			$builder->set('logo', $data['logo']);
		}

		if ($data['wallpaper'] !== null) {
			$builder->set('wallpaper', $data['wallpaper']);
		}

		if ($data['viewed'] !== null) {
			$builder->set('viewed', $data['viewed']);
		}

		if ($data['sort_order'] !== null) {
			$builder->set('sort_order', $data['sort_order']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

		if ($data['date_added'] !== null) {
			$builder->set('date_added', date("Y-m-d H:i:s",now()));
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

		// Shipping origin
		if ($data['shipping_origin_country_id'] !== null) {
			$builder->set('shipping_origin_country_id', $data['shipping_origin_country_id']);
		}

		if ($data['shipping_origin_state_id'] !== null) {
			$builder->set('shipping_origin_state_id', $data['shipping_origin_state_id']);
		}

		if ($data['shipping_origin_city_id'] !== null) {
			$builder->set('shipping_origin_city_id', $data['shipping_origin_city_id']);
		}

		if ($data['shipping_origin_district_id'] !== null) {
			$builder->set('shipping_origin_district_id', $data['shipping_origin_district_id']);
		}

		$builder->insert($query_data);

		$store_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'store_id'          => $store_id,
        'user_id'           => $user_id,
        'language_id'       => $language_id,
        'description'       => $value['description'],
        'short_description' => $value['short_description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'tags'              => $value['tags'],
      );

			$builder = $this->db->table('store_description');

			$builder->insert($query_data_2);
		}

		return $store_id;
	}

	public function editStore($data = array(), $store_id, $user_id)
	{
		$builder = $this->db->table('store');

		if ($data['name'] !== null) {
			$builder->set('name', $data['name']);
			$builder->set('slug', $this->text->slugify($data['name']));
		}

		if ($data['logo'] !== null) {
			$builder->set('logo', $data['logo']);
		}

		if ($data['wallpaper'] !== null) {
			$builder->set('wallpaper', $data['wallpaper']);
		}

		if ($data['viewed'] !== null) {
			$builder->set('viewed', $data['viewed']);
		}

		if ($data['sort_order'] !== null) {
			$builder->set('sort_order', $data['sort_order']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

		if ($data['date_added'] !== null) {
			$builder->set('date_added', date("Y-m-d H:i:s",now()));
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

		// Shipping origin
		if ($data['shipping_origin_country_id'] !== null) {
			$builder->set('shipping_origin_country_id', $data['shipping_origin_country_id']);
		}

		if ($data['shipping_origin_state_id'] !== null) {
			$builder->set('shipping_origin_state_id', $data['shipping_origin_state_id']);
		}

		if ($data['shipping_origin_city_id'] !== null) {
			$builder->set('shipping_origin_city_id', $data['shipping_origin_city_id']);
		}

		if ($data['shipping_origin_district_id'] !== null) {
			$builder->set('shipping_origin_district_id', $data['shipping_origin_district_id']);
		}

    $builder->where('store_id', $store_id);
    $builder->where('user_id', $user_id);
		$builder->update($query_data);

		// Delete Old Page Description
		$builder = $this->db->table('store_description');
		$builder->where('store_id', $store_id);
		$builder->where('user_id', $user_id);
		$builder->delete();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'store_id'          => $store_id,
        'user_id'           => $user_id,
        'language_id'       => $language_id,
        'description'       => $value['description'],
        'short_description' => $value['short_description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'tags'              => $value['tags'],
      );

			$builder = $this->db->table('store_description');

			$builder->insert($query_data_2);
		}

		return $store_id;
	}

	public function deleteStore($store_id, $user_id)
	{
		$builder = $this->db->table('store');
		$builder->where('store_id', $store_id);
		$builder->delete();

		$builder = $this->db->table('store_description');
		$builder->where('store_id', $store_id);
		$builder->delete();
	}

	public function getStores($data = array(), $language_id)
	{
		$builder = $this->db->table('store');
		$builder->select('*');
		$builder->join('store_description', 'store_description.store_id = store.store_id');

		if (!empty($data['filter_name'])) {
      $builder->like('store.name', $data['filter_name']);
		}

		$builder->where('store_description.language_id', $language_id);

		if (!empty($data['sort']) && !empty($data['order'])) {
			$builder->orderBy($data['sort'], $data['order']);
		}
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

		$results = array();

		foreach ($query->getResult() as $row)
		{
		  $results[] = array(
	      'store_id'              => $row->store_id,
	      'user_id'               => $row->user_id,
				'name'                  => $row->name,
	      'logo'                  => $row->logo,
	      'wallpaper'             => $row->wallpaper,
	      'viewed'                => $row->viewed,
	      'sort_order'            => $row->sort_order,
	      'status'                => $row->status,
	      'date_added'            => $row->date_added,
	      'date_modified'         => $row->date_modified,
				'slug'                  => $row->slug,
				'description'           => $row->description,
				'short_description'     => $row->short_description,
				'meta_title'            => $row->meta_title,
				'meta_description'      => $row->meta_description,
				'meta_keywords'         => $row->meta_keywords,
        'tags'                  => $row->tags,
		  );
		}

		return $results;
	}

	public function getStore($store_id)
	{
		return $this->asArray()->where(['store_id' => $store_id])->first();
	}

	public function getStoreDescriptions($store_id)
	{
		$builder = $this->db->table('store_description');
		$builder->where('store_id', $store_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'store_id'          => $row->store_id,
				'description'       => $row->description,
				'short_description' => $row->short_description,
				'meta_title'        => $row->meta_title,
				'meta_description'  => $row->meta_description,
				'meta_keywords'     => $row->meta_keywords,
				'tags'              => $row->tags,
			);
		}

		return $results;
	}

	public function getStoreDescription($store_id, $language_id)
	{
		$builder = $this->db->table('store_description');
		$builder->where('store_id', $store_id);
		$builder->where('language_id', $language_id);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'store_id'          => $row->store_id,
			'description'       => $row->description,
			'short_description' => $row->short_description,
			'meta_title'        => $row->meta_title,
			'meta_description'  => $row->meta_description,
			'meta_keywords'     => $row->meta_keywords,
			'tags'              => $row->tags,
		);

		return $result;
	}

	public function getStoreImages($store_id)
	{
		$builder = $this->db->table('store_image');
		$builder->where('store_id', $store_id);
		$builder->orderBy('sort_order', "ASC'");
		$query_1 = $builder->get();

		$results = array();

		foreach ($query_1->getResult() as $row_1)
		{
			$builder = $this->db->table('store_image_description');
			$builder->where('store_image_id', $row_1->store_image_id);
			$query_2 = $builder->get();

			$description = array();

			foreach ($query_2->getResult() as $row_2)
			{
				$description[$row_2->language_id] = array(
					'language_id' => $row_2->language_id,
					'title'       => $row_2->title,
					'description' => $row_2->description,
				);
			}

			$results[] = array(
				'store_image_id' => $row_1->store_image_id,
				'store_id'       => $row_1->store_id,
				'image'          => $row_1->image,
				'sort_order'     => $row_1->sort_order,
				'description'    => $description,
			);
		}

		return $results;
	}

	public function getTotalStores($data = array(), $language_id)
	{
		$builder = $this->db->table('store');
		$builder->select('*');
		$builder->join('store_description', 'store_description.store_id = store.store_id');

		if (!empty($data['filter_name'])) {
      $builder->like('store.name', $data['filter_name']);
		}

		$builder->where('store_description.language_id', $language_id);

    
		$query = $builder->countAllResults();

		return $query;
	}

	public function updateViewed($store_id)
	{
		$builder = $this->db->table('store');
		$builder->set('viewed', 'viewed+1', FALSE);
    $builder->where('store_id', $store_id);
		$builder->update();
	}
}