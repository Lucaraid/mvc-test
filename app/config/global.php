<?php

$GLOBALS['config'] = array(
	'mysql'				=> 	array(
		'type'				=>	'mysql',		// Datenbank Typ
		'host'				=>	'127.0.0.1',	// Datenbank Host
		'port'				=>	'3306', 		// Datenbank Port
		'config_db'			=>	'config', 		// Datenbank Name (Configs)
		'user'				=>	'root',			// Datenbank Benutzer
		'pass'				=>	''				// Datenbank Passwort
	),
	'paths'				=> 	array(
		'Url'				=> 	'http://localhost/oop-website/',
		'PublicUrl'			=>	'public/'
	),
	'remember'			=>	array(
		'cookie_name'		=>	'hash',
		'cookie_expiry'		=>	604800
	),
	'session'			=>	array(
		'session_name' 		=> 'user',
		'token_name'		=> 'token'
	)
);

?>