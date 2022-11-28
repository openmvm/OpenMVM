<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_id', 'seller_id', 'customer_id', 'category_id_path', 'price', 'quantity', 'subtract_stock', 'weight', 'weight_class_id', 'date_added', 'date_modified', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->text = new \App\Libraries\Text();
        // Helpers
        helper('date');
    }

    public function addProduct($data = [])
    {
        $product_insert_builder = $this->db->table('product');

        if (!empty($data['is_product_variant'])) {
            $product_option = 1;
            $subtract_stock = 0;
        } else {
            $product_option = 0;

            if (!empty($data['subtract_stock'])) {
                $subtract_stock = 1;
            } else {
                $subtract_stock = 0;
            }
        }

        if (!empty($data['is_product_variant_special'])) {
            $product_variant_special = 1;
        } else {
            $product_variant_special = 0;
        }

        if (!empty($data['is_product_variant_discount'])) {
            $product_variant_discount = 1;
        } else {
            $product_variant_discount = 0;
        }

        $product_insert_data = [
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'category_id_path' => $data['category_id_path'],
            'product_option' => $product_option,
            'product_variant_special' => $product_variant_special,
            'product_variant_discount' => $product_variant_discount,
            'price' => (float)$data['price'],
            'quantity' => $data['quantity'],
            'subtract_stock' => $subtract_stock,
            'minimum_purchase' => $data['minimum_purchase'],
            'requires_shipping' => $data['requires_shipping'],
            'weight' => $data['weight'],
            'weight_class_id' => $data['weight_class_id'],
            'sku' => $data['sku'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];
        
        $product_insert_builder->insert($product_insert_data);

        $product_id = $this->db->insertID();

        // Main image
        if (!empty($data['main_image'])) {
            $product_update_builder = $this->db->table('product');

            $product_update_data = [
                'main_image' => $data['main_image'],
            ];

            $product_update_builder->where('seller_id', $this->customer->getSellerId());
            $product_update_builder->where('customer_id', $this->customer->getId());
            $product_update_builder->where('product_id', $product_id);
            $product_update_builder->update($product_update_data);
        }

        // Additional images
        if (!empty($data['additional_image'])) {
            foreach ($data['additional_image'] as $additional_image) {
                $product_image_insert_builder = $this->db->table('product_image');

                $product_image_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'image' => $additional_image,
                ];
                
                $product_image_insert_builder->insert($product_image_insert_data);
            }
        }

        // Product Descriptions
        if ($data['product_description']) {
            foreach ($data['product_description'] as $language_id => $value) {
                $product_description_builder = $this->db->table('product_description');

                $product_description_insert_data = [
                    'product_id' => $product_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $product_description_builder->insert($product_description_insert_data);
            }
        }

        // Product to category
        $category_ids = explode('_', $data['category_id_path']);

        foreach ($category_ids as $category_id) {
            $product_to_category_insert_builder = $this->db->table('product_to_category');

            $product_to_category_insert_data = [
                'product_id' => $product_id,
                'category_id' => $category_id,
            ];
            
            $product_to_category_insert_builder->insert($product_to_category_insert_data);
        }

        // Product option
        if (!empty($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                // Insert product option
                $product_option_insert_builder = $this->db->table('product_option');

                $product_option_insert_data = [
                    'product_id' => $product_id,
                    'option_id' => $product_option['option_id'],
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                ];
                
                $product_option_insert_builder->insert($product_option_insert_data);

                $product_option_id = $this->db->insertID();

                // Insert product option value
                if (!empty($product_option['option_value'])) {
                    foreach ($product_option['option_value'] as $option_value) {
                        // Insert product option value
                        $product_option_value_insert_builder = $this->db->table('product_option_value');

                        $product_option_value_insert_data = [
                            'product_option_id' => $product_option_id,
                            'product_id' => $product_id,
                            'option_id' => $product_option['option_id'],
                            'option_value_id' => $option_value,
                            'seller_id' => $this->customer->getSellerId(),
                            'customer_id' => $this->customer->getId(),
                        ];
                        
                        $product_option_value_insert_builder->insert($product_option_value_insert_data);

                        $product_option_value_id = $this->db->insertID();
                    }
                }
            }
        }

        // Product variants
        if (!empty($data['product_variant'])) {
            foreach ($data['product_variant'] as $product_variant) {
                // Subtract stock
                if (!empty($product_variant['subtract_stock'])) {
                    $product_variant_subtract_stock = 1;
                } else {
                    $product_variant_subtract_stock = 0;
                }

                // Insert product variant
                $option_data = [];

                if (!empty($product_variant['option'])) {
                    foreach ($product_variant['option'] as $key => $value) {
                        $option_data[$key] = $value;
                    }

                    asort($option_data);
                }

                $product_variant_insert_builder = $this->db->table('product_variant');

                $product_variant_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'options' => json_encode($option_data),
                    'sku' => $product_variant['sku'],
                    'quantity' => $product_variant['quantity'],
                    'subtract_stock' => $product_variant_subtract_stock,
                    'minimum_purchase' => $product_variant['minimum_purchase'],
                    'price' => $product_variant['price'],
                    'weight' => $product_variant['weight'],
                    'weight_class_id' => $product_variant['weight_class_id'],
                ];
                
                $product_variant_insert_builder->insert($product_variant_insert_data);

                $product_variant_id = $this->db->insertID();
            }

        }

        // Product variant special
        if (!empty($data['product_variant_special'])) {
            foreach ($data['product_variant_special'] as $product_variant_special) {
                // Insert product variant
                $option_data = [];

                if (!empty($product_variant_special['option'])) {
                    foreach ($product_variant_special['option'] as $key => $value) {
                        $product_variant_special_option_data[$key] = $value;
                    }

                    asort($product_variant_special_option_data);
                }

                if (!empty($product_variant_special['special'])) {
                    foreach ($product_variant_special['special'] as $special) {
                        // Get product variant info
                        $product_variant_builder = $this->db->table('product_variant');
                        
                        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
                        $product_variant_builder->where('customer_id', $this->customer->getId());
                        $product_variant_builder->where('product_id', $product_id);
                        $product_variant_builder->where('options', json_encode($product_variant_special_option_data));

                        $product_variant_query = $product_variant_builder->get();

                        if ($product_variant_row = $product_variant_query->getRow()) {
                            $product_variant_special_insert_builder = $this->db->table('product_variant_special');

                            $product_variant_special_insert_data = [
                                'product_variant_id' => $product_variant_row->product_variant_id,
                                'options' => json_encode($product_variant_special_option_data),
                                'product_id' => $product_id,
                                'seller_id' => $this->customer->getSellerId(),
                                'customer_id' => $this->customer->getId(),
                                'options' => json_encode($product_variant_special_option_data),
                                'priority' => $special['priority'],
                                'price' => $special['price'],
                                'date_start' => $special['date_start'],
                                'date_end' => $special['date_end'],
                            ];
                            
                            $product_variant_special_insert_builder->insert($product_variant_special_insert_data);
                        }
                    }
                }

            }
        }

        // Product variant discount
        if (!empty($data['product_variant_discount'])) {
            foreach ($data['product_variant_discount'] as $product_variant_discount) {
                // Insert product variant
                $option_data = [];

                if (!empty($product_variant_discount['option'])) {
                    foreach ($product_variant_discount['option'] as $key => $value) {
                        $product_variant_discount_option_data[$key] = $value;
                    }

                    asort($product_variant_discount_option_data);
                }

                if (!empty($product_variant_discount['discount'])) {
                    foreach ($product_variant_discount['discount'] as $discount) {
                        // Get product variant info
                        $product_variant_builder = $this->db->table('product_variant');
                        
                        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
                        $product_variant_builder->where('customer_id', $this->customer->getId());
                        $product_variant_builder->where('product_id', $product_id);
                        $product_variant_builder->where('options', json_encode($product_variant_discount_option_data));

                        $product_variant_query = $product_variant_builder->get();

                        if ($product_variant_row = $product_variant_query->getRow()) {
                            $product_variant_special_insert_builder = $this->db->table('product_variant_discount');

                            $product_variant_discount_insert_data = [
                                'product_variant_id' => $product_variant_row->product_variant_id,
                                'options' => json_encode($product_variant_discount_option_data),
                                'product_id' => $product_id,
                                'seller_id' => $this->customer->getSellerId(),
                                'customer_id' => $this->customer->getId(),
                                'options' => json_encode($product_variant_discount_option_data),
                                'priority' => $discount['priority'],
                                'min_quantity' => $discount['min_quantity'],
                                'max_quantity' => $discount['max_quantity'],
                                'price' => $discount['price'],
                                'date_start' => $discount['date_start'],
                                'date_end' => $discount['date_end'],
                            ];
                            
                            $product_variant_discount_insert_builder->insert($product_variant_discount_insert_data);
                        }
                    }
                }

            }
        }

        // Product downloads
        if (!empty($data['product_download'])) {
            foreach ($data['product_download'] as $product_download) {
                $product_download_insert_builder = $this->db->table('product_download');

                $product_download_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'filename' => $product_download['filename'],
                    'mask' => $product_download['mask'],
                    'date_added' => new Time('now'),
                ];
                
                $product_download_insert_builder->insert($product_download_insert_data);

                $product_download_id = $this->db->insertID();

                if (!empty($product_download['description'])) {
                    foreach ($product_download['description'] as $language_id => $value) {
                        $product_download_description_insert_builder = $this->db->table('product_download_description');

                        $product_download_description_insert_data = [
                            'product_download_id' => $product_download_id,
                            'product_id' => $product_id,
                            'seller_id' => $this->customer->getSellerId(),
                            'customer_id' => $this->customer->getId(),
                            'language_id' => $language_id,
                            'name' => $value['name'],
                        ];
                        
                        $product_download_description_insert_builder->insert($product_download_description_insert_data);
                    }
                }
            }
        }

        // Product specials
        if (!empty($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $product_special_insert_builder = $this->db->table('product_special');

                $product_special_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'priority' => $product_special['priority'],
                    'price' => $product_special['price'],
                    'date_start' => $product_special['date_start'],
                    'date_end' => $product_special['date_end'],
                ];
                
                $product_special_insert_builder->insert($product_special_insert_data);

                $product_special_id = $this->db->insertID();
            }
        }

        // Product discounts
        if (!empty($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $product_discount_insert_builder = $this->db->table('product_discount');

                $product_discount_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'priority' => $product_discount['priority'],
                    'min_quantity' => $product_discount['min_quantity'],
                    'max_quantity' => $product_discount['max_quantity'],
                    'price' => $product_discount['price'],
                    'date_start' => $product_discount['date_start'],
                    'date_end' => $product_discount['date_end'],
                ];
                
                $product_discount_insert_builder->insert($product_discount_insert_data);

                $product_discount_id = $this->db->insertID();
            }
        }

        return $product_id;
    }

    public function editProduct($product_id, $data = [])
    {
        $product_update_builder = $this->db->table('product');

        if (!empty($data['is_product_variant'])) {
            $product_option = 1;
            $subtract_stock = 0;
        } else {
            $product_option = 0;

            if (!empty($data['subtract_stock'])) {
                $subtract_stock = 1;
            } else {
                $subtract_stock = 0;
            }
        }

        if (!empty($data['is_product_variant_special'])) {
            $product_variant_special = 1;
        } else {
            $product_variant_special = 0;
        }

        if (!empty($data['is_product_variant_discount'])) {
            $product_variant_discount = 1;
        } else {
            $product_variant_discount = 0;
        }

        $product_update_data = [
            'category_id_path' => $data['category_id_path'],
            'product_option' => $product_option,
            'product_variant_special' => $product_variant_special,
            'product_variant_discount' => $product_variant_discount,
            'price' => (float)$data['price'],
            'quantity' => $data['quantity'],
            'subtract_stock' => $subtract_stock,
            'minimum_purchase' => $data['minimum_purchase'],
            'requires_shipping' => $data['requires_shipping'],
            'weight' => $data['weight'],
            'weight_class_id' => $data['weight_class_id'],
            'sku' => $data['sku'],
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];

        $product_update_builder->where('seller_id', $this->customer->getSellerId());
        $product_update_builder->where('customer_id', $this->customer->getId());
        $product_update_builder->where('product_id', $product_id);
        $product_update_builder->update($product_update_data);

        // Main image
        if (!empty($data['main_image'])) {
            $product_update_builder = $this->db->table('product');

            $product_update_data = [
                'main_image' => $data['main_image'],
            ];

            $product_update_builder->where('seller_id', $this->customer->getSellerId());
            $product_update_builder->where('customer_id', $this->customer->getId());
            $product_update_builder->where('product_id', $product_id);
            $product_update_builder->update($product_update_data);
        }

        // Additional images
        // Delete additional images
        $builder = $this->db->table('product_image');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['additional_image'])) {
            foreach ($data['additional_image'] as $additional_image) {
                $product_image_insert_builder = $this->db->table('product_image');

                $product_image_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'image' => $additional_image,
                ];
                
                $product_image_insert_builder->insert($product_image_insert_data);
            }
        }
        
        // Delete product descriptions
        $builder = $this->db->table('product_description');

        $builder->where('product_id', $product_id);
        $builder->delete();

        // Product Descriptions
        if ($data['product_description']) {
            foreach ($data['product_description'] as $language_id => $value) {
                $product_description_builder = $this->db->table('product_description');

                $product_description_insert_data = [
                    'product_id' => $product_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $product_description_builder->insert($product_description_insert_data);
            }
        }

        // Delete product to category
        $product_to_category_delete_builder = $this->db->table('product_to_category');

        $product_to_category_delete_builder->where('product_id', $product_id);
        $product_to_category_delete_builder->delete();

        // Product to category
        $category_ids = explode('_', $data['category_id_path']);

        foreach ($category_ids as $category_id) {
            $product_to_category_insert_builder = $this->db->table('product_to_category');

            $product_to_category_insert_data = [
                'product_id' => $product_id,
                'category_id' => $category_id,
            ];
            
            $product_to_category_insert_builder->insert($product_to_category_insert_data);
        }

        // Product option
        // Delete product option
        $builder = $this->db->table('product_option');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);
        $builder->delete();

        // Delete product option value
        $builder = $this->db->table('product_option_value');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);
        $builder->delete();

        if (!empty($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                // Insert product option
                $product_option_insert_builder = $this->db->table('product_option');

                $product_option_insert_data = [
                    'product_id' => $product_id,
                    'option_id' => $product_option['option_id'],
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                ];
                
                $product_option_insert_builder->insert($product_option_insert_data);

                $product_option_id = $this->db->insertID();

                // Insert product option value
                if (!empty($product_option['option_value'])) {
                    foreach ($product_option['option_value'] as $option_value) {
                        // Insert product option value
                        $product_option_value_insert_builder = $this->db->table('product_option_value');

                        $product_option_value_insert_data = [
                            'product_option_id' => $product_option_id,
                            'product_id' => $product_id,
                            'option_id' => $product_option['option_id'],
                            'option_value_id' => $option_value,
                            'seller_id' => $this->customer->getSellerId(),
                            'customer_id' => $this->customer->getId(),
                        ];
                        
                        $product_option_value_insert_builder->insert($product_option_value_insert_data);

                        $product_option_value_id = $this->db->insertID();
                    }
                }
            }
        }

        // Product variants
        // Delete product variant
        $builder = $this->db->table('product_variant');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete product variant option
        $builder = $this->db->table('product_variant_option');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete product variant option value
        $builder = $this->db->table('product_variant_option_value');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_variant'])) {
            foreach ($data['product_variant'] as $product_variant) {
                // Subtract stock
                if (!empty($product_variant['subtract_stock'])) {
                    $product_variant_subtract_stock = 1;
                } else {
                    $product_variant_subtract_stock = 0;
                }

                // Insert product variant
                $option_data = [];

                if (!empty($product_variant['option'])) {
                    foreach ($product_variant['option'] as $key => $value) {
                        $option_data[$key] = $value;
                    }

                    asort($option_data);
                }

                $product_variant_insert_builder = $this->db->table('product_variant');

                $product_variant_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'options' => json_encode($option_data),
                    'sku' => $product_variant['sku'],
                    'quantity' => $product_variant['quantity'],
                    'subtract_stock' => $product_variant_subtract_stock,
                    'minimum_purchase' => $product_variant['minimum_purchase'],
                    'price' => $product_variant['price'],
                    'weight' => $product_variant['weight'],
                    'weight_class_id' => $product_variant['weight_class_id'],
                ];
                
                $product_variant_insert_builder->insert($product_variant_insert_data);

                $product_variant_id = $this->db->insertID();
            }

        }

        // Product variant special
        // Delete product variant special
        $builder = $this->db->table('product_variant_special');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_variant_special'])) {
            foreach ($data['product_variant_special'] as $product_variant_special) {
                // Insert product variant
                $option_data = [];

                if (!empty($product_variant_special['option'])) {
                    foreach ($product_variant_special['option'] as $key => $value) {
                        $product_variant_special_option_data[$key] = $value;
                    }

                    asort($product_variant_special_option_data);
                }

                if (!empty($product_variant_special['special'])) {
                    foreach ($product_variant_special['special'] as $special) {
                        // Get product variant info
                        $product_variant_builder = $this->db->table('product_variant');
                        
                        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
                        $product_variant_builder->where('customer_id', $this->customer->getId());
                        $product_variant_builder->where('product_id', $product_id);
                        $product_variant_builder->where('options', json_encode($product_variant_special_option_data));

                        $product_variant_query = $product_variant_builder->get();

                        if ($product_variant_row = $product_variant_query->getRow()) {
                            $product_variant_special_insert_builder = $this->db->table('product_variant_special');

                            $product_variant_special_insert_data = [
                                'product_variant_id' => $product_variant_row->product_variant_id,
                                'options' => json_encode($product_variant_special_option_data),
                                'product_id' => $product_id,
                                'seller_id' => $this->customer->getSellerId(),
                                'customer_id' => $this->customer->getId(),
                                'options' => json_encode($product_variant_special_option_data),
                                'priority' => $special['priority'],
                                'price' => $special['price'],
                                'date_start' => $special['date_start'],
                                'date_end' => $special['date_end'],
                            ];
                            
                            $product_variant_special_insert_builder->insert($product_variant_special_insert_data);
                        }
                    }
                }

            }
        }

        // Product variant discount
        // Delete product variant discount
        $builder = $this->db->table('product_variant_discount');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_variant_discount'])) {
            foreach ($data['product_variant_discount'] as $product_variant_discount) {
                // Insert product variant
                $option_data = [];

                if (!empty($product_variant_discount['option'])) {
                    foreach ($product_variant_discount['option'] as $key => $value) {
                        $product_variant_discount_option_data[$key] = $value;
                    }

                    asort($product_variant_discount_option_data);
                }

                if (!empty($product_variant_discount['discount'])) {
                    foreach ($product_variant_discount['discount'] as $discount) {
                        // Get product variant info
                        $product_variant_builder = $this->db->table('product_variant');
                        
                        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
                        $product_variant_builder->where('customer_id', $this->customer->getId());
                        $product_variant_builder->where('product_id', $product_id);
                        $product_variant_builder->where('options', json_encode($product_variant_discount_option_data));

                        $product_variant_query = $product_variant_builder->get();

                        if ($product_variant_row = $product_variant_query->getRow()) {
                            $product_variant_discount_insert_builder = $this->db->table('product_variant_discount');

                            $product_variant_discount_insert_data = [
                                'product_variant_id' => $product_variant_row->product_variant_id,
                                'options' => json_encode($product_variant_discount_option_data),
                                'product_id' => $product_id,
                                'seller_id' => $this->customer->getSellerId(),
                                'customer_id' => $this->customer->getId(),
                                'options' => json_encode($product_variant_discount_option_data),
                                'priority' => $discount['priority'],
                                'min_quantity' => $discount['min_quantity'],
                                'max_quantity' => $discount['max_quantity'],
                                'price' => $discount['price'],
                                'date_start' => $discount['date_start'],
                                'date_end' => $discount['date_end'],
                            ];
                            
                            $product_variant_discount_insert_builder->insert($product_variant_discount_insert_data);
                        }
                    }
                }

            }
        }

        // Product downloads
        // Delete product download
        $builder = $this->db->table('product_download');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete product download description
        $builder = $this->db->table('product_download_description');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_download'])) {
            foreach ($data['product_download'] as $product_download) {
                $product_download_insert_builder = $this->db->table('product_download');

                $product_download_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'filename' => $product_download['filename'],
                    'mask' => $product_download['mask'],
                    'date_added' => new Time('now'),
                ];
                
                $product_download_insert_builder->insert($product_download_insert_data);

                $product_download_id = $this->db->insertID();

                if (!empty($product_download['description'])) {
                    foreach ($product_download['description'] as $language_id => $value) {
                        $product_download_description_insert_builder = $this->db->table('product_download_description');

                        $product_download_description_insert_data = [
                            'product_download_id' => $product_download_id,
                            'product_id' => $product_id,
                            'seller_id' => $this->customer->getSellerId(),
                            'customer_id' => $this->customer->getId(),
                            'language_id' => $language_id,
                            'name' => $value['name'],
                        ];
                        
                        $product_download_description_insert_builder->insert($product_download_description_insert_data);
                    }
                }
            }
        }

        // Product specials
        // Delete product special
        $builder = $this->db->table('product_special');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $product_special_insert_builder = $this->db->table('product_special');

                $product_special_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'priority' => $product_special['priority'],
                    'price' => $product_special['price'],
                    'date_start' => $product_special['date_start'],
                    'date_end' => $product_special['date_end'],
                ];
                
                $product_special_insert_builder->insert($product_special_insert_data);

                $product_special_id = $this->db->insertID();
            }
        }

        // Product discounts
        // Delete product discount
        $builder = $this->db->table('product_discount');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $product_discount_insert_builder = $this->db->table('product_discount');

                $product_discount_insert_data = [
                    'product_id' => $product_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'priority' => $product_discount['priority'],
                    'min_quantity' => $product_discount['min_quantity'],
                    'max_quantity' => $product_discount['max_quantity'],
                    'price' => $product_discount['price'],
                    'date_start' => $product_discount['date_start'],
                    'date_end' => $product_discount['date_end'],
                ];
                
                $product_discount_insert_builder->insert($product_discount_insert_data);

                $product_discount_id = $this->db->insertID();
            }
        }

        return $product_id;
    }

    public function deleteProduct($product_id)
    {
        // Delete product
        $builder = $this->db->table('product');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);
        $builder->delete();

        // Delete product descriptions
        $builder = $this->db->table('product_description');

        $builder->where('product_id', $product_id);
        $builder->delete();

        // Delete product to category
        $builder = $this->db->table('product_to_category');

        $builder->where('product_id', $product_id);
        $builder->delete();
    }

    public function getProducts($data = [])
    {
        $builder = $this->db->table('product');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());

        $product_query = $builder->get();

        $products = [];

        foreach ($product_query->getResult() as $result) {
            $products[] = [
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'product_option' => $result->product_option,
                'product_variant_special' => $result->product_variant_special,
                'product_variant_discount' => $result->product_variant_discount,
                'price' => $result->price,
                'quantity' => $result->quantity,
                'subtract_stock' => $result->subtract_stock,
                'minimum_purchase' => $result->minimum_purchase,
                'requires_shipping' => $result->requires_shipping,
                'weight' => $result->weight,
                'weight_class_id' => $result->weight_class_id,
                'main_image' => $result->main_image,
                'sku' => $result->sku,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
                'status' => $result->status,
            ];
        }

        return $products;
    }

    public function getProduct($product_id)
    {
        $builder = $this->db->table('product');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('product_id', $product_id);

        $product_query = $builder->get();

        $product = [];

        if ($row = $product_query->getRow()) {
            $product = [
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'category_id_path' => $row->category_id_path,
                'product_option' => $row->product_option,
                'product_variant_special' => $row->product_variant_special,
                'product_variant_discount' => $row->product_variant_discount,
                'price' => $row->price,
                'quantity' => $row->quantity,
                'subtract_stock' => $row->subtract_stock,
                'minimum_purchase' => $row->minimum_purchase,
                'requires_shipping' => $row->requires_shipping,
                'weight' => $row->weight,
                'weight_class_id' => $row->weight_class_id,
                'main_image' => $row->main_image,
                'sku' => $row->sku,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
                'status' => $row->status,
            ];
        }

        return $product;
    }

    public function getProductDescriptions($product_id)
    {
        $builder = $this->db->table('product_description');
        
        $builder->where('product_id', $product_id);

        $product_description_query = $builder->get();

        $product_descriptions = [];

        foreach ($product_description_query->getResult() as $result) {
            $product_descriptions[$result->language_id] = [
                'name' => $result->name,
                'description' => $result->description,
                'meta_title' => $result->meta_title,
                'meta_description' => $result->meta_description,
                'meta_keywords' => $result->meta_keywords,
                'slug' => $result->slug,
            ];
        }

        return $product_descriptions;
    }

    public function getProductDescription($product_id)
    {
        $builder = $this->db->table('product_description');
        
        $builder->where('product_id', $product_id);
        $builder->where('language_id', $this->setting->get('setting_admin_language_id'));

        $product_description_query = $builder->get();

        $product_description = [];

        if ($row = $product_description_query->getRow()) {
            $product_description = [
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
                'slug' => $row->slug,
            ];
        }

        return $product_description;
    }

    public function getProductOptions($product_id)
    {
        $builder = $this->db->table('product_option');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());

        $product_option_query = $builder->get();

        $product_options = [];

        foreach ($product_option_query->getResult() as $result) {
            // Get option
            $option_builder = $this->db->table('option');
            
            $option_builder->where('seller_id', $this->customer->getSellerId());
            $option_builder->where('customer_id', $this->customer->getId());
            $option_builder->where('option_id', $result->option_id);

            $option_query = $option_builder->get();

            $option = [];

            if ($option_row = $option_query->getRow()) {
                $option_sort_order = $option_row->sort_order;
            } else {
                $option_sort_order = 0;
            }

            // Get option description
            $option_description_builder = $this->db->table('option_description');
            
            $option_description_builder->where('seller_id', $this->customer->getSellerId());
            $option_description_builder->where('customer_id', $this->customer->getId());
            $option_description_builder->where('option_id', $result->option_id);
            $option_description_builder->where('language_id', $this->language->getCurrentId());

            $option_description_query = $option_description_builder->get();

            $option_description = [];

            if ($row = $option_description_query->getRow()) {
                $option = $row->name;
            } else {
                $option = '';
            }

            // Get product option value
            $builder = $this->db->table('product_option_value');

            $builder->where('product_option_id', $result->product_option_id);
            $builder->where('product_id', $product_id);
            $builder->where('seller_id', $this->customer->getSellerId());
            $builder->where('customer_id', $this->customer->getId());

            $product_option_value_query = $builder->get();

            $product_option_value_data = [];

            foreach ($product_option_value_query->getResult() as $product_option_value) {
                $product_option_value_data[] = $product_option_value->option_value_id;
            }

            // Get option values
            $option_value_data = [];

            $option_value_builder = $this->db->table('option_value');

            $option_value_builder->where('option_id', $result->option_id);
            $option_value_builder->where('seller_id', $this->customer->getSellerId());
            $option_value_builder->where('customer_id', $this->customer->getId());
            $option_value_builder->orderBy('sort_order', 'ASC');

            $option_value_query = $option_value_builder->get();

            $option_value_data = [];

            foreach ($option_value_query->getResult() as $option_value) {
                // Get option value descriptions
                $option_value_description_data = [];

                $option_value_description_builder = $this->db->table('option_value_description');
                
                $option_value_description_builder->where('seller_id', $this->customer->getSellerId());
                $option_value_description_builder->where('customer_id', $this->customer->getId());
                $option_value_description_builder->where('option_id', $result->option_id);
                $option_value_description_builder->where('option_value_id', $option_value->option_value_id);
                $option_value_description_builder->where('language_id', $this->language->getCurrentId());

                $option_value_description_query = $option_value_description_builder->get();

                $option_value_description = [];

                if ($option_value_description = $option_value_description_query->getRow()) {
                    $option_value_description_data = [
                        'name' => $option_value_description->name,
                    ];
                }

                $option_value_data[] = [
                    'option_value_id' => $option_value->option_value_id,
                    'option_id' => $option_value->option_id,
                    'seller_id' => $option_value->seller_id,
                    'customer_id' => $option_value->customer_id,
                    'sort_order' => $option_value->sort_order,
                    'status' => $option_value->status,
                    'description' => $option_value_description_data,
                ];
            }            

            $product_options[] = [
                'product_option_id' => $result->product_option_id,
                'product_id' => $result->product_id,
                'option_id' => $result->option_id,
                'option' => $option,
                'option_sort_order' => $option_sort_order,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'product_option_value' => $product_option_value_data,
                'option_value' => $option_value_data,
            ];
        }

        return $product_options;
    }

    public function getProductVariant($product_id, $options = [])
    {
        $builder = $this->db->table('product_variant pv');

        $builder->where('pv.product_id', $product_id);
        $builder->where('pv.seller_id', $this->customer->getSellerId());
        $builder->where('pv.customer_id', $this->customer->getId());

        $option_values = [];

        foreach ($options as $option) {
            $option_values[$option['option_id']] = $option['option_value_id'];
        }

        asort($option_values);

        $builder->where('pv.options', json_encode($option_values));

        $product_variant_query = $builder->get();

        $product_variant = [];

        if ($row = $product_variant_query->getRow()) {
            $product_variant = [
                'product_variant_id' => $row->product_variant_id,
                'product_id' => $row->product_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'sku' => $row->sku,
                'quantity' => $row->quantity,
                'subtract_stock' => $row->subtract_stock,
                'minimum_purchase' => $row->minimum_purchase,
                'price' => $row->price,
                'weight' => $row->weight,
                'weight_class_id' => $row->weight_class_id,
            ];
        }

        return $product_variant;
    }

    public function getProductVariantMinMaxPrices($product_id)
    {
        $product_variant_builder = $this->db->table('product_variant');
        $product_variant_builder->selectMin('price', 'min_price');
        $product_variant_builder->selectMax('price', 'max_price');

        $product_variant_builder->where('product_id', $product_id);
        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
        $product_variant_builder->where('customer_id', $this->customer->getId());

        $product_variant_query = $product_variant_builder->get();

        $product_variant = [];

        if ($product_variant_row = $product_variant_query->getRow()) {
            $product_variant = [
                'min_price' => $product_variant_row->min_price,
                'max_price' => $product_variant_row->max_price,
            ];
        }

        return $product_variant;
    }

    public function getProductVariantMinMaxQuantities($product_id)
    {
        $product_variant_builder = $this->db->table('product_variant');
        $product_variant_builder->selectMin('quantity', 'min_quantity');
        $product_variant_builder->selectMax('quantity', 'max_quantity');

        $product_variant_builder->where('product_id', $product_id);
        $product_variant_builder->where('seller_id', $this->customer->getSellerId());
        $product_variant_builder->where('customer_id', $this->customer->getId());

        $product_variant_query = $product_variant_builder->get();

        $product_variant = [];

        if ($product_variant_row = $product_variant_query->getRow()) {
            $product_variant = [
                'min_quantity' => $product_variant_row->min_quantity,
                'max_quantity' => $product_variant_row->max_quantity,
            ];
        }

        return $product_variant;
    }

    public function getProductVariantSpecials($product_id, $options)
    {
        $product_variant_special_builder = $this->db->table('product_variant_special');

        $product_variant_special_builder->where('product_id', $product_id);
        $product_variant_special_builder->where('seller_id', $this->customer->getSellerId());
        $product_variant_special_builder->where('customer_id', $this->customer->getId());

        $product_variant_special_builder->orderBy('priority', 'ASC');

        $option_values = [];

        foreach ($options as $option) {
            $option_values[$option['option_id']] = $option['option_value_id'];
        }

        asort($option_values);

        $product_variant_special_builder->where('options', json_encode($option_values));

        $product_variant_special_query = $product_variant_special_builder->get();

        $product_variant_specials = [];

        foreach ($product_variant_special_query->getResult() as $result) {
            $product_variant_specials[] = [
                'product_variant_special_id' => $result->product_variant_special_id,
                'product_variant_id' => $result->product_variant_id,
                'options' => $result->options,
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'priority' => $result->priority,
                'price' => $result->price,
                'date_start' => $result->date_start,
                'date_end' => $result->date_end,
            ];
        }

        return $product_variant_specials;
    }

    public function getProductVariantDiscounts($product_id, $options)
    {
        $product_variant_discount_builder = $this->db->table('product_variant_discount');

        $product_variant_discount_builder->where('product_id', $product_id);
        $product_variant_discount_builder->where('seller_id', $this->customer->getSellerId());
        $product_variant_discount_builder->where('customer_id', $this->customer->getId());

        $product_variant_discount_builder->orderBy('priority', 'ASC');
        $product_variant_discount_builder->orderBy('min_quantity', 'ASC');

        $option_values = [];

        foreach ($options as $option) {
            $option_values[$option['option_id']] = $option['option_value_id'];
        }

        asort($option_values);

        $product_variant_discount_builder->where('options', json_encode($option_values));

        $product_variant_discount_query = $product_variant_discount_builder->get();

        $product_variant_discounts = [];

        foreach ($product_variant_discount_query->getResult() as $result) {
            $product_variant_discounts[] = [
                'product_variant_discount_id' => $result->product_variant_discount_id,
                'product_variant_id' => $result->product_variant_id,
                'options' => $result->options,
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'priority' => $result->priority,
                'min_quantity' => $result->min_quantity,
                'max_quantity' => $result->max_quantity,
                'price' => $result->price,
                'date_start' => $result->date_start,
                'date_end' => $result->date_end,
            ];
        }

        return $product_variant_discounts;
    }

    public function getProductImages($product_id)
    {
        $builder = $this->db->table('product_image');

        $builder->where('product_id', $product_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());

        $product_image_query = $builder->get();

        $product_images = [];

        foreach ($product_image_query->getResult() as $result) {
            $product_images[] = [
                'product_id' => $result->product_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'image' => $result->image,
            ];
        }

        return $product_images;
    }

    public function getProductDownloads($product_id)
    {
        $product_download_builder = $this->db->table('product_download');

        $product_download_builder->where('product_id', $product_id);
        $product_download_builder->where('seller_id', $this->customer->getSellerId());
        $product_download_builder->where('customer_id', $this->customer->getId());

        $product_download_query = $product_download_builder->get();

        $product_downloads = [];

        foreach ($product_download_query->getResult() as $product_download_result) {
            $product_download_description_builder = $this->db->table('product_download_description');

            $product_download_description_builder->where('product_download_id',$product_download_result->product_download_id);

            $product_download_description_query = $product_download_description_builder->get();

            $product_download_descriptions = [];

            foreach ($product_download_description_query->getResult() as $product_download_description_result) {
                $product_download_descriptions[$product_download_description_result->language_id] = [
                    'product_download_description_id' => $product_download_description_result->product_download_description_id,
                    'product_download_id' => $product_download_description_result->product_download_id,
                    'language_id' => $product_download_description_result->language_id,
                    'name' => $product_download_description_result->name,
                ];
            }

            $product_downloads[] = [
                'product_download_id' => $product_download_result->product_download_id,
                'product_id' => $product_download_result->product_id,
                'seller_id' => $product_download_result->seller_id,
                'customer_id' => $product_download_result->customer_id,
                'filename' => $product_download_result->filename,
                'mask' => $product_download_result->mask,
                'date_added' => $product_download_result->date_added,
                'description' => $product_download_descriptions,
            ];
        }

        return $product_downloads;
    }

    public function getProductDownloadDescriprions($product_download_id)
    {
        $builder = $this->db->table('product_download_description');

        $builder->where('product_download_id', $product_download_id);

        $product_download_description_query = $builder->get();

        $product_download_descriptions = [];

        foreach ($product_download_description_query->getResult() as $result) {
            $product_download_descriptions[$result->language_id] = [
                'product_download_description_id' => $result->product_download_description_id,
                'product_download_id' => $result->product_download_id,
                'language_id' => $result->language_id,
                'name' => $result->name,
            ];
        }

        return $product_download_descriptions;
    }

    public function getProductSpecials($product_id)
    {
        $product_special_builder = $this->db->table('product_special');

        $product_special_builder->where('product_id', $product_id);
        $product_special_builder->where('seller_id', $this->customer->getSellerId());
        $product_special_builder->where('customer_id', $this->customer->getId());

        $product_special_builder->orderBy('priority', 'ASC');

        $product_special_query = $product_special_builder->get();

        $product_specials = [];

        foreach ($product_special_query->getResult() as $product_special_result) {
            $product_specials[] = [
                'product_special_id' => $product_special_result->product_special_id,
                'product_id' => $product_special_result->product_id,
                'seller_id' => $product_special_result->seller_id,
                'customer_id' => $product_special_result->customer_id,
                'priority' => $product_special_result->priority,
                'price' => $product_special_result->price,
                'date_start' => $product_special_result->date_start,
                'date_end' => $product_special_result->date_end,
            ];
        }

        return $product_specials;
    }

    public function getProductDiscounts($product_id)
    {
        $product_discount_builder = $this->db->table('product_discount');

        $product_discount_builder->where('product_id', $product_id);
        $product_discount_builder->where('seller_id', $this->customer->getSellerId());
        $product_discount_builder->where('customer_id', $this->customer->getId());

        $product_discount_builder->orderBy('priority', 'ASC');
        $product_discount_builder->orderBy('min_quantity', 'ASC');

        $product_discount_query = $product_discount_builder->get();

        $product_discounts = [];

        foreach ($product_discount_query->getResult() as $product_discount_result) {
            $product_discounts[] = [
                'product_discount_id' => $product_discount_result->product_discount_id,
                'product_id' => $product_discount_result->product_id,
                'seller_id' => $product_discount_result->seller_id,
                'customer_id' => $product_discount_result->customer_id,
                'priority' => $product_discount_result->priority,
                'min_quantity' => $product_discount_result->min_quantity,
                'max_quantity' => $product_discount_result->max_quantity,
                'price' => $product_discount_result->price,
                'date_start' => $product_discount_result->date_start,
                'date_end' => $product_discount_result->date_end,
            ];
        }

        return $product_discounts;
    }
}