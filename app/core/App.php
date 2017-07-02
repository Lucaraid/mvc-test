<?php

	class App
	{
		/************* Default Config *************/
			//Default Controller called
			protected $controller = 'home';
			// Default Method called
			protected $method = 'index';
			// Default Parameters given
			protected $params = [];
		/******************************************/

		public function __construct()
		{
			// Default Paths
			require_once('../app/config/paths.php');

			// Database Connection
			require_once('../app/libs/dbConnector.class.php');
			$url = $this->ParseURL();

			// Login
			if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
				$hash = Cookie::get(Config::get('remember/cookie_name'));
				$hashCheck = dbConnector::getInstance()->get('users_session', array('session_hash', '=', $hash));

				if ($hashCheck->count()) {
					$user = new User($hashCheck->first()->user_id);
					$user->login();
				}
			}

			// Load controller
			if (file_exists('../app/controllers/' . $url[0] . '.php'))
			{
				$this->controller = $url[0];
				unset($url[0]);
			}

			require_once('../app/controllers/' . $this->controller . '.php');

			if(class_exists($this->controller))
			{
				$this->controller = new $this->controller;
			}else{
				echo 'Class not found';
			}

			if(isset($url[1]))
			{
				if (method_exists($this->controller, $url[1])) {
					$this->method = $url[1];
					unset($url[1]);
				}
			}

			if ($url)
			{
				$this->params = array_values($url);
			}

			if(method_exists($this->controller, $this->method))
			{
				call_user_func_array([$this->controller, $this->method], $this->params);
			}else{
				echo 'site not found';
			}
		}
		public function ParseURL()
		{
			if (isset($_GET['url']))
			{
				$url = rtrim($_GET['url'], '/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				return $url;
			}
		}
	}

?>
