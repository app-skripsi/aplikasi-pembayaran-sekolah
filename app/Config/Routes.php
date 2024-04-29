<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::fe');
$routes->get('/bayar-spp', 'Home::paymentSpp');
$routes->get('/index', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->post('authentication','Home::authentication');
$routes->get('/logout','Home::logout');

$routes->get('guru', 'GuruController::index');
$routes->get('guru/create', 'GuruController::create');
$routes->post('guru/store', 'GuruController::store');
$routes->get('guru/edit/(:alphanum)', 'GuruController::edit/$1');
$routes->post('guru/update/(:num)', 'GuruController::update/$1');
$routes->get('guru/delete/(:alphanum)', 'GuruController::delete/$1');

$routes->get('siswa', 'SiswaController::index');
$routes->get('siswa/create', 'SiswaController::create');
$routes->post('siswa/store', 'SiswaController::store');
$routes->get('siswa/edit/(:alphanum)', 'SiswaController::edit/$1');
$routes->post('siswa/update/(:num)', 'SiswaController::update/$1');
$routes->get('siswa/delete/(:alphanum)', 'SiswaController::delete/$1');

$routes->get('pelajaran', 'PelajaranController::index');
$routes->get('pelajaran/create', 'PelajaranController::create');
$routes->post('pelajaran/store', 'PelajaranController::store');
$routes->get('pelajaran/edit/(:alphanum)', 'PelajaranController::edit/$1');
$routes->post('pelajaran/update/(:num)', 'PelajaranController::update/$1');
$routes->get('pelajaran/delete/(:alphanum)', 'PelajaranController::delete/$1');

$routes->get('spp', 'SppController::index');
$routes->get('spp/create', 'SppController::create');
$routes->post('spp/store', 'SppController::store');
$routes->get('spp/edit/(:alphanum)', 'SppController::edit/$1');
$routes->post('spp/update/(:num)', 'SppController::update/$1');
$routes->get('spp/delete/(:alphanum)', 'SppController::delete/$1');

$routes->get('pengajian', 'PengajianController::index');
$routes->get('pengajian/create', 'PengajianController::create');
$routes->post('pengajian/store', 'PengajianController::store');
$routes->get('pengajian/edit/(:alphanum)', 'PengajianController::edit/$1');
$routes->post('pengajian/update/(:num)', 'PengajianController::update/$1');
$routes->get('pengajian/delete/(:alphanum)', 'PengajianController::delete/$1');

$routes->get('kelas', 'KelasController::index');
$routes->get('kelas/create', 'KelasController::create');
$routes->post('kelas/store', 'KelasController::store');
$routes->get('kelas/edit/(:alphanum)', 'KelasController::edit/$1');
$routes->post('kelas/update/(:num)', 'KelasController::update/$1');
$routes->get('kelas/delete/(:alphanum)', 'KelasController::delete/$1');
//
