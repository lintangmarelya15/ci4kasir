<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/produk', 'Produk::index');
$routes->post('/produk/simpan', 'Produk::simpan_produk');
$routes->get('/produk/tampil', 'Produk::tampil_produk');
$routes->post('/produk/hapus/(:num)', 'Produk::hapus_produk/$1');
$routes->get('/produk/detail/(:num)', 'Produk::detail/$1');
$routes->post('/produk/updateProduk', 'Produk::updateProduk');


$routes->get('/tampil', 'Pelanggan::index');
$routes->get('pelanggan/tampil', 'Pelanggan::tampil_pelanggan');
$routes->post('pelanggan/simpan', 'Pelanggan::simpan_pelanggan');
$routes->post('pelanggan/hapus/(:num)', 'Pelanggan::hapus/$1');
$routes->get('pelanggan/edit/(:num)', 'Pelanggan::detail/$1');
$routes->post('pelanggan/update', 'Pelanggan::updatePelanggan');
