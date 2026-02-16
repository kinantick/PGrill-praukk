<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('testdb', 'TestDb::index');

//route auth
$routes->get('/', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

//dashboard
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

//route untuk filter role ke dashboard
$routes->group('/alat', ['filter' => 'auth'], function($routes){

    //admin dan petugas
    $routes->get('/', 'AlatController::index', ['filter' => 'role:Admin,Petugas']);

    //peminjam 
    $routes->get('tersedia', 'AlatController::tersedia', ['filter' => 'role:Peminjam']);
});

//route Alat
$routes->get('/alat/create', 'AlatController::create', ['filter' => 'role:Admin']);
$routes->post('/alat/store', 'AlatController::store', ['filter' => 'role:Admin']);
$routes->get('/alat/edit/(:num)', 'AlatController::edit/$1', ['filter' => 'role:Admin']);
$routes->post('/alat/update/(:num)', 'AlatController::update/$1', ['filter' => 'role:Admin']);
$routes->get('/alat/delete/(:num)', 'AlatController::delete/$1', ['filter' => 'role:Admin']);

// Trash Alat
$routes->get('/alat/trash', 'AlatController::trash', ['filter' => 'role:Admin']);
$routes->get('/alat/restore/(:num)', 'AlatController::restore/$1', ['filter' => 'role:Admin']);
$routes->get('/alat/permanent-delete/(:num)', 'AlatController::permanentDelete/$1', ['filter' => 'role:Admin']);
$routes->get('/alat/empty-trash', 'AlatController::emptyTrash', ['filter' => 'role:Admin']);

//route peminjaman
$routes->group('peminjaman', ['filter' => 'auth'], function($routes){
    $routes->get('/', 'PeminjamanController::index');
    $routes->get('create', 'PeminjamanController::create');
    $routes->post('store', 'PeminjamanController::store');
    $routes->get('edit/(:num)', 'PeminjamanController::edit/$1', ['filter' => 'role:Petugas']);
    $routes->post('update/(:num)', 'PeminjamanController::update/$1', ['filter' => 'role:Petugas']);
});

//route profile
$routes->group('profile', ['filter' => 'auth'], function($routes){
    $routes->get('/', 'ProfileController::index');
    $routes->get('edit', 'ProfileController::edit');
    $routes->post('update', 'ProfileController::update');
});

$routes->group('peminjaman', function($routes) {

    // PEMINJAM (AJUKAN PENGEMBALIAN)
    $routes->post('kembalikan/(:num)', 'PeminjamanController::kembalikan/$1');

    // PETUGAS (CEK DETAIL PENGEMBALIAN)
    $routes->get('cek-pengembalian/(:num)', 'PeminjamanController::cekPengembalian/$1');

    // PETUGAS (VALIDASI PENGEMBALIAN)
    $routes->post('selesai/(:num)', 'PeminjamanController::selesai/$1');

});



// manajemen user (admin & petugas)
$routes->group('user', ['filter' => 'auth'], function($routes) {

    // lihat data user
    $routes->get('/', 'UserController::index', ['filter' => 'role:Admin,Petugas']);

    // khusus admin
    $routes->get('create', 'UserController::create', ['filter' => 'role:Admin']);
    $routes->post('store', 'UserController::store', ['filter' => 'role:Admin']);

    $routes->get('edit/(:num)', 'UserController::edit/$1', ['filter' => 'role:Admin']);
    $routes->post('update/(:num)', 'UserController::update/$1', ['filter' => 'role:Admin']);

    $routes->get('delete/(:num)', 'UserController::delete/$1', ['filter' => 'role:Admin']);
});

// activity log (admin only)
$routes->group('activity-log', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ActivityLogController::index', ['filter' => 'role:Admin']);
    $routes->post('clear', 'ActivityLogController::clear', ['filter' => 'role:Admin']);
});

