<?php

	require_once('../app/config/global.php');
	require_once('../app/libs/functions.php');
	spl_autoload_register(function($class){
		require_once('../app/libs/' . $class . '.class.php');
	});

?>