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
                // Theme
                $routes->group('theme', function ($routes) {
                    // com_bukausahaonline
                    $routes->group('com_bukausahaonline', function ($routes) {
                        // test
                        $routes->group('test', function ($routes) {
                            $routes->match(['get', 'post'], '/', '\ThemeMarketplace\com_bukausahaonline\Test\Controllers\Admin\Appearance\Marketplace\Theme\com_bukausahaonline\Test::index');
                            $routes->match(['get', 'post'], 'get_info', '\ThemeMarketplace\com_bukausahaonline\Test\Controllers\Admin\Appearance\Marketplace\Theme\com_bukausahaonline\Test::get_info');
                        });
                    });
                });
            });
        });
    });
});
