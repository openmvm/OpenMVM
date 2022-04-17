<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/admin/appearance/marketplace/widgets/com_bukausahaonline/Blank', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets\Blank::index');
$routes->match(['get', 'post'], '/admin/appearance/marketplace/widgets/com_bukausahaonline/Blank/edit/(:num)', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets\Blank::edit');
$routes->match(['get', 'post'], '/admin/plugin/plugin/com_bukausahaonline/widget_blank/get_info', '\Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Plugin\Plugin::get_info');
