<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/admin/appearance/marketplace/theme/com_openmvm/basic', '\ThemeMarketplace\com_openmvm\Basic\Controllers\Admin\Appearance\Marketplace\Theme\com_openmvm\Basic::index');
$routes->match(['get', 'post'], '/admin/appearance/marketplace/theme/com_openmvm/basic/get_info', '\ThemeMarketplace\com_openmvm\Basic\Controllers\Admin\Appearance\Marketplace\Theme\com_openmvm\Basic::get_info');
