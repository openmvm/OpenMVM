<?php
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/admin/appearance/admin/theme/com_openmvm/basic', '\ThemeAdmin\com_openmvm\Basic\Controllers\Admin\Appearance\Admin\Theme\com_openmvm\Basic::index');
$routes->match(['get', 'post'], '/admin/appearance/admin/theme/com_openmvm/basic/get_info', '\ThemeAdmin\com_openmvm\Basic\Controllers\Admin\Appearance\Admin\Theme\com_openmvm\Basic::get_info');
