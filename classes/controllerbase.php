<?php
Abstract Class ControllerBase
{
	protected $registry;
	function __construct($registry)
	{
		$this->registry = $registry;
	}
	abstract function index();
}
?>