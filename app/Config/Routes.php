<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
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
$routes->get('/', 'Auth::index', ['as' => 'login']);
$routes->post('/', 'Auth::store', ['as' => 'loginStore']);
$routes->get('/logout', 'Auth::destroy', ['as' => 'loginDestroy']);
$routes->get('/signup', 'Auth::signupIndex', ['as' => 'viewSignUp']);
$routes->get('/recoverPassword', 'Auth::recoverPasswordIndex', ['as' => 'viewRecoverPassword']);
$routes->get('/reset/(:alphanum)', 'Auth::resetPasswordIndex/$1', ['as' => 'viewResetPassword']);
$routes->post('/reset/(:alphanum)', 'Auth::resetPasswordStore/$1', ['as' => 'resetPassword', 'filter' => 'csrf']);
$routes->post('/signup', 'Auth::signupStore', ['as' => 'signUp', 'filter' => 'csrf']);
$routes->post('/recoverPassword', 'Auth::recoverPasswordStore', ['as' => 'recoverPassword', 'filter' => 'csrf']);

$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Modulos\FaturasDuplicadas::index', ['as' => 'home']);
});

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
if (is_file(APPPATH.'Config/'.ENVIRONMENT.'/Routes.php')) {
    require APPPATH.'Config/'.ENVIRONMENT.'/Routes.php';
}
