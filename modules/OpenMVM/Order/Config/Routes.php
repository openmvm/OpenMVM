<?php

// FrontEnd

// Orders
$routes->match(['get', 'post', 'patch', 'delete'], '/account/orders/info/(:any)/(:any)', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Order::info');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/orders/(:any)', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Order::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/account/orders', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Order::index');

// Widgets
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/checkout_cart/success/(:any)', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\CheckoutCart::success');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/checkout_cart/success', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\CheckoutCart::success');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/checkout_cart/set', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\CheckoutCart::set');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/checkout_cart', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\CheckoutCart::index');

$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/shipping_method/set', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\ShippingMethod::set');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/shipping_method', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\ShippingMethod::index');

$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/payment_method/set', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\PaymentMethod::set');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/payment_method', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\PaymentMethod::index');

$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/shipping_address/set', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\ShippingAddress::set');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/shipping_address/add', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\ShippingAddress::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/shipping_address', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\ShippingAddress::index');

$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/payment_address/set', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\PaymentAddress::set');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/payment_address/add', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\PaymentAddress::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/order/checkout/widget/payment_address', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\PaymentAddress::index');

$routes->match(['get', 'post', 'patch', 'delete'], '/widget/cart/info', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets\Cart::info');

// Cart
$routes->match(['get', 'post', 'patch', 'delete'], '/cart/add', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Cart::add');
$routes->match(['get', 'post', 'patch', 'delete'], '/cart', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Cart::index');

// Checkout
$routes->match(['get', 'post', 'patch', 'delete'], '/checkout/(:any)', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Checkout::index');
$routes->match(['get', 'post', 'patch', 'delete'], '/checkout', 'Modules\OpenMVM\Order\Controllers\FrontEnd\Checkout::index');
