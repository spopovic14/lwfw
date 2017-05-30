<?php

namespace Core\Http;

class Request
{
	public static function getUrl()
	{
		$url = $_SERVER['REQUEST_URI'];

		$url = trim(str_replace(APP_NAME, '', $url), '/');

		return $url;
	}

	public static function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public static function getProtocol()
	{
		return $_SERVER['SERVER_PROTOCOL'];
	}

	public static function getAuthUser()
	{
		if(!isset($_SERVER['PHP_AUTH_USER']))
		{
			return null;
		}
		return $_SERVER['PHP_AUTH_USER'];
	}

	public static function getAuthPass()
	{
		if(!isset($_SERVER['PHP_AUTH_PW']))
		{
			return null;
		}
		return $_SERVER['PHP_AUTH_PW'];
	}

	public static function getAuthType()
	{
		return $_SERVER['AUTH_TYPE'];
	}


}