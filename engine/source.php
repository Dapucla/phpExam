<?php
include 'libs.php';

/**
 *  SOURCE
 */
class controller
{
	function init_model($file, $route, $access_level){
		if (isset($route) && isset($file) && isset($access_level)){
			require 'config.php';
			$check = new id_user("auth_perx");
			switch ($access_level) {
				case 'guest':
					if (!$check->auth_status()){
						require 'models/'.$file.".php";
					}else{
						$route->err_code = 401;
						header("Location: /");
					}
					break;
				case 'auth':
					if ($check->auth_status()){
						$user_data = $_SESSION["auth_perx"];
						require 'models/'.$file.".php";
					}else{
						$route->err_code = 401;
						header("Location: /account/signin/");
					}
					break;
				case 'public':
					require 'models/'.$file.".php";
					break;
				case 'admin':
					if ($check->admin_status()){
						require 'models/'.$file.".php";
					}else{
						$route->err_code = 401;
						header("Location: /");
					}
					break;
			}
			if (isset($route->init)){
				if ($route->init == "init_view"){
					require $route->init_view;
				} elseif ($route->init == "init_view_head") {
					require $route->init_head;
					require $route->init_view;
				}else {
					echo "Неизвестная ошибка инициализации!";
				}
			}else {
				ob_end_clean();
				echo "Ошибка инициализации View компонента!";
				exit();
			}
		}else {
			ob_end_clean();
			exit();
		}
	}
	function init_view($route, $view_model, $head, $head_file){
		if (!$head) {
			$route->init = "init_view";
		}else if ($head) {
			$route->init = "init_view_head";
			$route->init_head = 'views/header/'.$head_file.'.php';
		}
		$route->init_view = 'views/'.$view_model.'.php';
	}
}
/**
 * identification user
 */
class id_user
{
	public $session_code;
	function __construct($session_code)
	{
		$this->session_code = $session_code;
	}
	function auth_status(){
		if (isset($_SESSION[$this->session_code])){
			return true;
		}else {
			return false;
		}
	}
	function auth_remove(){
		if (isset($_SESSION[$this->session_code])){
			return true;
		}else {
			return false;
		}
	}
	function admin_status(){
		if (isset($_SESSION[$this->session_code])){
			if ($_SESSION[$this->session_code]->admin == "true"){
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
}
?>