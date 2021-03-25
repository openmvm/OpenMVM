<?php

// BackEnd

// Frontend Widget
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets/delete/(:num)/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::delete');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets/add/(:any)/(:any)/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets/uninstall/(:any)/(:any)/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::uninstall');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets/install/(:any)/(:any)/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::install');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widgets', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendWidget::index');

// Frontend Theme
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_themes/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendTheme::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_themes', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendTheme::index');

// Frontend Layout
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts/edit/(:num)/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts/edit/(:num)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts/add/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts/add', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts/(:any)', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_layouts', 'Modules\OpenMVM\Theme\Controllers\BackEnd\FrontendLayout::index');
