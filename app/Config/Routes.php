<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.

// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');

$routes->get('users', 'Users::index');
$routes->get('users/getUsers', 'Users::getUsers');
$routes->get('users/view/(:num)', 'Users::view/$1');
$routes->get('users/viewImage/(:num)', 'Users::viewImage/$1');
$routes->get('users/image/(:any)', 'Users::image/$1');
$routes->post('users/uploadImage', 'Users::uploadImage');

$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->get('users/create', 'Users::create');
$routes->post('users/store', 'Users::store');
$routes->post('users/update', 'Users::update');
$routes->get('users/delete/(:num)', 'Users::delete/$1');
$routes->post('users/delete/(:num)', 'Users::delete/$1');
$routes->get('users/restoreUser/(:num)', 'Users::restoreUser/$1');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
