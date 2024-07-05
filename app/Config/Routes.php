<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('authentication','Home::authentication');
$routes->get('/', 'Home::fe');
$routes->post('authentication', 'Home::cek_login');
$routes->get('/logout', 'Home::logout');


$routes->get('/bayar-spp', 'Home::paymentSpp');
$routes->get('/index', 'Home::index');
$routes->get('/dashboard', 'Home::viewDashboard');
$routes->get('/login', 'Home::login');
$routes->get('/logout','Home::logout');
$routes->get('/error', 'Home::error');
$routes->get('/finish', 'Home::finish');
$routes->get('/unfinish', 'Home::unfinish');

$routes->post('spp/store', 'SppController::store');
$routes->post('spp/update/(:num)', 'SppController::update/$1');
$routes->post('spp/searchByNamaSiswa', 'SppController::searchSppByNamaSiswa');
$routes->get('spp', 'SppController::index');
$routes->get('spp/create', 'SppController::create');
$routes->get('spp/edit/(:alphanum)', 'SppController::edit/$1');
$routes->get('spp/delete/(:alphanum)', 'SppController::delete/$1');
$routes->get('spp/pdf/(:num)', 'SppController::pdf/$1');
$routes->get('spp/excel', 'SppController::excel');
$routes->get('spp/halaman-pembayaran','Home::halamanPembayaran/$1');

$routes->post('pengajian/store', 'PengajianController::store');
$routes->post('pengajian/update/(:num)', 'PengajianController::update/$1');
$routes->get('pengajian', 'PengajianController::index');
$routes->get('pengajian/create', 'PengajianController::create');
$routes->get('pengajian/edit/(:alphanum)', 'PengajianController::edit/$1');
$routes->get('pengajian/delete/(:num)', 'PengajianController::delete/$1');
$routes->get('pengajian/pdf/(:num)', 'PengajianController::pdf/$1');
$routes->get('pengajian/xls','PengajianController::excel');

$routes->post('guru/store', 'GuruController::store');
$routes->post('guru/update/(:num)', 'GuruController::update/$1');
$routes->get('guru', 'GuruController::index');
$routes->get('guru/create', 'GuruController::create');
$routes->get('guru/edit/(:alphanum)', 'GuruController::edit/$1');
$routes->get('guru/delete/(:alphanum)', 'GuruController::delete/$1');

$routes->post('siswa/store', 'SiswaController::store');
$routes->post('siswa/update/(:num)', 'SiswaController::update/$1');
$routes->get('siswa', 'SiswaController::index');
$routes->get('siswa/create', 'SiswaController::create');
$routes->get('siswa/edit/(:alphanum)', 'SiswaController::edit/$1');
$routes->get('siswa/delete/(:num)', 'SiswaController::delete/$1');

$routes->post('kelas/store', 'KelasController::store');
$routes->post('kelas/update/(:num)', 'KelasController::update/$1');
$routes->get('kelas', 'KelasController::index');
$routes->get('kelas/create', 'KelasController::create');
$routes->get('kelas/edit/(:alphanum)', 'KelasController::edit/$1');
$routes->get('kelas/delete/(:alphanum)', 'KelasController::delete/$1');
