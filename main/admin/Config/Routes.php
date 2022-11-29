<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('/', function ($routes) {
    $routes->group(env('app.adminUrlSegment'), function ($routes) {
        $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Common\Dashboard::index', ['filter' => 'admin_auth']);

        // Administrator
        $routes->group('administrator', function ($routes) {
            // Administrator
            $routes->group('administrator', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Administrator\Administrator::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Administrator\Administrator::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Administrator\Administrator::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Administrator\Administrator::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Administrator\Administrator::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Administrator\Administrator::save', ['filter' => 'admin_auth']);
                });
            });
            // Administrator group
            $routes->group('administrator_group', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Administrator\Administrator_Group::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Administrator\Administrator_Group::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Administrator\Administrator_Group::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Administrator\Administrator_Group::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Administrator\Administrator_Group::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Administrator\Administrator_Group::save', ['filter' => 'admin_auth']);
                });
            });
            // Login
            $routes->group('login', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Administrator\Login::index');
                $routes->match(['get', 'post'], 'go', '\Main\Admin\Controllers\Administrator\Login::go');
            });

            // Logout
            $routes->match(['get', 'post'], 'logout', '\Main\Admin\Controllers\Administrator\Logout::index');
        });

        // Appearance
        $routes->group('appearance', function ($routes) {
            // Admin
            $routes->group('admin', function ($routes) {
                // Theme
                $routes->group('theme', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Appearance\Admin\Theme::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'activate', '\Main\Admin\Controllers\Appearance\Admin\Theme::activate', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'deactivate', '\Main\Admin\Controllers\Appearance\Admin\Theme::deactivate', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'set_admin_theme', '\Main\Admin\Controllers\Appearance\Admin\Theme::set_admin_theme', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'remove', '\Main\Admin\Controllers\Appearance\Admin\Theme::remove', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'upload', '\Main\Admin\Controllers\Appearance\Admin\Theme::upload', ['filter' => 'admin_auth']);
                });
            });
            // Marketplace
            $routes->group('marketplace', function ($routes) {
                // Layout
                $routes->group('layout', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::add', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::edit', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::delete', ['filter' => 'admin_auth']);
                    $routes->group('save', function ($routes) {
                        $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::save', ['filter' => 'admin_auth']);
                        $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Layout::save', ['filter' => 'admin_auth']);
                    });
                });
                // Theme
                $routes->group('theme', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'activate', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::activate', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'deactivate', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::deactivate', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'set_marketplace_theme', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::set_marketplace_theme', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'remove', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::remove', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'upload', '\Main\Admin\Controllers\Appearance\Marketplace\Theme::upload', ['filter' => 'admin_auth']);
                });
                // Widget
                $routes->group('widget', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Appearance\Marketplace\Widget::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'add/(:any)/(:any)', '\Main\Admin\Controllers\Appearance\Marketplace\Widget::add', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'install/(:any)/(:any)', '\Main\Admin\Controllers\Appearance\Marketplace\Widget::install', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'uninstall/(:any)/(:any)', '\Main\Admin\Controllers\Appearance\Marketplace\Widget::uninstall', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'delete/(:any)/(:any)', '\Main\Admin\Controllers\Appearance\Marketplace\Widget::delete', ['filter' => 'admin_auth']);
                    // Widgets
                    $routes->group('Category', function ($routes) {
                        $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Category::index', ['filter' => 'admin_auth']);
                        $routes->match(['get', 'post'], 'save/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Category::save', ['filter' => 'admin_auth']);
                    });
                    $routes->group('HTML_Content', function ($routes) {
                        $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\HTML_Content::index', ['filter' => 'admin_auth']);
                        $routes->match(['get', 'post'], 'save/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\HTML_Content::save', ['filter' => 'admin_auth']);
                    });
                    $routes->group('Link', function ($routes) {
                        $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Link::index', ['filter' => 'admin_auth']);
                        $routes->match(['get', 'post'], 'save/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Link::save', ['filter' => 'admin_auth']);
                    });
                    $routes->group('Page', function ($routes) {
                        $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Page::index', ['filter' => 'admin_auth']);
                        $routes->match(['get', 'post'], 'save/(:num)', '\Main\Admin\Controllers\Appearance\Marketplace\Widgets\Page::save', ['filter' => 'admin_auth']);
                    });
                });
            });
        });

        // Common
        $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Common\Dashboard::index', ['filter' => 'admin_auth']);

        $routes->match(['get', 'post'], 'common/dashboard', '\Main\Admin\Controllers\Common\Dashboard::index', ['filter' => 'admin_auth']);

        // Component
        $routes->group('component', function ($routes) {
            // Analytics
            $routes->group('analytics', function ($routes) {
                // Google Analytics 4
                $routes->group('Google_Analytics_4', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Analytics\Google_Analytics_4::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Analytics\Google_Analytics_4::save', ['filter' => 'admin_auth']);
                });
            });
            // Component
            $routes->group('component', function ($routes) {
                // Analytics
                $routes->group('analytics', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Component\Analytics::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'install', '\Main\Admin\Controllers\Component\Component\Analytics::install', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'uninstall', '\Main\Admin\Controllers\Component\Component\Analytics::uninstall', ['filter' => 'admin_auth']);
                });
                // Order total
                $routes->group('order_total', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Component\Order_Total::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'install', '\Main\Admin\Controllers\Component\Component\Order_Total::install', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'uninstall', '\Main\Admin\Controllers\Component\Component\Order_Total::uninstall', ['filter' => 'admin_auth']);
                });
                // Payment method
                $routes->group('payment_method', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Component\Payment_Method::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'install', '\Main\Admin\Controllers\Component\Component\Payment_Method::install', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'uninstall', '\Main\Admin\Controllers\Component\Component\Payment_Method::uninstall', ['filter' => 'admin_auth']);
                });
                // Shipping method
                $routes->group('shipping_method', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Component\Shipping_Method::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'install', '\Main\Admin\Controllers\Component\Component\Shipping_Method::install', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'uninstall', '\Main\Admin\Controllers\Component\Component\Shipping_Method::uninstall', ['filter' => 'admin_auth']);
                });
            });
            // Order total
            $routes->group('order_total', function ($routes) {
                // Shipping
                $routes->group('Shipping', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Order_Total\Shipping::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Order_Total\Shipping::save', ['filter' => 'admin_auth']);
                });
                // Sub total
                $routes->group('Sub_Total', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Order_Total\Sub_Total::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Order_Total\Sub_Total::save', ['filter' => 'admin_auth']);
                });
                // Total
                $routes->group('Total', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Order_Total\Total::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Order_Total\Total::save', ['filter' => 'admin_auth']);
                });
            });
            // Payment method
            $routes->group('payment_method', function ($routes) {
                // Bank transfer
                $routes->group('Bank_Transfer', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Payment_Method\Bank_Transfer::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Payment_Method\Bank_Transfer::save', ['filter' => 'admin_auth']);
                });
                // Cash on delivery
                $routes->group('Cash_On_Delivery', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Payment_Method\Cash_On_Delivery::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Payment_Method\Cash_On_Delivery::save', ['filter' => 'admin_auth']);
                });
            });
            // Shipping method
            $routes->group('shipping_method', function ($routes) {
                // Flat rate
                $routes->group('Flat_Rate', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Shipping_Method\Flat_Rate::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Shipping_Method\Flat_Rate::save', ['filter' => 'admin_auth']);
                });
                // Weight based
                $routes->group('Weight_Based', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Shipping_Method\Weight_Based::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Shipping_Method\Weight_Based::save', ['filter' => 'admin_auth']);
                });
                // Zone based
                $routes->group('Zone_Based', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Component\Shipping_Method\Zone_Based::index', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\Component\Shipping_Method\Zone_Based::save', ['filter' => 'admin_auth']);
                });
            });
        });

        // Customer
        $routes->group('customer', function ($routes) {
            // Customer
            $routes->group('customer', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Customer\Customer::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Customer\Customer::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Customer\Customer::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Customer\Customer::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Customer\Customer::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Customer\Customer::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'add_transaction', '\Main\Admin\Controllers\Customer\Customer::add_transaction', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'wallet', '\Main\Admin\Controllers\Customer\Customer::wallet', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'wallet_balance', '\Main\Admin\Controllers\Customer\Customer::wallet_balance', ['filter' => 'admin_auth']);
            });
            // Customer group
            $routes->group('customer_group', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Customer\Customer_Group::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Customer\Customer_Group::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Customer\Customer_Group::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Customer\Customer_Group::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Customer\Customer_Group::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Customer\Customer_Group::save', ['filter' => 'admin_auth']);
                });
            });
        });

        // Developer
        $routes->group('developer', function ($routes) {
            // Language editor
            $routes->group('language_editor', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Developer\Language_Editor::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Developer\Language_Editor::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:alphanum)', '\Main\Admin\Controllers\Developer\Language_Editor::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Developer\Language_Editor::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Developer\Language_Editor::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Developer\Language_Editor::save', ['filter' => 'admin_auth']);
                });
            });
            // Demo manager
            $routes->group('demo_manager', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Developer\Demo_Manager::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'upload', '\Main\Admin\Controllers\Developer\Demo_Manager::upload', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'extract', '\Main\Admin\Controllers\Developer\Demo_Manager::extract', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'import_sql', '\Main\Admin\Controllers\Developer\Demo_Manager::import_sql', ['filter' => 'admin_auth']);
            });
        });

        // File manager
        $routes->group('file_manager', function ($routes) {
            // Image manager
            $routes->group('image_manager', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\File_Manager\Image_Manager::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'workspace', '\Main\Admin\Controllers\File_Manager\Image_Manager::workspace', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'create_directory', '\Main\Admin\Controllers\File_Manager\Image_Manager::create_directory', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'upload', '\Main\Admin\Controllers\File_Manager\Image_Manager::upload', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'compress', '\Main\Admin\Controllers\File_Manager\Image_Manager::compress', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'download', '\Main\Admin\Controllers\File_Manager\Image_Manager::download', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'rebuild_cache', '\Main\Admin\Controllers\File_Manager\Image_Manager::rebuild_cache', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'refresh', '\Main\Admin\Controllers\File_Manager\Image_Manager::refresh', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'remove', '\Main\Admin\Controllers\File_Manager\Image_Manager::remove', ['filter' => 'admin_auth']);
            });
        });

        // Localisation
        $routes->group('localisation', function ($routes) {
            // Country
            $routes->group('country', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Country::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Country::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Country::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Country::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Country::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Country::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'get_country', '\Main\Admin\Controllers\Localisation\Country::get_country', ['filter' => 'admin_auth']);
            });
            // Currency
            $routes->group('currency', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Currency::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Currency::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Currency::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Currency::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Currency::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Currency::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'refresh', '\Main\Admin\Controllers\Localisation\Currency::refresh', ['filter' => 'admin_auth']);
            });
            // Geo zone
            $routes->group('geo_zone', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Geo_Zone::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Geo_Zone::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Geo_Zone::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Geo_Zone::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Geo_Zone::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Geo_Zone::save', ['filter' => 'admin_auth']);
                });
            });
            // Language
            $routes->group('language', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Language::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Language::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Language::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Language::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Language::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Language::save', ['filter' => 'admin_auth']);
                });
            });
            // Length class
            $routes->group('length_class', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Length_Class::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Length_Class::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Length_Class::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Length_Class::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Length_Class::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Length_Class::save', ['filter' => 'admin_auth']);
                });
            });
            // Order status
            $routes->group('order_status', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Order_Status::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Order_Status::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Order_Status::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Order_Status::delete', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'autocomplete', '\Main\Admin\Controllers\Localisation\Order_Status::autocomplete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Order_Status::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Order_Status::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'get_order_status', '\Main\Admin\Controllers\Localisation\Order_Status::get_order_status', ['filter' => 'admin_auth']);
            });
            // Weight class
            $routes->group('weight_class', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Weight_Class::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Weight_Class::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Weight_Class::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Weight_Class::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Weight_Class::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Weight_Class::save', ['filter' => 'admin_auth']);
                });
            });
            // Zone
            $routes->group('zone', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Zone::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Localisation\Zone::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Localisation\Zone::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Localisation\Zone::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Localisation\Zone::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Localisation\Zone::save', ['filter' => 'admin_auth']);
                });
            });
        });

        // Marketplace
        $routes->group('marketplace', function ($routes) {
            // Category
            $routes->group('category', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Marketplace\Category::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Marketplace\Category::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Marketplace\Category::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Marketplace\Category::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Marketplace\Category::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Marketplace\Category::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'autocomplete', '\Main\Admin\Controllers\Marketplace\Category::autocomplete', ['filter' => 'admin_auth']);
            });
            // Order
            $routes->group('order', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Marketplace\Order::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Marketplace\Order::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Marketplace\Order::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Marketplace\Order::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Marketplace\Order::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Marketplace\Order::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'info/(:num)', '\Main\Admin\Controllers\Marketplace\Order::info', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'update_order_status_history', '\Main\Admin\Controllers\Marketplace\Order::update_order_status_history', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'order_status_history', '\Main\Admin\Controllers\Marketplace\Order::order_status_history', ['filter' => 'admin_auth']);
            });
        });

        // Page
        $routes->group('page', function ($routes) {
            // Page
            $routes->group('page', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Page\Page::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'add', '\Main\Admin\Controllers\Page\Page::add', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'edit/(:num)', '\Main\Admin\Controllers\Page\Page::edit', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete', '\Main\Admin\Controllers\Page\Page::delete', ['filter' => 'admin_auth']);
                $routes->group('save', function ($routes) {
                    $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Page\Page::save', ['filter' => 'admin_auth']);
                    $routes->match(['get', 'post'], '(:num)', '\Main\Admin\Controllers\Page\Page::save', ['filter' => 'admin_auth']);
                });
                $routes->match(['get', 'post'], 'autocomplete', '\Main\Admin\Controllers\Page\Page::autocomplete', ['filter' => 'admin_auth']);
            });
        });

        // Plugin
        $routes->group('plugin', function ($routes) {
            // Plugin
            $routes->group('plugin', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\Plugin\Plugin::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'upload', '\Main\Admin\Controllers\Plugin\Plugin::upload', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'activate', '\Main\Admin\Controllers\Plugin\Plugin::activate', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'deactivate', '\Main\Admin\Controllers\Plugin\Plugin::deactivate', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'update', '\Main\Admin\Controllers\Plugin\Plugin::update', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'remove', '\Main\Admin\Controllers\Plugin\Plugin::remove', ['filter' => 'admin_auth']);
            });
        });

        // System
        $routes->group('system', function ($routes) {
            // Error log
            $routes->group('error_log', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\System\Error_Log::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'get_error', '\Main\Admin\Controllers\System\Error_Log::get_error', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'delete_error', '\Main\Admin\Controllers\System\Error_Log::delete_error', ['filter' => 'admin_auth']);
            });
            // Performance
            $routes->group('performance', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\System\Performance::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'clear_cache', '\Main\Admin\Controllers\System\Performance::clear_cache', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\System\Performance::save', ['filter' => 'admin_auth']);
            });
            // Setting
            $routes->group('setting', function ($routes) {
                $routes->match(['get', 'post'], '/', '\Main\Admin\Controllers\System\Setting::index', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'update_setting_value', '\Main\Admin\Controllers\System\Setting::update_setting_value', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'set_environment', '\Main\Admin\Controllers\System\Setting::set_environment', ['filter' => 'admin_auth']);
                $routes->match(['get', 'post'], 'save', '\Main\Admin\Controllers\System\Setting::save', ['filter' => 'admin_auth']);
            });
        });
    });
});