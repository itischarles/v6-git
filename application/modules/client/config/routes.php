<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$route['client'] = 'client/index';
$route['client/create'] = 'client/create';
//$route['client/search'] = 'client/search';
$route['client/(:any)/update'] = 'client/update/$1';
$route['client/(:any)/applications'] = 'client/list_applications/$1';
$route['client/(:any)/view'] = 'client/view/$1';
$route['client/(:any)/edit'] = 'client/update/$1';