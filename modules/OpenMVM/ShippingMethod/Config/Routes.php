<?php

// BackEnd

// Shipping Method FedEx
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/fedex/edit/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod\Fedex::index');

// Shipping Method Weight Based
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/weight/edit/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod\Weight::index');

// Shipping Method Flat Rate
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/flat/edit/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod\Flat::index');

// Shipping Methods
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/uninstall/(:any)/(:any)/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod::uninstall');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/install/(:any)/(:any)/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod::install');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/shipping_methods', 'Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod::index');

// FrontEnd

// Shipping Method FedEx
$routes->match(['get', 'post', 'patch', 'delete'], 'account/store/shipping_methods/OpenMVM/fedex/edit/(:any)', 'Modules\OpenMVM\ShippingMethod\Controllers\FrontEnd\ShippingMethod\Fedex::index');
