<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('products', 'Product::index');
$routes->post('products/store', 'Product::store');
$routes->post('products/update/(:num)', 'Product::update/$1');
$routes->get('products/delete/(:num)', 'Product::delete/$1');

$routes->get('users', 'User::index');
$routes->post('users/store', 'User::store');
$routes->post('users/update/(:num)', 'User::update/$1');
$routes->get('users/delete/(:num)', 'User::delete/$1');

$routes->get('transactions', 'Transaction::index');
$routes->post('transactions/store', 'Transaction::store');
// $routes->get('transactions', 'Transaction::index');
