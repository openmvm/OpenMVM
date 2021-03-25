<?php

// BackEnd

// Administrator Groups
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups/edit/(:num)/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups/edit/(:num)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups/add/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups/add', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrator/groups', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\AdministratorGroup::index');

// Administrators
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators/edit/(:num)/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators/edit/(:num)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators/add/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators/add', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/administrators', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Administrator::index');

// Dashboard
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/dashboard/(:any)', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Dashboard::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/dashboard', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Dashboard::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'], 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Dashboard::index');

// Logout
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/logout', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Logout::index');

// Login
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/login', 'Modules\OpenMVM\Administrator\Controllers\BackEnd\Login::index');
