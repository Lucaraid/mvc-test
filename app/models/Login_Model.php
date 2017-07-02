<?php

	class Login_Model
	{
		function __construct()
		{

		}

		public function Register()
		{
			if (Input::exists()) {
				if (Token::check(Input::get('token'))) {
					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'user_name' 		=> array(
							'name'				=> 'Username',
							'required'			=> true,
							'min'				=> 2,
							'max'				=> 30,
							'unique'			=> 'users'
						),
						'user_pass' 		=> array(
							'name'				=> 'Password',
							'required'			=> true,
							'min'				=> 6,
						),
						'repeat_user_pass' 	=> array(
							'name'				=> 'Password repeat',
							'required'			=> true,
							'matches'			=> 'user_pass'
						),
						'user_fullname' 	=> array(
							'name'				=> 'Name',
							'required'			=> true,
							'min'				=> 2,
							'max'				=> 50
						)
					));
					if ($validation->passed()) {
						$user = new User();

						$salt = Hash::salt(32);

						try {
							$user->create(array(
								'user_name' 	=> Input::get('user_name'),
								'user_pass' 	=> Hash::make(Input::get('user_pass'), $salt),
								'user_salt' 	=> $salt,
								'user_fullname'	=> Input::get('user_fullname'),
								'user_joined' 	=> date('Y-m-d H:i:s'),
								'user_group' 	=> 1
							));
							Session::flash('home', 'You have been registered and can now log in!');
							Redirect::to('profile/index');
						} catch (Exception $e) {
							die($e->getMessage());
						}
					} else {
						foreach ($validation->errors() as $error) {
							$errors[] = $error;
						}
						return $errors;
					}
				}
			}
		}

		public function Login()
		{
			if (Input::exists()) {
				if (Token::check(Input::get('token'))) {
					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'user_name' 		=> array(
							'name'				=> 'Username',
							'required'			=> true
						),
						'user_pass' 		=> array(
							'name'				=> 'Password',
							'required'			=> true
						)
					));
					if ($validation->passed()) {
						$user = new User();

						$remember = (Input::get('remember') === 'on') ? true : false;
						$login = $user->login(Input::get('user_name'), Input::get('user_pass'), $remember);

						if ($login) {
							Redirect::to('profile/index');
						} else {
							$errors[] = "<p>Sorry loggin in failed!</p>";
							return $errors;
						}
					} else {
						foreach ($validation->errors() as $error) {
							$errors[] = $error;
						}
						return $errors;
					}
				}
			}
		}

		public function Logout()
		{
			$user = new User();
			$user->logout();
		}
		public function Update()
		{
			$user = new User();
			if (!$user->isLoggedIn()) {
				Redirect::to('profile/index');
			}
		}
	}

?>