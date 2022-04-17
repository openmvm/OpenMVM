<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/admin/appearance/marketplace/theme/com_bukausahaonline/test', '\ThemeMarketplace\com_bukausahaonline\Test\Controllers\Admin\Appearance\Marketplace\Theme\com_bukausahaonline\Test::index');
$routes->match(['get', 'post'], '/admin/appearance/marketplace/theme/com_bukausahaonline/test/get_info', '\ThemeMarketplace\com_bukausahaonline\Test\Controllers\Admin\Appearance\Marketplace\Theme\com_bukausahaonline\Test::get_info');
