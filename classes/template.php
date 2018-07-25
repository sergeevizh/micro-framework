<?php
Class Template
{
	private $registry;
	private $vars = array();

	function __construct($registry)
	{
		$this->registry = $registry;
	}
	function __set($key, $var)
	{
		if (isset($this->vars[$key]) == true) {
			trigger_error ('Unable to set var "' . $key . '". Already set.', E_USER_NOTICE);
			return false;
        }
        $this->vars[$key] = $var;
        return true;
	}
	function __get($key)
	{
		if (isset($this->vars[$key]) == false) {
			return null;
		}
		return $this->vars[$key];
	}
	function render($name)
	{
        $path = SITE_PATH.'templates/'.$name.'.php';
        if (file_exists($path) == false) {
			trigger_error ('Template "'.$name.'" does not exist.', E_USER_NOTICE);
			return false;
        }
        // Load variables
        foreach ($this->vars as $key => $value) {
			$$key = $value;
        }
        include_once $path;
	}
}
?>