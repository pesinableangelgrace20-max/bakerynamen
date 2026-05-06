<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- 1. Authentication Routes ---
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('loginAuth', 'AuthController::loginAuth');
$routes->get('register', 'AuthController::register');
$routes->post('register/store', 'AuthController::store');
$routes->get('logout', 'AuthController::logout');

// --- 2. Admin ---
$routes->group('admin', function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('products', 'ProductController::index');

    $routes->get('stock', 'StockController::index');

    $routes->get('sales', 'SaleController::index');
    $routes->post('sales/store', 'SaleController::store');
    $routes->get('sales/receipt/(:num)', 'SaleController::receipt/$1');
    $routes->get('sales/delete/(:num)', 'SaleController::delete/$1');

    $routes->get('reports', 'ReportsController::index');
    $routes->get('reports/export', 'ReportsController::exportCsv');

    $routes->get('users', 'UserController::index');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');

    $routes->post('product/store', 'ProductController::store');
    $routes->get('product/edit/(:num)', 'ProductController::edit/$1');
    $routes->post('product/update/(:num)', 'ProductController::update/$1');
    $routes->get('product/delete/(:num)', 'ProductController::delete/$1');
});
