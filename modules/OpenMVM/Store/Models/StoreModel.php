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

	public function getStores($data = array())
	{
		$builder = $this->db->table('store');
		$builder->select('*');
		$builder->join('store_description', 'store_description.store_id = store.store_id');

		if (!empty($data['filter_name'])) {
      $builder->like('store.name', $data['filter_name']);
		}

		$builder->where('store_description.language_id', $this->language->getFrontEndId());

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

	public function editStore($data = array(), $store_id)
	{
		// Update Store
		if (!empty($data['user_id'])) {
			$user_id = $data['user_id'];
		} elseif ($this->session->get('user_id' . $this->session->user_session_id)) {
			$user_id = $this->session->get('user_id' . $this->session->user_session_id);
		} else {
			$user_id = 0;
		}

    $query_data = array(
      'administrator_edit_id' => $administrator_id,
      'parent_id'             => $data['parent_id'],
      'image_display'         => $data['image_display'],
      'type'                  => $data['type'],
      'allow_comment'         => $data['allow_comment'],
      'comment_moderation'    => $data['comment_moderation'],
      'sort_order'            => $data['sort_order'],
      'status'                => $data['status'],
      'date_modified'         => date("Y-m-d H:i:s",now()),
    );

		$builder = $this->db->table('article');
    $builder->where('article_id', $article_id);
		$builder->update($query_data);

		// Delete Old Page Description
		$builder = $this->db->table('article_description');
		$builder->where('article_id', $article_id);
		$builder->delete();

		// Insert New Page Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'article_id'    => $article_id,
        'language_id'       => $language_id,
        'title'             => $value['title'],
        'description'       => $value['description'],
        'short_description' => $value['short_description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'tags'              => $value['tags'],
        'slug'              => $this->slugify($value['title']),
      );

			$builder = $this->db->table('article_description');
      $builder->where('article_id', $article_id);
			$builder->insert($query_data_2);
		}

		$builder = $this->db->table('article_to_category');
		$builder->where('article_id', $article_id);
		$builder->delete();

    if (!empty($data['article_category'])) {
			foreach ($data['article_category'] as $category_id) {
        $query_data_3 = array(
          'article_id'          => $article_id,
          'article_category_id' => $category_id
        );

				$builder = $this->db->table('article_to_category');

        $builder->insert($query_data_3);
			}
		}

		if (!empty($data['image'])) {
	    $query_data_4 = array(
	      'image' => $data['image'],
	    );

			$builder = $this->db->table('article');
	    $builder->where('article_id', $article_id);
			$builder->update($query_data_4);
		}

		if (!empty($data['wallpaper'])) {
	    $query_data_5 = array(
	      'wallpaper' => $data['wallpaper'],
	    );

			$builder = $this->db->table('article');
	    $builder->where('article_id', $article_id);
			$builder->update($query_data_5);
		}

		// Delete Article Images
		$builder = $this->db->table('article_image');
		$builder->where('article_id', $article_id);
		$builder->delete();

		// Delete Old Article Image Description
		$builder = $this->db->table('article_image_description');
		$builder->where('article_id', $article_id);
		$builder->delete();

		// Insert New Article Images
		if ($data['images']) {
	    foreach ($data['images'] as $image) {
				if (!empty($image['image'])) {
		      $query_data_6 = array(
		        'article_id'  => $article_id,
		        'image'       => $image['image'],
		        'sort_order'  => $image['sort_order'],
		      );

					$builder = $this->db->table('article_image');
					$builder->insert($query_data_6);

					$article_image_id = $this->db->insertID();

					// Insert New Article Image Description
			    foreach ($image['description'] as $language_id => $value) {
			      $query_data_7 = array(
			        'article_image_id'  => $article_image_id,
			        'article_id'        => $article_id,
			        'language_id'       => $language_id,
			        'title'             => $value['title'],
			        'description'       => $value['description'],
			      );

						$builder = $this->db->table('article_image_description');
						$builder->insert($query_data_7);
					}
				}
			}
		}

		return $article_id;
	}

	public function deleteArticle($article_id)
	{
		$builder = $this->db->table('article');
		$builder->where('article_id', $article_id);
		$builder->delete();

		$builder = $this->db->table('article_description');
		$builder->where('article_id', $article_id);
		$builder->delete();
	}

	public function getTotalArticles($data = array())
	{
		$builder = $this->db->table('article');
		$builder->select('*');
		$builder->join('article_description', 'article_description.article_id = article.article_id');

		if (!empty($data['filter_name'])) {
      $builder->like('article_description.title', $data['filter_name']);
		}

		$builder->where('article_description.language_id', $this->admin_current_lang_id);
    
		$query = $builder->countAllResults();

		return $query;
	}

	public function updateViewed($article_id)
	{
		$builder = $this->db->table('article');
		$builder->set('viewed', 'viewed+1', FALSE);
    $builder->where('article_id', $article_id);
		$builder->update();
	}
}