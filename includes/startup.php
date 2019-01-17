<?php
error_reporting (E_ALL);
if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }

include_once SITE_PATH.'config'.DIRECTORY_SEPARATOR.'mysql.php';

$DB = new PDO('mysql:host='.$db_host.';dbname='.$db_base, $db_user, $db_pass);
$registry['DB']=$DB;
$registry['pdb']=$pdb;

function __autoload($class_name)
{
	$filename = strtolower($class_name).'.php';
	$file = SITE_PATH.'classes/'.$filename;

	if(file_exists($file) == false){
			return false;
	}
	include_once $file;
}
?>
