<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// --- 1. ROUTES PUBLIK (BISA DIAKSES TANPA LOGIN) ---
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::store');
$routes->get('logout', 'Auth::logout');


// --- 2. ROUTES TERPROTEKSI (WAJIB LOGIN) ---
// Grup ini menggunakan filter 'auth' untuk mencegat user yang belum login
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Halaman Utama Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Modul Manajemen Akun / Profil
    $routes->group('account', function($routes) {
        $routes->get('/', 'Profile::profile');
        $routes->post('/', 'Profile::update');
    });

    $routes->group('settings', function($routes) {
        $routes->get('/', 'SettingController::index');
        $routes->post('update', 'SettingController::update');
    });

    // --- MODUL TICKETING HELPDESK (PT HUMANIKA) ---
    $routes->group('tickets', function($routes) {
        $routes->get('/', 'TicketController::index');
        $routes->get('show/(:num)', 'TicketController::show/$1');
        $routes->post('store', 'TicketController::store');
        $routes->get('edit/(:num)', 'TicketController::edit/$1');
        $routes->post('update/(:num)', 'TicketController::update/$1');
        $routes->post('delete/(:num)', 'TicketController::delete/$1');
        $routes->post('comment/(:num)', 'TicketController::addComment/$1');
        $routes->post('update-status/(:num)', 'TicketController::updateStatus/$1');
        $routes->post('triage/(:num)', 'TicketController::triage/$1');
        $routes->post('develop/tickets/triage/(:num)', 'TicketController::triage/$1');
    });

    // Route langsung untuk form Triage dari view (site_url('develop/tickets/triage/ID'))
    $routes->post('develop/tickets/triage/(:num)', 'TicketController::triage/$1');

    $routes->group('companies', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'CompanyController::index');
        $routes->post('store', 'CompanyController::store');
        $routes->get('edit/(:num)', 'CompanyController::edit/$1');
        $routes->post('update/(:num)', 'CompanyController::update/$1');
        $routes->post('delete/(:num)', 'CompanyController::delete/$1');
    });

    // Modul SLA Management
    $routes->group('sla', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'SlaController::index');
        $routes->post('store', 'SlaController::store');
        $routes->get('edit/(:num)', 'SlaController::edit/$1');
        $routes->post('update/(:num)', 'SlaController::update/$1');
        $routes->post('delete/(:num)', 'SlaController::delete/$1');
    });

     // Manajemen Pengguna
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('create', 'UserController::create');
        $routes->post('store', 'UserController::store');
        $routes->get('edit/(:num)', 'UserController::edit/$1'); // Tambah ini
        $routes->post('update/(:num)', 'UserController::update/$1'); // Tambah ini
        $routes->post('delete/(:num)', 'UserController::delete/$1'); // Tambah ini
        $routes->post('force-logout/(:num)', 'UserController::forceLogout/$1');
    });

    $routes->group('categories', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'CategoryController::index');
        $routes->post('store', 'CategoryController::store');
        $routes->get('edit/(:num)', 'CategoryController::edit/$1');
        $routes->post('update/(:num)', 'CategoryController::update/$1');
        $routes->post('delete/(:num)', 'CategoryController::delete/$1');
    });

    // Menu Admin Lainnya
    $routes->get('services', 'Dashboard::services');
    $routes->get('reports', 'Dashboard::reports');
    $routes->get('settings', 'Dashboard::settings');
});

$routes->group('client/report', ['namespace' => 'App\Controllers\Client', 'filter' => 'auth'], function($routes) {
    $routes->get('/', 'TicketSubmit::index');       // Halaman Form
    $routes->post('store', 'TicketSubmit::store');
});

$routes->group('knowledge', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'KnowledgeController::index');
    $routes->get('artikel/(:any)', 'KnowledgeController::show/$1');
    $routes->get('manage', 'KnowledgeController::manage');
    $routes->get('form', 'KnowledgeController::form');
    $routes->get('form/(:num)', 'KnowledgeController::form/$1');
    $routes->post('save', 'KnowledgeController::save');
    $routes->post('delete/(:num)', 'KnowledgeController::delete/$1');
    $routes->get('kategori/(:num)', 'KnowledgeController::kategori/$1');
}); 
   


// $routes->get('admin/knowledge-base', 'Dashboard::knowledge');
// $routes->get('admin/settings', 'Dashboard::settings');
// $routes->get('admin/tickets', 'Dashboard::tickets');
// $routes->get('admin/services', 'Dashboard::services');
// $routes->get('admin/reports', 'Dashboard::reports');

// $routes->get('admin/customers', 'UserController::index');