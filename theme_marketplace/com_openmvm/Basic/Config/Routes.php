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
                    // com_openmvm
                    $routes->group('com_openmvm', function ($routes) {
                        // basic
                        $routes->group('basic', function ($routes) {
                            $routes->match(['get', 'post'], '/', '\ThemeMarketplace\com_openmvm\Basic\Controllers\Admin\Appearance\Marketplace\Theme\com_openmvm\Basic::index');
                            $routes->match(['get', 'post'], 'get_info', '\ThemeMarketplace\com_openmvm\Basic\Controllers\Admin\Appearance\Marketplace\Theme\com_openmvm\Basic::get_info');
                        });
                    });
                });
            });
        });
    });
});
