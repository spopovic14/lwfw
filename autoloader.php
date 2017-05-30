<?php

function __autoload($class_name)
{
	if(file_exists(BASE_DIR . $class_name . '.php'))
	{
		require BASE_DIR . $class_name . '.php';
		return true;
	}
	return false;
}