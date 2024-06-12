<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::fe');
$routes->get('/bayar-spp', 'Home::paymentSpp');
$routes->get('/index', 'Home::index');
$routes->get('/dashboard', 'Home::viewDashboard');
$routes->get('/login', 'Home::login');
$routes->post('authentication','Home::authentication');
$routes->get('/logout','Home::logout');

$routes->get('spp', 'SppController::index');
$routes->get('spp/create', 'SppController::create');
$routes->post('spp/store', 'SppController::store');
$routes->get('spp/edit/(:alphanum)', 'SppController::edit/$1');
$routes->post('spp/update/(:num)', 'SppController::update/$1');
$routes->get('spp/delete/(:alphanum)', 'SppController::delete/$1');
$routes->post('spp/searchByNamaSiswa', 'SppController::searchSppByNamaSiswa');
#$routes->post('spp/createMidtransTransaction/(:segment)', 'SppController::createMidtransTransaction/$1');
$routes->get('spp/createMidtransTransaction/(:segment)', 'SppController::createMidtransTransaction/$1');


// Ensure the necessary routes for Midtrans callbacks are set up
$routes->post('midtrans/notification', 'MidtransController::notification');
$routes->get('midtrans/completed', 'MidtransController::completed');
$routes->get('midtrans/failed', 'MidtransController::failed');
$routes->get('midtrans/unfinish', 'MidtransController::unfinish');

$routes->get('pengajian', 'PengajianController::index');
$routes->get('pengajian/create', 'PengajianController::create');
$routes->post('pengajian/store', 'PengajianController::store');
$routes->get('pengajian/edit/(:alphanum)', 'PengajianController::edit/$1');
$routes->post('pengajian/update/(:num)', 'PengajianController::update/$1');
$routes->get('pengajian/delete/(:num)', 'PengajianController::delete/$1');

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
$routes->get('siswa/delete/(:num)', 'SiswaController::delete/$1');

$routes->get('kelas', 'KelasController::index');
$routes->get('kelas/create', 'KelasController::create');
$routes->post('kelas/store', 'KelasController::store');
$routes->get('kelas/edit/(:alphanum)', 'KelasController::edit/$1');
$routes->post('kelas/update/(:num)', 'KelasController::update/$1');
$routes->get('kelas/delete/(:alphanum)', 'KelasController::delete/$1');

//
