<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'login::login_action');
$routes->get('logout', 'Login::logout');
$routes->get('admin/home', 'Admin\Home::index', ['filter' => 'adminFilter']);
$routes->get('admin/pengguna', 'Admin\Pengguna::index', ['filter' => 'adminFilter']);
$routes->get('admin/pengguna/tambah', 'Admin\Pengguna::tambah', ['filter' => 'adminFilter']);
$routes->post('admin/pengguna/simpan', 'Admin\Pengguna::simpan', ['filter' => 'adminFilter']);
$routes->get('admin/pengguna/edit/(:any)', 'Admin\Pengguna::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/pengguna/update/(:any)', 'Admin\Pengguna::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/pengguna/hapus/(:any)', 'Admin\Pengguna::hapus/$1', ['filter' => 'adminFilter']);


$routes->get('admin/ruangan', 'Admin\Ruangan::index', ['filter' => 'adminFilter']);
$routes->get('admin/ruangan/tambah', 'Admin\Ruangan::tambah', ['filter' => 'adminFilter']);
$routes->post('admin/ruangan/simpan', 'Admin\Ruangan::simpan', ['filter' => 'adminFilter']);
$routes->get('admin/ruangan/edit/(:segment)', 'Admin\Ruangan::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/ruangan/update/(:segment)', 'Admin\Ruangan::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/ruangan/hapus/(:segment)', 'Admin\Ruangan::hapus/$1', ['filter' => 'adminFilter']);

$routes->get('admin/jadwal', 'Admin\Jadwal::index', ['filter' => 'adminFilter']);
$routes->get('admin/jadwal/tambah', 'Admin\Jadwal::tambah', ['filter' => 'adminFilter']);
$routes->post('admin/jadwal/simpan', 'Admin\Jadwal::simpan', ['filter' => 'adminFilter']);
$routes->get('admin/jadwal/edit/(:segment)', 'Admin\Jadwal::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/jadwal/update/(:segment)', 'Admin\Jadwal::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/jadwal/hapus/(:segment)', 'Admin\Jadwal::hapus/$1', ['filter' => 'adminFilter']);

$routes->get('admin/dosen', 'Admin\Dosen::index', ['filter' => 'adminFilter']);
$routes->get('admin/dosen/tambah', 'Admin\Dosen::tambah', ['filter' => 'adminFilter']);
$routes->post('admin/dosen/simpan', 'Admin\Dosen::simpan', ['filter' => 'adminFilter']);
$routes->get('admin/dosen/edit/(:segment)', 'Admin\Dosen::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/dosen/update/(:segment)', 'Admin\Dosen::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/dosen/hapus/(:segment)', 'Admin\Dosen::hapus/$1', ['filter' => 'adminFilter']);

$routes->get('dosen/home', 'Dosen\Home::index', ['filter' => 'dosenFilter']);
$routes->post('dosen/home/batalkan', 'Dosen\Home::batalkan');
$routes->post('/dosen/absen', 'Dosen\Home::absen');
$routes->post('dosen/absen-keluar', 'Dosen\Home::absenKeluar');
$routes->post('dosen/konfirmasi-kehadiran', 'Dosen\Home::konfirmasiKehadiran');
$routes->get('dosen/jadwal', 'Dosen\Jadwal::index', ['filter' => 'dosenFilter']);
$routes->get('dosen/jadwal/create', 'Dosen\Jadwal::create', ['filter' => 'dosenFilter']);
$routes->post('dosen/jadwal/store', 'Dosen\Jadwal::store', ['filter' => 'dosenFilter']);
$routes->get('dosen/jadwal/edit/(:segment)', 'Dosen\Jadwal::edit/$1', ['filter' => 'dosenFilter']);
$routes->post('dosen/jadwal/update/(:segment)', 'Dosen\Jadwal::edit/$1', ['filter' => 'dosenFilter']);
$routes->get('dosen/jadwal/delete/(:segment)', 'Dosen\Jadwal::delete/$1', ['filter' => 'dosenFilter']);

$routes->get('dosen/jadwal/pesan/(:segment)', 'Dosen\Jadwal::formPesan/$1');
$routes->post('dosen/jadwal/pesan', 'Dosen\Jadwal::prosesPesan');

$routes->get('dosen/profil', 'Dosen\Profil::index', ['filter' => 'dosenFilter']);
$routes->get('dosen/profil/edit/(:segment)', 'Dosen\Profil::edit/$1', ['filter' => 'dosenFilter']);
$routes->post('dosen/profil/update', 'Dosen\Profil::update', ['filter' => 'dosenFilter']);




$routes->get('firebase/test', 'FirebaseController::testConnection');
