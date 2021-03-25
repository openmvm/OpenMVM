<?php

// BackEnd

// Front-end Widgets
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widget/edit/OpenMVM/Store/latest/(:num)/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\FrontendWidgets\Latest::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widget/edit/OpenMVM/Store/latest/(:num)', 'Modules\OpenMVM\Store\Controllers\BackEnd\FrontendWidgets\Latest::index');

$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widget/edit/OpenMVM/Store/category/(:num)/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\FrontendWidgets\Category::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/frontend_widget/edit/OpenMVM/Store/category/(:num)', 'Modules\OpenMVM\Store\Controllers\BackEnd\FrontendWidgets\Category::index');

// Categories
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/autocomplete/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::autocomplete');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/autocomplete', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::autocomplete');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/edit/(:num)/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/edit/(:num)', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/add/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/add', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories/(:any)', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/categories', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::index');

// FrontEnd

// Search Products
$routes->match(['get', 'post', 'patch', 'delete'], '/product/search', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Search::index');

// Categories
$routes->match(['get', 'post', 'patch', 'delete'], '/category/autocomplete', 'Modules\OpenMVM\Store\Controllers\BackEnd\Category::autocomplete');
$routes->match(['get', 'post', 'patch', 'delete'], '/category/(:any)/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Category::index');

// Products
$routes->match(['get', 'post', 'patch', 'delete'], '/product/view/(:num)/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::getInfo');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products/edit/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products/edit', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products/add/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products/add', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/products', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Product::index');

// Store
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/edit/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Store::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/edit', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Store::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/add/(:any)', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Store::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/store/add', 'Modules\OpenMVM\Store\Controllers\FrontEnd\Store::add');

