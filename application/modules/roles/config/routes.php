<?php

$route['roles/(:num)/permisssions'] = 'Auth_role_perm/displayRolePermission_form/$1';
$route['roles/(:num)/module/(:num)/update-permissions'] = 'Auth_role_perm/processRolePermissions/$1/$2';

$route['roles/user/(:any)/update-roles'] = 'Auth_user_role/updateUsersRoles/$1';




?>