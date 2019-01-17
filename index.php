<?php
$site_path = __DIR__.DIRECTORY_SEPARATOR;
define('SITE_PATH', $site_path);
$site_host=$_SERVER['HTTP_HOST'];
define('SITE_HOST', $site_host);

include_once SITE_PATH.'includes'.DIRECTORY_SEPARATOR.'startup.php';

$registry = new Registry;

$template = new Template($registry);
$registry['template']=$template;

$user = new User($registry);
$registry['user']=$user;

$router = new Router($registry);
$registry['router']=$router;
$router->setPath(SITE_PATH.'controllers');
$router->delegate();
?>
