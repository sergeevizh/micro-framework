<?php
Class Router
{
	private $registry;
	private $path;
	private $args = array();
	
	function __construct($registry)
	{
		$this->registry = $registry;
	}
	function setPath($path) {
		$path = trim($path, '/\\');
		$path .= '/';
		if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: "' . $path . '"');
        }
		$this->path = $path;
	}
	function delegate()
	{
        // Анализируем путь
        $this->getController($file, $controller, $action, $id, $args);
		// Файл доступен?
        if (is_readable($file) == false) {
        	//404 error
			header("HTTP/1.0 404 Not Found");
			$this->registry['template']->render('404');
			exit();
        }
		
		// Подключаем файл
        include_once $file;
        
        // Создаём экземпляр контроллера
        $class = 'Controller' . ucfirst($controller);
        $controller = new $class($this->registry);

        // Действие доступно?
        if (is_callable(array($controller, $action)) == false) {
			if($file == 'index'){
				$action = 'inner';
			}else{
				//404 error
				header("HTTP/1.0 404 Not Found");
				$this->registry['template']->render('404');
				exit();
			}
        }

        // Выполняем действие
        $controller->$action();
	}
	private function getController(&$file, &$controller, &$action, &$id, &$args)
	{
		$route = (empty($_GET['route'])) ? '' : $_GET['route'];
		if (empty($route)) {
			$route = 'index';
		}
		
		// Получаем раздельные части
		$route = trim($route, '/\\');
		$parts = explode('/', $route);

		// Находим правильный контроллер
		$cmd_path = $this->path;

		foreach ($parts as $part) {
			$fullpath = $cmd_path . $part;
			
			// Есть ли папка с таким путём?
			if (is_dir($fullpath)) {
				$cmd_path .= $part.'/';
				$controller = $part;
				array_shift($parts);
				continue;
			}
			
			// Находим файл
			if (is_file($fullpath . '.php')) {
				$controller = $part;
				array_shift($parts);
				break;
			}
		}
		if (empty($controller)) {
			$controller = 'index';
		};
	
		// Получаем действие
		$id=array_shift($parts);
		$action=array_shift($parts);
		if(empty($action)){
			$action=$id;
			if(empty($action)){
				$action='index';
			}
			unset($id);
		}
		
		$file=$cmd_path.$controller.'.php';
		$args=$parts;
		$this->registry['template']->page=$controller;
	}
}
?>