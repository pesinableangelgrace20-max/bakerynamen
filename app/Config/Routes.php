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

// --- 2. Admin Dashboard & Navigation ---
$routes->group('admin', function($routes) {
    
    // Main Sections
    $routes->get('/', 'AdminController::index');       
    $routes->get('stock', 'AdminController::stock');   
    $routes->get('sales', 'AdminController::sales');   
    $routes->get('reports', 'AdminController::reports'); 
    $routes->get('users', 'AdminController::users');   

    // Product CRUD
    $routes->post('product/store', 'AdminController::storeProduct');
    $routes->get('product/edit/(:num)', 'AdminController::editProduct/$1');
    $routes->post('product/update/(:num)', 'AdminController::updateProduct/$1');
    $routes->get('product/delete/(:num)', 'AdminController::deleteProduct/$1');

    // SALES ACTION (This matches your URL /admin/sales/store)
    $routes->post('sales/store', 'AdminController::storeSale');

    // User CRUD
    $routes->post('users/store', 'AdminController::storeUser');
    $routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
    $routes->post('users/update/(:num)', 'AdminController::updateUser/$1');
    $routes->get('users/delete/(:num)', 'AdminController::deleteUser/$1');
});