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

$routes->get('pengajian', 'PengajianController::index');
$routes->get('pengajian/create', 'PengajianController::create');
$routes->post('pengajian/store', 'PengajianController::store');
$routes->get('pengajian/edit/(:alphanum)', 'PengajianController::edit/$1');
$routes->post('pengajian/update/(:num)', 'PengajianController::update/$1');
$routes->get('pengajian/delete/(:alphanum)', 'PengajianController::delete/$1');

//
