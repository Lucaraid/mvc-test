<?php

	class Profile extends Controller
	{
		public function __construct()
		{

		}
		public function index()
		{
			$this->model('login_Model');
			$this->view('login/index');
		}
		public function register()
		{
			$model = $this->model('Login_Model');
			$errors = $model->Register();
			$this->view('login/register', $errors);
		}
		public function run()
		{
			//form submitted;

		}
		public function login()
		{
			$model = $this->model('Login_Model');
			$errors = $model->Login();
			$this->view('login/login', $errors);
		}
		public function logout()
		{
			$model = $this->model('Login_Model');
			$errors = $model->Logout();
			Redirect::to('profile/index');
		}
		public function profile()
		{
			$this->model('login_Model');
			$this->view('login/index');
		}
		public function update()
		{
			$model = $this->model('Login_Model');
			$errors = $model->Update();
			$this->view('login/update', $errors);
		}
		public function changepassword()
		{
			
		}
	}

?>