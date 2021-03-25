<?php

// BackEnd

// Frontend Theme Default
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_theme/openmvm/default/(:any)', 'Modules\OpenMVM\FrontendTheme\Controllers\BackEnd\ThemeDefault::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_theme/openmvm/default', 'Modules\OpenMVM\FrontendTheme\Controllers\BackEnd\ThemeDefault::index');
