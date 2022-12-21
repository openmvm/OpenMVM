<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('/', function ($routes) {
    // Marketplace
    $routes->group('marketplace', function ($routes) {
        // Account
        $routes->group('account', function ($routes) {
            $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Account::index', ['filter' => 'marketplace_auth']);
            $routes->match(['get', 'post'], 'account', '\Main\Marketplace\Controllers\Account\Account::index', ['filter' => 'marketplace_auth']);
            // Address
            $routes->group('address', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Address::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Account\Address::add', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Account\Address::edit', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Account\Address::delete', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Address::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Account\Address::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Product download
            $routes->group('product_download', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Product_Download::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get/(:num)', '\Main\Marketplace\Controllers\Account\Product_Download::get/$1', ['filter' => 'marketplace_auth']);
            });
            // Login
            $routes->group('login', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Login::index');
                $routes->match(['get', 'post'], 'go', '\Main\Marketplace\Controllers\Account\Login::go');
            });
            // Logout
            $routes->match(['get', 'post'], 'logout', '\Main\Marketplace\Controllers\Account\Logout::index');
            // Order
            $routes->group('order', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Order::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'info/(:num)', '\Main\Marketplace\Controllers\Account\Order::info', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'update_order_status', '\Main\Marketplace\Controllers\Account\Order::update_order_status', ['filter' => 'marketplace_auth']);
            });
            // Profile
            $routes->group('profile', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Profile::index', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Profile::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Account\Profile::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Register
            $routes->group('register', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Register::index');
                $routes->match(['get', 'post'], 'go', '\Main\Marketplace\Controllers\Account\Register::go');
            });
            // Reset password
            $routes->match(['get', 'post'], 'reset_password', '\Main\Marketplace\Controllers\Account\Reset_Password::index');
            // Product Review
            $routes->group('product_review', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Product_Review::index');
                $routes->match(['get', 'post'], 'add/(:num)', '\Main\Marketplace\Controllers\Account\Product_Review::add');
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Account\Product_Review::edit');
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Account\Product_Review::save');
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Account\Product_Review::save');
                });
            });
            // Wallet
            $routes->match(['get', 'post'], 'wallet', '\Main\Marketplace\Controllers\Account\Wallet::index', ['filter' => 'marketplace_auth']);
            // Wishlist
            $routes->match(['get', 'post'], 'wishlist', '\Main\Marketplace\Controllers\Account\Wishlist::index', ['filter' => 'marketplace_auth']);
        });
        // Appearance
        $routes->group('appearance', function ($routes) {
            // Marketplace
            $routes->group('marketplace', function ($routes) {
                // Widgets
                $routes->group('widgets', function ($routes) {
                    // Seller Dashboard Chart
                    $routes->group('seller_dashboard_chart', function ($routes) {
                        $routes->match(['get', 'post'], 'get_orders', '\Main\Marketplace\Controllers\Appearance\Marketplace\Widgets\Seller_Dashboard_Chart::get_orders', ['filter' => 'marketplace_auth']);
                        $routes->match(['get', 'post'], 'get_revenue', '\Main\Marketplace\Controllers\Appearance\Marketplace\Widgets\Seller_Dashboard_Chart::get_revenue', ['filter' => 'marketplace_auth']);
                        $routes->match(['get', 'post'], 'get_months', '\Main\Marketplace\Controllers\Appearance\Marketplace\Widgets\Seller_Dashboard_Chart::get_months', ['filter' => 'marketplace_auth']);
                        $routes->match(['get', 'post'], 'get_days', '\Main\Marketplace\Controllers\Appearance\Marketplace\Widgets\Seller_Dashboard_Chart::get_days', ['filter' => 'marketplace_auth']);
                    });
                });
            });
        });
        // Checkout
        $routes->group('checkout', function ($routes) {
            // Cart
            $routes->group('cart', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Checkout\Cart::index');
                $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Checkout\Cart::add');
                $routes->match(['get', 'post'], 'update', '\Main\Marketplace\Controllers\Checkout\Cart::update');
                $routes->match(['get', 'post'], 'remove', '\Main\Marketplace\Controllers\Checkout\Cart::remove');
                $routes->match(['get', 'post'], 'clear', '\Main\Marketplace\Controllers\Checkout\Cart::clear');
            });
            // Checkout
            $routes->group('checkout', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Checkout\Checkout::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add_address', '\Main\Marketplace\Controllers\Checkout\Checkout::add_address', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'payment_address', '\Main\Marketplace\Controllers\Checkout\Checkout::payment_address', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'set_payment_address', '\Main\Marketplace\Controllers\Checkout\Checkout::set_payment_address', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'shipping_address', '\Main\Marketplace\Controllers\Checkout\Checkout::shipping_address', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'set_shipping_address', '\Main\Marketplace\Controllers\Checkout\Checkout::set_shipping_address', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'shipping_method', '\Main\Marketplace\Controllers\Checkout\Checkout::shipping_method', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'set_shipping_method', '\Main\Marketplace\Controllers\Checkout\Checkout::set_shipping_method', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'payment_method', '\Main\Marketplace\Controllers\Checkout\Checkout::payment_method', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'set_payment_method', '\Main\Marketplace\Controllers\Checkout\Checkout::set_payment_method', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'update_quantity', '\Main\Marketplace\Controllers\Checkout\Checkout::update_quantity', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'cart', '\Main\Marketplace\Controllers\Checkout\Checkout::cart', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'confirm', '\Main\Marketplace\Controllers\Checkout\Checkout::confirm', ['filter' => 'marketplace_auth']);
            });
            // Success
            $routes->match(['get', 'post'], 'success', '\Main\Marketplace\Controllers\Checkout\Success::index', ['filter' => 'marketplace_auth']);
        });
        // Common
        $routes->group('common', function ($routes) {
            // Cart
            $routes->group('cart', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Common\Cart::index');
            });
            // Currency
            $routes->group('currency', function ($routes) {
                $routes->match(['get', 'post'], 'set_currency', '\Main\Marketplace\Controllers\Common\Currency::set_currency');
            });
            // Language
            $routes->group('language', function ($routes) {
                $routes->match(['get', 'post'], 'set_language', '\Main\Marketplace\Controllers\Common\Language::set_language');
            });
        });
        // Component
        $routes->group('component', function ($routes) {
            // Payment method
            $routes->group('payment_method', function ($routes) {
                // Bank transfer
                $routes->group('bank_transfer', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Component\Payment_Method\Bank_Transfer::index');
                    $routes->match(['get', 'post'], 'confirm', '\Main\Marketplace\Controllers\Component\Payment_Method\Bank_Transfer::confirm');
                });
                // Cash on delivery
                $routes->group('cash_on_delivery', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Component\Payment_Method\Cash_On_Delivery::index');
                    $routes->match(['get', 'post'], 'confirm', '\Main\Marketplace\Controllers\Component\Payment_Method\Cash_On_Delivery::confirm');
                });
                // Free Checkout
                $routes->group('free_checkout', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Component\Payment_Method\Free_Checkout::index');
                    $routes->match(['get', 'post'], 'confirm', '\Main\Marketplace\Controllers\Component\Payment_Method\Free_Checkout::confirm');
                });
                // Wallet
                $routes->group('wallet', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Component\Payment_Method\Wallet::index');
                    $routes->match(['get', 'post'], 'confirm', '\Main\Marketplace\Controllers\Component\Payment_Method\Wallet::confirm');
                });
            });
        });
        // Localisation
        $routes->group('localisation', function ($routes) {
            // Country
            $routes->group('country', function ($routes) {
                $routes->match(['get', 'post'], 'get_country', '\Main\Marketplace\Controllers\Localisation\Country::get_country');
            });
        });
        // Page
        $routes->group('page', function ($routes) {
            // Page
            $routes->group('page', function ($routes) {
                // Get
                $routes->group('get', function ($routes) {
                    $routes->match(['get', 'post'], '(:any)', '\Main\Marketplace\Controllers\Page\Page::get/$1');
                });
            });
        });
        // Product
        $routes->group('product', function ($routes) {
            // Category
            $routes->group('category', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Product\Category::index');
                $routes->match(['get', 'post'], 'get/(:any)', '\Main\Marketplace\Controllers\Product\Category::get/$1');
            });
            // Customer question
            $routes->group('customer_question', function ($routes) {
                $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Product\Customer_Question::index');
                $routes->match(['get', 'post'], 'get/(:any)', '\Main\Marketplace\Controllers\Product\Customer_Question::get/$1');
                $routes->match(['get', 'post'], 'add_customer_question_answer', '\Main\Marketplace\Controllers\Product\Customer_Question::add_customer_question_answer');
                $routes->match(['get', 'post'], 'get_customer_question_answers', '\Main\Marketplace\Controllers\Product\Customer_Question::get_customer_question_answers');
                $routes->match(['get', 'post'], 'vote_customer_question_answer', '\Main\Marketplace\Controllers\Product\Customer_Question::vote_customer_question_answer', ['filter' => 'marketplace_auth']);
            });
            // Product
            $routes->group('product', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Product\Product::index');
                $routes->match(['get', 'post'], 'get/(:any)', '\Main\Marketplace\Controllers\Product\Product::get/$1');
                $routes->match(['get', 'post'], 'get_product_variant', '\Main\Marketplace\Controllers\Product\Product::get_product_variant');
                $routes->match(['get', 'post'], 'add_to_wishlist', '\Main\Marketplace\Controllers\Product\Product::add_to_wishlist');
                $routes->match(['get', 'post'], 'add_product_question', '\Main\Marketplace\Controllers\Product\Product::add_product_question', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_questions', '\Main\Marketplace\Controllers\Product\Product::get_product_questions');
                $routes->match(['get', 'post'], 'vote_product_question', '\Main\Marketplace\Controllers\Product\Product::vote_product_question', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_question_answers', '\Main\Marketplace\Controllers\Product\Product::get_product_question_answers');
                $routes->match(['get', 'post'], 'vote_product_question_answer', '\Main\Marketplace\Controllers\Product\Product::vote_product_question_answer', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_reviews', '\Main\Marketplace\Controllers\Product\Product::get_product_reviews');
            });
            // Search
            $routes->match(['get', 'post'], 'search', '\Main\Marketplace\Controllers\Product\Search::index');
        });
        // Seller
        $routes->group('seller', function ($routes) {
            // Seller Category
            $routes->group('seller_category', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Seller_Category::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Seller\Seller_Category::add', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Seller_Category::edit', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Seller\Seller_Category::delete', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Seller_Category::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Seller_Category::save', ['filter' => 'marketplace_auth']);
                });
                $routes->match(['get', 'post'], 'autocomplete', '\Main\Marketplace\Controllers\Seller\Seller_Category::autocomplete', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get/(:any)/(:any)', '\Main\Marketplace\Controllers\Seller\Seller_Category::get/$1/$2');
            });
            // Component
            $routes->group('component', function ($routes) {
                // Shipping method
                $routes->group('shipping_method', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::index', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::add', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::edit', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::delete', ['filter' => 'marketplace_auth']);
                    $routes->group('save', function ($routes) {
                        $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::save', ['filter' => 'marketplace_auth']);
                        $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Component\Shipping_Method::save', ['filter' => 'marketplace_auth']);
                    });
                });
            });
            // Localisation
            $routes->group('localisation', function ($routes) {
                // Geo zone
                $routes->group('geo_zone', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::index');
                    $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::add', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::edit', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::delete', ['filter' => 'marketplace_auth']);
                    $routes->group('save', function ($routes) {
                        $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::save', ['filter' => 'marketplace_auth']);
                        $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Localisation\Geo_Zone::save', ['filter' => 'marketplace_auth']);
                    });
                });
            });
            // Shipping method
            $routes->group('shipping_method', function ($routes) {
                // Flat rate
                $routes->group('flat_rate', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Shipping_Method\Flat_Rate::index');
                });
                // Weight based
                $routes->group('weight_based', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Shipping_Method\Weight_Based::index');
                });
                // Zone based
                $routes->group('zone_based', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Shipping_Method\Zone_Based::index');
                });
            });
            // Dashboard
            $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Dashboard::index', ['filter' => 'marketplace_auth']);
            $routes->match(['get', 'post'], 'dashboard', '\Main\Marketplace\Controllers\Seller\Dashboard::index', ['filter' => 'marketplace_auth']);
            // Edit
            $routes->group('edit', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Edit::index', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Edit::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Option
            $routes->group('option', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Option::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Seller\Option::add', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Option::edit', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Seller\Option::delete', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_option', '\Main\Marketplace\Controllers\Seller\Option::get_option', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'autocomplete', '\Main\Marketplace\Controllers\Seller\Option::autocomplete', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Option::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Option::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Order
            $routes->group('order', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Order::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'info/(:num)', '\Main\Marketplace\Controllers\Seller\Order::info', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add_tracking_number', '\Main\Marketplace\Controllers\Seller\Order::add_tracking_number', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'update_order_status', '\Main\Marketplace\Controllers\Seller\Order::update_order_status', ['filter' => 'marketplace_auth']);
            });
            // Product
            $routes->group('product', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Product::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Marketplace\Controllers\Seller\Product::add', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Product::edit', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Marketplace\Controllers\Seller\Product::delete', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'set_product_options', '\Main\Marketplace\Controllers\Seller\Product::set_product_options', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_variants', '\Main\Marketplace\Controllers\Seller\Product::get_product_variants', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_variant_specials', '\Main\Marketplace\Controllers\Seller\Product::get_product_variant_specials', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_variant_discounts', '\Main\Marketplace\Controllers\Seller\Product::get_product_variant_discounts', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'product_download_upload', '\Main\Marketplace\Controllers\Seller\Product::product_download_upload', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Product::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Product::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Product Question
            $routes->group('product_question', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Product_Question::index', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Marketplace\Controllers\Seller\Product_Question::edit', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'add_product_question_answer', '\Main\Marketplace\Controllers\Seller\Product_Question::add_product_question_answer', ['filter' => 'marketplace_auth']);
                $routes->match(['get', 'post'], 'get_product_question_answers', '\Main\Marketplace\Controllers\Seller\Product_Question::get_product_question_answers', ['filter' => 'marketplace_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Product_Question::save', ['filter' => 'marketplace_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Marketplace\Controllers\Seller\Product_Question::save', ['filter' => 'marketplace_auth']);
                });
            });
            // Register
            $routes->group('register', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Register::index', ['filter' => 'marketplace_auth']);
                $routes->group('go', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Register::go', ['filter' => 'marketplace_auth']);
                });
            });
            // Search
            $routes->match(['get', 'post'], 'search', '\Main\Marketplace\Controllers\Seller\Search::index');
            // Seller
            $routes->group('seller', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Seller\Seller::index');
                $routes->match(['get', 'post'], 'get/(:any)', '\Main\Marketplace\Controllers\Seller\Seller::get/$1');
                $routes->match(['get', 'post'], 'get_seller_categories', '\Main\Marketplace\Controllers\Seller\Seller::get_seller_categories');
                $routes->match(['get', 'post'], 'product/(:any)/(:any)', '\Main\Marketplace\Controllers\Seller\Seller::product/$1/$2');
            });
        });
        // Tool
        $routes->group('tool', function ($routes) {
            // Upload
            $routes->group('upload', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Marketplace\Controllers\Tool\Upload::index', ['filter' => 'marketplace_auth']);
            });
        });
    });
});