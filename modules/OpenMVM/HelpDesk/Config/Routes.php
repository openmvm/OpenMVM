<?php

// FrontEnd

// Contact Us
$routes->match(['get', 'post', 'patch', 'delete'], '/contact_us/error', 'Modules\OpenMVM\HelpDesk\Controllers\FrontEnd\Contact::error');
$routes->match(['get', 'post', 'patch', 'delete'], '/contact_us/success', 'Modules\OpenMVM\HelpDesk\Controllers\FrontEnd\Contact::success');
$routes->match(['get', 'post', 'patch', 'delete'], '/contact_us', 'Modules\OpenMVM\HelpDesk\Controllers\FrontEnd\Contact::index');

