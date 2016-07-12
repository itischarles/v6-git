<?php

/* 
 * these are routes specific to the users module
 */

$route['user'] = 'user/index';
$route['user/search'] = 'user/search';
$route['user/update/(:any)'] = 'user/update/$1';
$route['user/create'] = 'user/create';
$route['user/(:any)'] = 'user/index/$1';
//echo "<pre>";
//print_r($route);
?>
