<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/admin/appearance/admin/theme/com_bukausahaonline/test', '\ThemeAdmin\com_bukausahaonline\Test\Controllers\Admin\Appearance\Admin\Theme\com_bukausahaonline\Test::index');
$routes->match(['get', 'post'], '/admin/appearance/admin/theme/com_bukausahaonline/test/get_info', '\ThemeAdmin\com_bukausahaonline\Test\Controllers\Admin\Appearance\Admin\Theme\com_bukausahaonline\Test::get_info');
