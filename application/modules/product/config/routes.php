<?php

/* 
 * these are routes specific to the users module
 */

$route['product'] = 'products/index'; //lists all products
$route['product/create'] = 'products/create'; //add form display and create a new product
$route['product/(:num)/update'] = 'products/update/$1'; //show edit form and update the data
$route['product/(:num)/delete'] = 'products/delete/$1'; //delete form display
$route['product/(:num)/view'] = 'products/view/$1'; //View all form display


$route['product/type'] = 'product_type/index/'; //lists all product_type
$route['product/type/create'] = 'product_type/create'; //add form display and create a new product type
$route['product/type/(:num)/update'] = 'product_type/update/$1'; //show edit form and update the data
$route['product/type/(:num)/delete'] = 'product_type/delete/$1'; //delete selected  product_type


$route['product/provider'] = 'product_provider/index/'; //lists all product_provider
$route['product/provider/create'] = 'product_provider/create'; //add form display and create a new product provider
$route['product/provider/(:num)/update'] = 'product_provider/update/$1'; //show edit form and update the data
$route['product/provider/(:num)/delete'] = 'product_provider/delete/$1'; //delete selected  product_provider



?>