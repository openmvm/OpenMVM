<?php

// FrontEnd

// Home
$routes->match(['get', 'post', 'patch', 'delete'], '/home/(:any)', 'Modules\OpenMVM\Common\Controllers\FrontEnd\Dashboard::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/home', 'Modules\OpenMVM\Common\Controllers\FrontEnd\Dashboard::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/', 'Modules\OpenMVM\Common\Controllers\FrontEnd\Home::index');
