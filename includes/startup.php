<?php
error_reporting (E_ALL);
if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }

function __autoload($class_name)
{
	$filename = strtolower($class_name).'.php';
	$file = SITE_PATH.'classes/'.$filename;

	if(file_exists($file) == false){
			return false;
	}
	include_once $file;
}

$site_path = dirname(dirname(__FILE__)).'/';
define('SITE_PATH', $site_path);
$site_host=$_SERVER['HTTP_HOST'];//Хост
define('SITE_HOST', $site_host);

$registry = new Registry;
?>