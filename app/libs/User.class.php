<?php

class User
{
	private $_db,
			$_data,
			$_sessionname,
			$_cookiename,
			$_isLoggedIn;
	function __construct($user = null)
	{
		$this->_db = dbConnector::getInstance();
		
		$this->_sessionname = Config::get('session/session_name');
		$this->_cookiename = Config::get('remember/cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionname)) {
				$user = Session::get($this->_sessionname);
				
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//process Logout
				}
			}
		} else {
			$this->find($user);
		}
	}

	public function create($fields = array())
	{
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating an Account');
		}
	}

	public function find($user = null)
	{
		if ($user) {
			$field = (is_numeric($user)) ? 'user_id' : 'user_name';
			$data = $this->_db->get('users', array($field, '=', $user));
			
			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false)
	{
		
		if(!$username && !$password && $this->exists()) {
			Session::put($this->_sessionname, $this->data()->user_id);
		} else {
			$user = $this->find($username);

			if ($user) {
				if ($this->data()->user_pass === Hash::make($password, $this->data()->user_salt)) {
					Session::put($this->_sessionname, $this->data()->user_id);

					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->user_id));

						if (!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'user_id' 		=> $this->data()->user_id,
								'session_hash' 	=> $hash
							));
						} else {
							$hash = $hashCheck->first()->session_hash;
						}
						Cookie::put($this->_cookiename, $hash, Config::get('remember/cookie_expiry'));
					}

					return true;
				}
			}
		}
		return false;
	}

	public function exists()
	{
		return (!empty($this->data())) ? true : false;
	}

	public function logout()
	{
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->user_id));
		Session::delete($this->_sessionname);
		Cookie::delete($this->_cookiename);
	}

	public function data()
	{
		return $this->_data;
	}

	public function isLoggedIn()
	{
		return $this->_isLoggedIn;
	}
}

?>