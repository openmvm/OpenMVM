<?php

namespace Modules\OpenMVM\Store\Models;

class ProductModel extends \CodeIgniter\Model
{

  protected $table = 'product';
	protected $primaryKey = 'product_id';
  protected $allowedFields = ['product_id', 'user_id', 'image', 'sort_order', 'status', 'date_added', 'date_modified'];

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

	public function addProduct($data = array(), $store_id, $user_id)
	{
		$builder = $this->db->table('product');

		$builder->set('store_id', $store_id);

		$builder->set('user_id', $user_id);

		if ($data['price'] !== null) {
			$builder->set('price', $data['price']);
		}

		if ($data['quantity'] !== null) {
			$builder->set('quantity', $data['quantity']);
		}

		if ($data['shipping'] !== null) {
			$builder->set('shipping', $data['shipping']);
		}

		if ($data['weight'] !== null) {
			$builder->set('weight', $data['weight']);
		}

		if ($data['weight_class_id'] !== null) {
			$builder->set('weight_class_id', $data['weight_class_id']);
		}

		if ($data['length'] !== null) {
			$builder->set('length', $data['length']);
		}

		if ($data['width'] !== null) {
			$builder->set('width', $data['width']);
		}

		if ($data['height'] !== null) {
			$builder->set('height', $data['height']);
		}

		if ($data['length_class_id'] !== null) {
			$builder->set('length_class_id', $data['length_class_id']);
		}

		if (!empty($data['image'])) {
			$builder->set('image', $data['image']);
		}

		if (!empty($data['wallpaper'])) {
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
			$builder->set('date_added', $data['date_added']);
		} else {
			$builder->set('date_added', date("Y-m-d H:i:s",now()));
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', $data['date_modified']);
		} else {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

		$builder->insert($query_data);

		$product_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'product_id'        => $product_id,
        'user_id'           => $user_id,
        'language_id'       => $language_id,
        'name'              => $value['name'],
        'description'       => $value['description'],
        'short_description' => $value['short_description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'tags'              => $value['tags'],
        'slug'              => $this->text->slugify($value['name']),
      );

			$builder = $this->db->table('product_description');

			$builder->insert($query_data_2);
		}

    if (!empty($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
        $query_data_3 = array(
          'product_id'  => $product_id,
          'category_id' => $category_id
        );

				$builder = $this->db->table('product_to_category');

        $builder->insert($query_data_3);
			}
		}

		return $product_id;
	}

	public function editProduct($data = array(), $product_id, $store_id, $user_id)
	{
		// Update Product
		$builder = $this->db->table('product');

		if ($data['price'] !== null) {
			$builder->set('price', $data['price']);
		}

		if ($data['quantity'] !== null) {
			$builder->set('quantity', $data['quantity']);
		}

		if ($data['shipping'] !== null) {
			$builder->set('shipping', $data['shipping']);
		}

		if ($data['weight'] !== null) {
			$builder->set('weight', $data['weight']);
		}

		if ($data['weight_class_id'] !== null) {
			$builder->set('weight_class_id', $data['weight_class_id']);
		}

		if ($data['length'] !== null) {
			$builder->set('length', $data['length']);
		}

		if ($data['width'] !== null) {
			$builder->set('width', $data['width']);
		}

		if ($data['height'] !== null) {
			$builder->set('height', $data['height']);
		}

		if ($data['length_class_id'] !== null) {
			$builder->set('length_class_id', $data['length_class_id']);
		}

		if (!empty($data['image'])) {
			$builder->set('image', $data['image']);
		}

		if (!empty($data['wallpaper'])) {
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
			$builder->set('date_added', $data['date_added']);
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', $data['date_modified']);
		} else {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

    $builder->where('product_id', $product_id);
    $builder->where('user_id', $user_id);
    $builder->where('store_id', $store_id);
		$builder->update($query_data);

		// Delete Old Product Description
		$builder = $this->db->table('product_description');
    $builder->where('product_id', $product_id);
    $builder->where('user_id', $user_id);
		$builder->delete();

		// Insert New Product Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'product_id'        => $product_id,
        'user_id'           => $user_id,
        'language_id'       => $language_id,
        'name'              => $value['name'],
        'description'       => $value['description'],
        'short_description' => $value['short_description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'tags'              => $value['tags'],
        'slug'              => $this->text->slugify($value['name']),
      );

			$builder = $this->db->table('product_description');
			$builder->insert($query_data_2);
		}

		$builder = $this->db->table('product_to_category');
		$builder->where('product_id', $product_id);
		$builder->delete();

    if (!empty($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
        $query_data_3 = array(
          'product_id'  => $product_id,
          'category_id' => $category_id
        );

				$builder = $this->db->table('product_to_category');

        $builder->insert($query_data_3);
			}
		}

		return $product_id;
	}

	public function deleteProduct($product_id, $user_id = null)
	{
		$builder = $this->db->table('product');
		$builder->where('product_id', $product_id);
		if (!empty($user_id)) {
			$builder->where('user_id', $user_id);
		}
		$builder->delete();

		$builder = $this->db->table('product_description');
		$builder->where('product_id', $product_id);
		$builder->delete();
	}

