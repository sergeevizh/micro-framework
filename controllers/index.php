<?php
Class ControllerIndex Extends ControllerBase
{
    function index()
    {
        $this->registry['template']->status='ok';
        $this->registry['template']->render('json');
	}
	function test()
	{
        $this->registry['template']->status='fail';
        $this->registry['template']->render('json');
	}
}
?>