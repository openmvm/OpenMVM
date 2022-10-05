<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('/', function ($routes) {
    // Admin
    $routes->group(env('app.adminUrlSegment'), function ($routes) {
        // Appearance
        $routes->group('appearance', function ($routes) {
            // Marketplace
            $routes->group('marketplace', function ($routes) {
                // Widget
                $routes->group('widget', function ($routes) {
                    // com_bukausahaonline
                    $routes->group('com_bukausahaonline', function ($routes) {
                        // Blank
                        $routes->group('Blank', function ($routes) {
                            $routes->match(['get', 'post'], 'get_info', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets\Blank::index');
                            $routes->match(['get', 'post'], 'edit/(:num)', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets\Blank::index');
                            $routes->match(['get', 'post'], 'save/(:num)', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets\Blank::save');
                        });
                    });
                });
            });
        });
        // Plugin
        $routes->group('plugin', function ($routes) {
            // Plugin
            $routes->group('plugin', function ($routes) {
                // com_bukausahaonline
                $routes->group('com_bukausahaonline', function ($routes) {
                    // Blank
                    $routes->group('Widget_Blank', function ($routes) {
                        $routes->match(['get', 'post'], 'get_info', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Plugin\Plugin::get_info');
                    });
                });
            });
        });
    });
});
