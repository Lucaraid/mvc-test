<?php

	class Controller
	{
		public function model($model)
		{
			require_once('../app/models/' . $model . '.php');
			return new $model();
		}
		public function view($view, $data = [], $noInclude = false)
		{
			if($noInclude == true)
			{
				require_once('../app/views/' . $view . '.php');
			}
			else{
				require_once('../app/views/header.php');
				require_once('../app/views/' . $view . '.php');
				require_once('../app/views/footer.php');
			}
		}
	}

?>