	public function getProducts($data = array())
	{
		if (!empty($data['filter_category']) && $data['filter_category'] !== 0) {
			if (!empty($data['filter_sub_category'])) {
				$builder = $this->db->table('category_path');
	      $builder->join('product_to_category', 'category_path.category_id = product_to_category.category_id');
			} else {
				$builder = $this->db->table('product_to_category');
			}

      $builder->join('product', 'product_to_category.product_id = product.product_id');
		} else {
			$builder = $this->db->table('product');
		}

		$builder->join('product_description', 'product_description.product_id = product.product_id');

    if (!empty($data['filter_category']) && $data['filter_category'] !== 0) {
			if (!empty($data['filter_sub_category'])) {
      	$builder->where('category_path.path_id', $data['filter_category']);
			} else {
      	$builder->where('product_to_category.category_id', $data['filter_category']);
			}
    }

		if (!empty($data['filter_keyword'])) {
      $builder->like('product_description.name', $data['filter_keyword']);
		}

		if (!empty($data['filter_user_id'])) {
      $builder->where('product.user_id', $data['filter_user_id']);
		}

		if (!empty($data['filter_name'])) {
      $builder->like('product_description.name', $data['filter_name']);
		}

		$builder->where('product_description.language_id', $this->language->getFrontEndId());

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
	      'product_id'            => $row->product_id,
	      'user_id'               => $row->user_id,
	      'store_id'              => $row->store_id,
	      'price'                 => $row->price,
	      'quantity'              => $row->quantity,
	      'shipping'              => $row->shipping,
	      'weight'                => $row->weight,
	      'weight_class_id'       => $row->weight_class_id,
	      'length'                => $row->length,
	      'width'                 => $row->width,
	      'height'                => $row->height,
	      'length_class_id'       => $row->length_class_id,
	      'image'                 => $row->image,
	      'wallpaper'             => $row->wallpaper,
	      'viewed'                => $row->viewed,
	      'sort_order'            => $row->sort_order,
	      'status'                => $row->status,
	      'date_added'            => $row->date_added,
	      'date_modified'         => $row->date_modified,
				'slug'                  => $row->slug,
				'name'                  => $row->name,
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

	public function getProduct($product_id)
	{
		return $this->asArray()->where(['product_id' => $product_id])->first();
	}

	public function getProductDescriptions($product_id)
	{
		$builder = $this->db->table('product_description');
		$builder->where('product_id', $product_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'product_id'        => $row->product_id,
				'name'              => $row->name,
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

	public function getProductDescription($product_id)
	{
		$builder = $this->db->table('product_description');
		$builder->where('product_id', $product_id);
		$builder->where('language_id', $this->language->getFrontEndId());
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'product_id'        => $row->product_id,
			'name'              => $row->name,
			'description'       => $row->description,
			'short_description' => $row->short_description,
			'meta_title'        => $row->meta_title,
			'meta_description'  => $row->meta_description,
			'meta_keywords'     => $row->meta_keywords,
			'tags'              => $row->tags,
		);

		return $result;
	}

	public function getProductImages($product_id)
	{
		$builder = $this->db->table('product_image');
		$builder->where('product_id', $product_id);
		$builder->orderBy('sort_order', "ASC'");
		$query_1 = $builder->get();

		$results = array();

		foreach ($query_1->getResult() as $row_1)
		{
			$builder = $this->db->table('product_image_description');
			$builder->where('product_image_id', $row_1->product_image_id);
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
				'product_image_id' => $row_1->product_image_id,
				'product_id'       => $row_1->product_id,
				'image'          => $row_1->image,
				'sort_order'     => $row_1->sort_order,
				'description'    => $description,
			);
		}

		return $results;
	}

	public function getProductCategories($product_id)
	{
    $product_categories_data = array();

		$builder = $this->db->table('product_to_category');
		$builder->where('product_id', $product_id);
    $query = $builder->get();

    foreach ($query->getResult() as $row) {
      $product_categories_data[] = $row->category_id;
    }

    return $product_categories_data;
	}

	public function getLatestProducts($limit = 4) {
		$product_data = array();

		$builder = $this->db->table('product');
    $builder->select('product_id', false);

		$builder->where('status', 1);

    $builder->orderBy('date_added', 'DESC');
    $builder->limit($limit, 0);

    $query = $builder->get();

		foreach ($query->getResult() as $result) {
			$product_data[$result->product_id] = $this->getProduct($result->product_id);
		}

		return $product_data;
	}

	public function getTotalProducts($data = array())
	{
		if (!empty($data['filter_category']) && $data['filter_category'] !== 0) {
			if (!empty($data['filter_sub_category'])) {
				$builder = $this->db->table('category_path');
	      $builder->join('product_to_category', 'category_path.category_id = product_to_category.category_id');
			} else {
				$builder = $this->db->table('product_to_category');
			}

      $builder->join('product', 'product_to_category.product_id = product.product_id');
		} else {
			$builder = $this->db->table('product');
		}

		$builder->join('product_description', 'product_description.product_id = product.product_id');

    if (!empty($data['filter_category']) && $data['filter_category'] !== 0) {
			if (!empty($data['filter_sub_category'])) {
      	$builder->where('category_path.path_id', $data['filter_category']);
			} else {
      	$builder->where('product_to_category.category_id', $data['filter_category']);
			}
    }

		if (!empty($data['filter_keyword'])) {
      $builder->like('product_description.name', $data['filter_keyword']);
		}

		if (!empty($data['filter_user_id'])) {
      $builder->where('product.user_id', $data['filter_user_id']);
		}

		if (!empty($data['filter_name'])) {
      $builder->like('product_description.name', $data['filter_name']);
		}

		$builder->where('product_description.language_id', $this->language->getFrontEndId());
    
		$query = $builder->countAllResults();

		return $query;
	}

	public function updateViewed($product_id)
	{
		$builder = $this->db->table('product');
		$builder->set('viewed', 'viewed+1', FALSE);
    $builder->where('product_id', $product_id);
		$builder->update();
	}
}