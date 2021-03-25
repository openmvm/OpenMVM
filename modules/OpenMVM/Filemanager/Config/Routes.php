<?php

// BackEnd
// Filemanager Delete
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/delete/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::delete');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/delete', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::delete');
// Filemanager Clear Cache
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/clear_cache/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::clearCache');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/clear_cache', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::clearCache');
// Filemanager Download
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/download/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::download');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/download', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::download');
// Filemanager Compress
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/compress/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::compress');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/compress', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::compress');
// Filemanager Upload
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/upload/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::upload');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/upload', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::upload');
// Filemanager Create Directory
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/create_directory/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::createDirectory');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/create_directory', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::createDirectory');
// Filemanager Contents
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/contents/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getContents');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/contents', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getContents');
// Filemanager PopUp
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/popup/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getPopUp');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/popup', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getPopUp');
// Filemanager Workspace
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/workspace/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getWorkspace');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/workspace', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::getWorkspace');
// Filemanager Main
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::index');
$routes->match(['get', 'post', 'patch', 'delete'], $_SERVER['app.adminDir'] . '/filemanager', 'Modules\OpenMVM\Filemanager\Controllers\BackEnd\Filemanager::index');


// FrontEnd
// Filemanager Delete
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/delete/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::delete');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/delete', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::delete');
// Filemanager Clear Cache
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/clear_cache/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::clearCache');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/clear_cache', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::clearCache');
// Filemanager Download
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/download/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::download');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/download', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::download');
// Filemanager Compress
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/compress/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::compress');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/compress', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::compress');
// Filemanager Upload
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/upload/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::upload');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/upload', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::upload');
// Filemanager Create Directory
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/create_directory/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::createDirectory');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/create_directory', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::createDirectory');
// Filemanager Contents
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/contents/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getContents');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/contents', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getContents');
// Filemanager PopUp
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/popup/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getPopUp');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/popup', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getPopUp');
// Filemanager Workspace
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/workspace/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getWorkspace');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/workspace', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::getWorkspace');
// Filemanager Main
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager/(:any)', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/filemanager', 'Modules\OpenMVM\Filemanager\Controllers\FrontEnd\Filemanager::index');
