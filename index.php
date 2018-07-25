<?php
include_once 'includes/startup.php';

include_once SITE_PATH.'config/mysql.php';
$DB = new PDO('mysql:host='.$db_host.';dbname='.$db_base, $db_user, $db_pass);
$registry['DB']=$DB;
$registry['pdb']=$pdb;

$template = new Template($registry);
$registry['template']=$template;

$user = new User($registry);
$registry['user']=$user;

$router = new Router($registry);
$registry['router']=$router;
$router->setPath(SITE_PATH.'controllers');
$router->delegate();
?>