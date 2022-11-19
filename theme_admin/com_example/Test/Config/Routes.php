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
            // Admin
            $routes->group('admin', function ($routes) {
                // Theme
                $routes->group('theme', function ($routes) {
                    // com_example
                    $routes->group('com_example', function ($routes) {
                        // test
                        $routes->group('test', function ($routes) {
                            $routes->match(['get', 'post'], '/', '\ThemeAdmin\com_example\Test\Controllers\Admin\Appearance\Admin\Theme\com_example\Test::index');
                            $routes->match(['get', 'post'], 'get_info', '\ThemeAdmin\com_example\Test\Controllers\Admin\Appearance\Admin\Theme\com_example\Test::get_info');
                        });
                    });
                });
            });
        });
    });
});
