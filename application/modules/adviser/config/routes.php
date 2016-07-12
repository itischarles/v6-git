<?php

/* 
 * these are routes specific to the adviser module
 */

$route['adviser/register'] = 'registration/selfRegister';
$route['adviser/clients'] = 'adviser/listAdviserClients';
$route['adviser/create-client'] = 'adviser/createClient';
$route['adviser/list-advisers'] = 'adviser/listAdvisers';
$route['adviser/edit/(:any)'] = 'adviser/eidtAdviser/$1';

?>
