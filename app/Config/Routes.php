<?php

namespace Config;

use CodeIgniter\Config\Services;
use CodeIgniter\Router\RouteCollection;

// ... (kode untuk route 'uploads' tidak berubah) ...
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


// Health check route
$routes->get('/health', 'HealthController::index');

// Controller utama untuk halaman publik
$routes->get('/', 'Home::index');
$routes->get('catalog', 'Home::catalog');
$routes->get('detail/(:num)', 'Home::detail/$1');
$routes->get('article/(:num)', 'Home::article/$1');
$routes->post('article/search', 'Home::search');
$routes->get('kontak', 'Home::kontak');
$routes->get('events', 'EventController::index');
$routes->get('events/detail/(:num)', 'EventController::detail/$1');



// Authentication Routes (Gunakan AuthController)
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->post('auth', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// User-specific routes (WAJIB LOGIN)
$routes->group('', ['filter' => 'login'], function($routes) {
    $routes->get('informasi-booking', 'BookingController::info');
    $routes->post('booking/store', 'BookingController::store');
});

// Admin Routes (protected by auth filter)
$routes->group('admin', ['filter' => 'login'], function($routes) {
    // ... (rute admin tidak ada perubahan) ...
    $routes->get('', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->post('articles/store', 'Admin\DashboardController::storeArticle');
    $routes->post('articles/update/(:num)', 'Admin\DashboardController::updateArticle/$1');
    $routes->post('articles/delete/(:num)', 'Admin\DashboardController::deleteArticle/$1');
    $routes->get('articles/get/(:num)', 'Admin\DashboardController::getArticle/$1');
    $routes->get('bookings', 'Admin\BookingsController::index');
    $routes->post('bookings/status-update/(:num)', 'Admin\BookingsController::statusUpdate/$1');
    $routes->post('bookings/delete/(:num)', 'Admin\BookingsController::delete/$1');
    $routes->get('events', 'Admin\EventController::index');
    $routes->post('events/store', 'Admin\EventController::store');
    $routes->post('events/update/(:num)', 'Admin\EventController::update/$1');
    $routes->post('events/delete/(:num)', 'Admin\EventController::delete/$1');
    $routes->get('events/get/(:num)', 'Admin\EventController::getEvent/$1');
});


// API Route
$routes->get('getArticle/(:num)', 'Home::getArticle/$1', ['filter' => 'auth']);