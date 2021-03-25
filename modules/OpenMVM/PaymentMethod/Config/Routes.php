<?php

// BackEnd

// Payment Method COD
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods/OpenMVM/cod/edit/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod\Cod::index');

// Payment Method Bank Transfer
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods/OpenMVM/bank_transfer/edit/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod\BankTransfer::index');

// Payment Methods
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods/uninstall/(:any)/(:any)/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod::uninstall');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods/install/(:any)/(:any)/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod::install');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/payment_methods', 'Modules\OpenMVM\PaymentMethod\Controllers\BackEnd\PaymentMethod::index');


// FrontEnd

// COD
$routes->match(['get', 'post', 'patch', 'delete'], '/payment_method/cod/confirm/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd\Cod::confirm');
$routes->match(['get', 'post', 'patch', 'delete'], '/payment_method/cod/confirm', 'Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd\Cod::confirm');

// Bank Transfer
$routes->match(['get', 'post', 'patch', 'delete'], '/payment_method/bank_transfer/confirm/(:any)', 'Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd\Cod::confirm');
$routes->match(['get', 'post', 'patch', 'delete'], '/payment_method/bank_transfer/confirm', 'Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd\BankTransfer::confirm');
