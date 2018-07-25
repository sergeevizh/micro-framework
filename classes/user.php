<?php
Class User
{
	private $registry;
	private $DB;
	private $pdb;
	private $vars = array();

	function __construct($registry)
	{
		$this->registry = $registry;
		$this->DB = &$registry['DB'];
		$this->pdb = $registry['pdb'];

		if(!empty($_POST['user_login']) && !empty($_POST['btnLogin'])){
			//Вход, проверяем данные
			$user_login=trim($_POST['user_login']);
			$user_pwd=md5(trim($_POST['user_pwd']));
			
			if(!empty($user_login)&&!empty($user_pwd)){
				//Берем из БД юзера id,pwd,stat,type по введённому логину
				$stmt=$this->DB->query('SELECT * FROM '.$this->pdb.'user WHERE login="'.$user_login.'" LIMIT 0,1');
				if($stmt->rowCount()){
					$user_all_in_db=$stmt->fetchAll(PDO::FETCH_ASSOC);
					$user_data=&$user_all_in_db[0];
					
					if($user_pwd==$user_data['pwd']){
						$this->parse($user_data);
						
						setcookie('user_login', $this->vars['login'], time() + 93312000);
						setcookie('user_pwd', $this->vars['pwd'], time() + 93312000);
						
						$url='http://'.SITE_HOST;
						if(!empty($_POST['user_url'])){
							$url.=$_POST['user_url'];
						}
						header("Location: ".$url);
					}else{
						$this->registry['template']->error='Вы неверно ввели пароль';
					}
				}else{
					$this->registry['template']->error='Пользователь с таким логином не зарегистрирован';
				}
			}else{
				$this->registry['template']->error='Вы не ввели логин или пароль';
			}
		}else{
			if(!empty($_COOKIE['user_login']) && !empty($_COOKIE['user_pwd'])){
				$user_login=$_COOKIE['user_login'];
				$user_pwd=$_COOKIE['user_pwd'];

				$stmt=$this->DB->query('SELECT * FROM '.$this->pdb.'user WHERE login="'.$user_login.'" LIMIT 0,1');
				if($stmt->rowCount()){
					$user_all_in_db=$stmt->fetchAll(PDO::FETCH_ASSOC);
					$user_data=&$user_all_in_db[0];
					
					if($user_pwd==$user_data['pwd']){
						$this->parse($user_data);
					}else{
						//Очищаем куки
					}
				}else{
					//Очищаем куки
				}
			}
		}
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
	function parse($user_data){
		$this->vars['id']=$user_data['id'];
		$this->vars['login']=$user_data['login'];
		$this->vars['pwd']=$user_data['pwd'];
		$this->vars['type']=$user_data['type'];
		$this->vars['email']=$user_data['email'];
		$this->vars['stat']=$user_data['stat'];
	}
}
?>