<?php

// BackEnd

// Order Status
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/order_statuses', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\OrderStatus::index');

// Length Class
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/length_classes', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\LengthClass::index');

// Weight Class
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/weight_classes', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\WeightClass::index');

// Currency
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/get_country/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::getCountry');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/get_country', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::getCountry');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/currencies', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Currency::index');

// Language
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/get_district/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::getDistrict');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/get_district', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::getDistrict');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/languages', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Language::index');

// District
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/get_district/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::getDistrict');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/get_district', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::getDistrict');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/districts', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\District::index');

// City
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/get_city/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::getCity');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/get_city', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::getCity');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/cities', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\City::index');

// State
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/get_state/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::getState');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/get_state', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::getState');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/states', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\State::index');

// Country
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/get_country/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::getCountry');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/get_country', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::getCountry');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/edit/(:num)/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/edit/(:num)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::edit');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/add/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/add', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::add');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries/(:any)', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/localisation/countries', 'Modules\OpenMVM\Localisation\Controllers\BackEnd\Country::index');

// FrontEnd

// Localisation
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/get_district', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Localisation::getDistrict');
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/get_city', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Localisation::getCity');
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/get_state', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Localisation::getState');
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/get_country', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Localisation::getCountry');

// Currency
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/widget/currency/set_currency', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets\Currency::setCurrency');

// Language
$routes->match(['get', 'post', 'patch', 'delete'], '/localisation/widget/language/set_language', 'Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets\Language::setLanguage');
