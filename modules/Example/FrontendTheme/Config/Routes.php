<?php

// BackEnd

// Frontend Theme Example
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_theme/example/example/(:any)', 'Modules\Example\FrontendTheme\Controllers\BackEnd\Example::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_theme/example/example', 'Modules\Example\FrontendTheme\Controllers\BackEnd\Example::index');
