<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['admin/login'] = 'admin/admins/login';
$route['admin/logout'] = 'admin/admins/logout';
$route['admin'] = 'admin/dashboard/index';
$route['admin/admins/(:num)'] = 'admin/admins/view/$1';
$route['admin/admins/edit/(:num)'] = 'admin/admins/edit/$1';

$route['search'] = 'home/search';

$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = '';
$route['404'] = '';