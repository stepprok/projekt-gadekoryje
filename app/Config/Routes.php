<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//routy pro zobrazení
$routes->get('/', 'typKomponentC::index');
$routes->get('/druha/(:any)', 'KomponentC::index/$1');
$routes->get('/treti/(:num)', 'KomponentC::show/$1');
$routes->get('/pridat', 'Pridat::index');
$routes->get('/import', 'Pridat::show');
$routes->get('/edit/more', 'typKomponentC::edit');


//routy pro změny v databázi
$routes->post('/user/save', 'typKomponentC::add');
$routes->post('/user/edit', 'typKomponentC::update/$1');       
$routes->get('/vymazat/(:num)', 'typKomponentC::delete/$1');
$routes->post('/user/saveK', 'KomponentC::add');
$routes->post('/import/update' , 'Pridat::update');
$routes->get('/ex/pdf/(:num)', 'ExportPDF::index/$1');
$routes->get('/ex/xml/', 'ExcelXML::index');
$routes->post('/pridatItem/(:num)', 'KomponentC::update/$id');