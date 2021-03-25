<?php

// BackEnd
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/setting/(:any)', 'Modules\OpenMVM\Setting\Controllers\BackEnd\Setting::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/setting', 'Modules\OpenMVM\Setting\Controllers\BackEnd\Setting::index');
