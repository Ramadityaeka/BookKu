<?php

namespace Config;

use CodeIgniter\Config\Services;
use CodeIgniter\Router\RouteCollection;

// @var RouteCollection $routes

// Define a route for images in writable/uploads
$routes->get('uploads/(:any)', function($filename) {
    $path = WRITEPATH . 'uploads/' . $filename;
    if (file_exists($path)) {
        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});

// Default route
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->get('login', 'Home::login');
$routes->post('auth', 'Home::authenticate');
$routes->get('logout', 'Home::logout');

// Public Routes
$routes->group('', function($routes) {
    $routes->get('catalog', 'Home::catalog');
    $routes->get('detail/(:num)', 'Home::detail/$1');
    $routes->get('article/(:num)', 'Home::article/$1');
    $routes->post('article/search', 'Home::search');
    $routes->get('informasi-booking', 'BookingController::info');
    $routes->post('booking/store', 'BookingController::store');
    $routes->get('Kontak', 'Home::kontak');
});

// Admin Routes (all protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard Routes
    $routes->get('', 'Admin\DashboardController::index'); // Default admin route
    $routes->get('dashboard', 'Admin\DashboardController::index');
    
    // Article Management Routes
    $routes->get('articles/create', 'Admin\DashboardController::createArticle');
    $routes->post('articles/store', 'Admin\DashboardController::storeArticle');
    $routes->get('articles/edit/(:num)', 'Admin\DashboardController::editArticle/$1');
    $routes->post('articles/update/(:num)', 'Admin\DashboardController::updateArticle/$1');
    $routes->post('articles/delete/(:num)', 'Admin\DashboardController::deleteArticle/$1');
    
    // Booking Management Routes
    $routes->get('bookings', 'Admin\BookingsController::index');
    $routes->post('bookings/status-update/(:num)', 'Admin\BookingsController::statusUpdate/$1');
    $routes->post('bookings/delete/(:num)', 'Admin\BookingsController::delete/$1');
});

// Redirect dashboard to admin dashboard
$routes->get('dashboard', function() {
    return redirect()->to(base_url('admin/dashboard'));
});

// API Routes
$routes->get('getArticle/(:num)', 'Home::getArticle/$1', ['filter' => 'auth']);
