<?php

/* 
 * these are routes specific to the users module
 */

$route['unitisation/portfolio/new'] = 'portfolio/addNewPortfolio'; 
$route['unitisation/portfolio/(:any)/view'] = 'portfolio/viewPortfolio/$1'; 
$route['unitisation/portfolio/(:any)/edit'] = 'portfolio/editPortfolio/$1'; 


$route['unitisation/valuation/upload'] = 'valuation/uploadPortfolioValuation'; 

//$route['product/update/(:num)'] = 'products/update/$1'; //show edit form and update the data
//$route['product/delete/(:num)'] = 'products/delete/$1'; //delete form display
//
//
//$route['product/(:num)/options'] = 'product_options/index/$1'; //lists all product_options
//$route['product/(:num)/create'] = 'product_options/create/$1'; //create product_options_form display
//$route['product/(:num)/update/(:num)'] = 'product_options/update/$1/$2'; //edit product_options_form display
//$route['product/(:num)/delete/(:num)'] = 'product_options/delete/$1/$2'; //delete form display

?>