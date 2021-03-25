<?php

// BackEnd

// User Groups
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups/edit/(:num)/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups/edit/(:num)', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups/add/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups/add', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/user/groups', 'Modules\OpenMVM\User\Controllers\BackEnd\UserGroup::index');

// Users
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users/edit/(:num)/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\User::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users/edit/(:num)', 'Modules\OpenMVM\User\Controllers\BackEnd\User::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users/add/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\User::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users/add', 'Modules\OpenMVM\User\Controllers\BackEnd\User::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users/(:any)', 'Modules\OpenMVM\User\Controllers\BackEnd\User::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/users', 'Modules\OpenMVM\User\Controllers\BackEnd\User::index');


// FrontEnd

// Address
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/edit/(:num)/(:any)', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/edit/(:num)', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::edit');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/add/(:any)', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/add', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/(:any)', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/address/', 'Modules\OpenMVM\User\Controllers\FrontEnd\UserAddress::index');

// Profile
$routes->match(['get', 'post', 'patch', 'delete'], '/account/profile/(:any)', 'Modules\OpenMVM\User\Controllers\FrontEnd\Profile::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/profile', 'Modules\OpenMVM\User\Controllers\FrontEnd\Profile::index');

// Account
$routes->match(['get', 'post', 'patch', 'delete'], '/account/(:any)', 'Modules\OpenMVM\User\Controllers\FrontEnd\Account::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account', 'Modules\OpenMVM\User\Controllers\FrontEnd\Account::index');

// Login
$routes->match(['get', 'post', 'patch', 'delete'], '/logout', 'Modules\OpenMVM\User\Controllers\FrontEnd\Logout::index');

// Login
$routes->match(['get', 'post', 'patch', 'delete'], '/login', 'Modules\OpenMVM\User\Controllers\FrontEnd\Login::index');

// Register
$routes->match(['get', 'post', 'patch', 'delete'], '/register/error', 'Modules\OpenMVM\User\Controllers\FrontEnd\Register::error');
$routes->match(['get', 'post', 'patch', 'delete'], '/register/success', 'Modules\OpenMVM\User\Controllers\FrontEnd\Register::success');
$routes->match(['get', 'post', 'patch', 'delete'], '/register', 'Modules\OpenMVM\User\Controllers\FrontEnd\Register::index');

