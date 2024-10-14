<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Public routes
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login'); // Ensure this route is defined correctly
$routes->get('auth/logout', 'Auth::logout');

// Protected routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
   //barang
   $routes->get('Barang', 'Barang::index');
   $routes->get('Transaksi', 'Transaksi::index');
   $routes->get('/TambahBarang', 'Barang::TambahBarang');
   $routes->get('/UbahBarang(:num)', 'Barang::GetBarangByID/$1');
   $routes->post('/Barang/UbahBarang', 'Barang::UbahBarang');
   $routes->post('Barang/simpanBarang', 'Barang::simpanBarang'); 
   $routes->get('/HapusBarang/(:num)', 'Barang::HapusBarang/$1');

   //transaksi
    $routes->get('Transaksi', 'Transaksi::index');
    $routes->get('/TambahTransaksi', 'Transaksi::TambahTransaksi'); // Add this line for TambahTransaksi
    $routes->post('Transaksi/simpanTransaksi', 'Transaksi::simpanTransaksi'); // Route for saving transaction
    $routes->get('/UbahTransaksi(:num)', 'Transaksi::GetTransaksiByID/$1');
    $routes->post('/Transaksi/UbahTransaksi', 'Transaksi::UbahTransaksi');
    $routes->get('Transaksi/Detail/(:num)', 'Transaksi::detail/$1');
    $routes->get('/HapusTransaksi/(:num)', 'Transaksi::HapusTransaksi/$1');


   //pengguna
   $routes->get('Pengguna', 'Pengguna::index');
   $routes->post('/updatePengguna/(:any)', 'Pengguna::updatePengguna/$1');
   $routes->get('/Ubahpengguna(:any)', 'Pengguna::getPengguna/$1');
   $routes->get('/HapusPengguna/(:any)', 'Pengguna::HapusPengguna/$1');
   $routes->get('/TambahPengguna', 'Pengguna::TambahPengguna');
   $routes->post('/Pengguna/simpanPengguna', 'Pengguna::SimpanPengguna');

   
   
});

// Admin routes
$routes->group('', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('Karyawan', 'Karyawan::index');
    // Add more admin-specific routes here
});